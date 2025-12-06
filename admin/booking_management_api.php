<?php
// booking_management_api.php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Database configuration
$host = '127.0.0.1';
$dbname = 'inandout';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Handle GET request - Fetch bookings and analytics
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_bookings') {

    // Add status column if it doesn't exist
    try {
        $pdo->exec("ALTER TABLE bookings ADD COLUMN IF NOT EXISTS status ENUM('pending', 'approved', 'declined') DEFAULT 'pending'");
    } catch (PDOException $e) {
        // Column might already exist, continue
    }

    // Fetch all bookings
    $stmt = $pdo->prepare("
        SELECT 
            id,
            booking_ref,
            service,
            price,
            booking_date,
            booking_time,
            customer_name,
            customer_email,
            customer_phone,
            customer_address,
            customer_city,
            customer_state,
            customer_zip,
            notes,
            COALESCE(status, 'pending') as status,
            created_at
        FROM bookings
        ORDER BY created_at DESC
    ");
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Process booking dates
    foreach ($bookings as &$booking) {
        // Convert booking_date (day of month) to full date
        if (!empty($booking['created_at'])) {
            $createdDate = new DateTime($booking['created_at']);
            $year = $createdDate->format('Y');
            $month = $createdDate->format('m');
            $day = str_pad($booking['booking_date'], 2, '0', STR_PAD_LEFT);
            $booking['booking_date'] = "$year-$month-$day";
        }
    }

    // Calculate analytics
    $analytics = [];

    // Total bookings
    $analytics['total_bookings'] = count($bookings);

    // Status counts
    $statusCounts = array_count_values(array_column($bookings, 'status'));
    $analytics['pending_count'] = $statusCounts['pending'] ?? 0;
    $analytics['approved_count'] = $statusCounts['approved'] ?? 0;
    $analytics['declined_count'] = $statusCounts['declined'] ?? 0;

    // Total revenue (only approved bookings)
    $approvedBookings = array_filter($bookings, function ($b) {
        return $b['status'] === 'approved';
    });
    $analytics['total_revenue'] = array_sum(array_column($approvedBookings, 'price'));

    // Average booking value
    $analytics['avg_booking'] = $analytics['total_bookings'] > 0
        ? $analytics['total_revenue'] / count($approvedBookings)
        : 0;

    // Today's bookings
    $today = date('Y-m-d');
    $todayBookings = array_filter($bookings, function ($b) use ($today) {
        return substr($b['created_at'], 0, 10) === $today;
    });
    $analytics['today_count'] = count($todayBookings);

    // Monthly revenue for chart (last 6 months)
    $monthlyRevenue = [];
    for ($i = 5; $i >= 0; $i--) {
        $date = new DateTime();
        $date->modify("-$i months");
        $month = $date->format('Y-m');

        $monthTotal = 0;
        foreach ($bookings as $booking) {
            if (
                $booking['status'] === 'approved' &&
                substr($booking['created_at'], 0, 7) === $month
            ) {
                $monthTotal += floatval($booking['price']);
            }
        }

        $monthlyRevenue[] = [
            'month' => $month,
            'revenue' => $monthTotal
        ];
    }

    // Status distribution for chart
    $statusDistribution = [
        'pending' => $analytics['pending_count'],
        'approved' => $analytics['approved_count'],
        'declined' => $analytics['declined_count']
    ];

    echo json_encode([
        'success' => true,
        'bookings' => $bookings,
        'analytics' => $analytics,
        'charts' => [
            'monthly_revenue' => $monthlyRevenue,
            'status_distribution' => $statusDistribution
        ]
    ]);
    exit;
}

// Handle POST request - Update booking status and send email
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_booking') {

    $bookingId = intval($_POST['booking_id']);
    $bookingAction = $_POST['booking_action']; // 'approve' or 'decline'
    $emailMessage = $_POST['email_message'];

    // Validate inputs
    if (!in_array($bookingAction, ['approve', 'decline'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        exit;
    }

    $newStatus = $bookingAction === 'approve' ? 'approved' : 'declined';

    try {
        // Update booking status
        $stmt = $pdo->prepare("UPDATE bookings SET status = :status WHERE id = :id");
        $stmt->execute([
            ':status' => $newStatus,
            ':id' => $bookingId
        ]);

        // Fetch booking details for email
        $stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = :id");
        $stmt->execute([':id' => $bookingId]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$booking) {
            echo json_encode(['success' => false, 'message' => 'Booking not found']);
            exit;
        }

        // Send email notification
        $emailSent = sendBookingEmail($booking, $newStatus, $emailMessage);

        echo json_encode([
            'success' => true,
            'message' => "Booking {$newStatus} successfully",
            'email_sent' => $emailSent
        ]);

    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
    exit;
}

// Function to send email using PHPMailer
function sendBookingEmail($booking, $status, $customMessage)
{
    // Load PHPMailer
    require_once __DIR__ . '/../vendor/autoload.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Set your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'rohantaar34@gmail.com'; // SMTP username
        $mail->Password   = ''; // SMTP password - should be set via environment variable
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('rohantaar34@gmail.com', 'In & Out Cleaning');
        $mail->addAddress($booking['customer_email'], $booking['customer_name']);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $status === 'approved'
            ? 'Booking Approved - In & Out Cleaning'
            : 'Booking Update - In & Out Cleaning';

        // Create email body
        $emailBody = "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #3c5170; color: white; padding: 20px; text-align: center; }
                .content { background: #f9f9f9; padding: 30px; border: 1px solid #ddd; }
                .booking-details { background: white; padding: 20px; margin: 20px 0; border-radius: 5px; }
                .detail-row { padding: 10px 0; border-bottom: 1px solid #eee; }
                .detail-label { font-weight: bold; color: #3c5170; }
                .status-badge { 
                    display: inline-block;
                    padding: 5px 15px;
                    border-radius: 20px;
                    font-weight: bold;
                    margin: 10px 0;
                }
                .approved { background: #d1fae5; color: #065f46; }
                .declined { background: #fee2e2; color: #991b1b; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>In & Out Cleaning Experts</h1>
                    <p>Professional Cleaning Services</p>
                </div>
                
                <div class='content'>
                    <h2>Booking " . ucfirst($status) . "</h2>
                    
                    <div class='status-badge " . $status . "'>
                        Status: " . strtoupper($status) . "
                    </div>
                    
                    <p>" . nl2br(htmlspecialchars($customMessage)) . "</p>
                    
                    <div class='booking-details'>
                        <h3>Booking Details</h3>
                        <div class='detail-row'>
                            <span class='detail-label'>Booking Reference:</span> 
                            " . htmlspecialchars($booking['booking_ref']) . "
                        </div>
                        <div class='detail-row'>
                            <span class='detail-label'>Customer Name:</span> 
                            " . htmlspecialchars($booking['customer_name']) . "
                        </div>
                        <div class='detail-row'>
                            <span class='detail-label'>Service:</span> 
                            " . htmlspecialchars($booking['service']) . "
                        </div>
                        <div class='detail-row'>
                            <span class='detail-label'>Scheduled Time:</span> 
                            " . htmlspecialchars($booking['booking_time']) . "
                        </div>
                        <div class='detail-row'>
                            <span class='detail-label'>Amount:</span> 
                            $" . number_format($booking['price'], 2) . "
                        </div>
                        <div class='detail-row'>
                            <span class='detail-label'>Address:</span> 
                            " . htmlspecialchars($booking['customer_address']) . ", 
                            " . htmlspecialchars($booking['customer_city']) . ", 
                            " . htmlspecialchars($booking['customer_state']) . " 
                            " . htmlspecialchars($booking['customer_zip']) . "
                        </div>
                    </div>
                    
                    " . ($status === 'approved'
                ? "<p><strong>Next Steps:</strong> Our team will contact you within 24 hours to confirm all details and schedule your service.</p>"
                : "<p>If you have any questions or would like to reschedule, please don't hesitate to contact us.</p>") . "
                    
                    <p>
                        <strong>Contact Us:</strong><br>
                        Email: rohantaar34@gmail.com<br>
                        Phone: 09352632690
                    </p>
                </div>
                
                <div class='footer'>
                    <p>&copy; 2025 In & Out Cleaning Experts. All rights reserved.</p>
                    <p>Thank you for choosing our services!</p>
                </div>
            </div>
        </body>
        </html>
        ";

        $mail->Body = $emailBody;
        $mail->AltBody = strip_tags($emailBody);

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email sending failed: {$mail->ErrorInfo}");
        return false;
    }
}

// Invalid request
echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>