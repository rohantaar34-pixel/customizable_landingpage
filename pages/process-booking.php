<?php
// process-booking.php
header('Content-Type: application/json');

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader (if using Composer)
require '../vendor/autoload.php';

// Database configuration
$host = 'localhost';
$dbname = 'inandout';
$username = 'root';
$password = '';

try {
    // Create database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Validate required fields
    $required_fields = [
        'service',
        'booking_date',
        'booking_time',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'customer_city',
        'customer_state',
        'customer_zip'
    ];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            echo json_encode([
                'success' => false,
                'message' => 'Please fill in all required fields.'
            ]);
            exit;
        }
    }

    // Sanitize and validate inputs
    $service = trim($_POST['service']);
    $booking_date = intval($_POST['booking_date']);
    $booking_time = trim($_POST['booking_time']);
    $customer_name = trim($_POST['customer_name']);
    $customer_email = trim($_POST['customer_email']);
    $customer_phone = trim($_POST['customer_phone']);
    $customer_address = trim($_POST['customer_address']);
    $customer_city = trim($_POST['customer_city']);
    $customer_state = trim($_POST['customer_state']);
    $customer_zip = trim($_POST['customer_zip']);
    $notes = isset($_POST['notes']) ? trim($_POST['notes']) : '';

    // Get pricing information
    $estimated_subtotal = isset($_POST['estimated_subtotal']) ? floatval($_POST['estimated_subtotal']) : 0;
    $estimated_gst = isset($_POST['estimated_gst']) ? floatval($_POST['estimated_gst']) : 0;
    $estimated_total = isset($_POST['estimated_total']) ? floatval($_POST['estimated_total']) : 0;

    // Get selected addons
    $selected_addons = isset($_POST['selected_addons']) ? json_decode($_POST['selected_addons'], true) : [];

    // Validate email
    if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'success' => false,
            'message' => 'Please enter a valid email address.'
        ]);
        exit;
    }

    // Generate unique booking reference
    $booking_ref = 'BK' . date('Ymd') . strtoupper(substr(uniqid(), -6));

    // Insert booking into database
    $sql = "INSERT INTO bookings (
                booking_ref, service, booking_date, booking_time,
                customer_name, customer_email, customer_phone,
                customer_address, customer_city, customer_state, customer_zip,
                notes, price
            ) VALUES (
                :booking_ref, :service, :booking_date, :booking_time,
                :customer_name, :customer_email, :customer_phone,
                :customer_address, :customer_city, :customer_state, :customer_zip,
                :notes, :price
            )";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':booking_ref' => $booking_ref,
        ':service' => $service,
        ':booking_date' => $booking_date,
        ':booking_time' => $booking_time,
        ':customer_name' => $customer_name,
        ':customer_email' => $customer_email,
        ':customer_phone' => $customer_phone,
        ':customer_address' => $customer_address,
        ':customer_city' => $customer_city,
        ':customer_state' => $customer_state,
        ':customer_zip' => $customer_zip,
        ':notes' => $notes,
        ':price' => $estimated_total
    ]);

    // Send confirmation email
    $emailSent = sendConfirmationEmail(
        $customer_email,
        $customer_name,
        $booking_ref,
        $service,
        $booking_date,
        $booking_time,
        $customer_phone,
        $customer_address,
        $customer_city,
        $customer_state,
        $customer_zip,
        $notes,
        $selected_addons,
        $estimated_subtotal,
        $estimated_gst,
        $estimated_total
    );

    // Return success response
    echo json_encode([
        'success' => true,
        'booking_ref' => $booking_ref,
        'message' => 'Booking confirmed successfully!',
        'email_sent' => $emailSent
    ]);

} catch (PDOException $e) {
    // Log error (in production, use proper error logging)
    error_log('Booking Error: ' . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while processing your booking. Please try again.'
    ]);
} catch (Exception $e) {
    error_log('General Error: ' . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => 'An unexpected error occurred. Please try again.'
    ]);
}

/**
 * Send confirmation email to customer using PHPMailer
 */
function sendConfirmationEmail($email, $name, $booking_ref, $service, $date, $time, $phone, $address, $city, $state, $zip, $notes = '', $addons = [], $subtotal = 0, $gst = 0, $total = 0)
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rohantaar34@gmail.com';
        $mail->Password = 'oewp lcos mxgw famb';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('rohantaar34@gmail.com', 'In & Out Cleaning Services');
        $mail->addAddress($email, $name);
        $mail->addReplyTo('rohantaar34@gmail.com', 'Support');

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Booking Confirmation - $booking_ref";

        // Format the base price (subtotal minus addons)
        $addonsTotal = 0;
        if (!empty($addons)) {
            foreach ($addons as $addon) {
                $addonsTotal += floatval($addon['price']);
            }
        }
        $basePrice = $subtotal - $addonsTotal;

        // Format addons section
        $addonsSection = '';
        if (!empty($addons)) {
            $addonsList = array_map(function ($addon) {
                $addonPrice = floatval($addon['price']);
                return '<li style="margin: 8px 0; color: #555;">'
                    . htmlspecialchars($addon['name'])
                    . ' <span style="color: #fbb06b; font-weight: 600;">+$'
                    . number_format($addonPrice, 2)
                    . '</span></li>';
            }, $addons);

            $addonsSection = "
                <div class='booking-details'>
                    <h3>Selected Add-ons</h3>
                    <ul style='margin: 0; padding-left: 20px;'>
                        " . implode('', $addonsList) . "
                    </ul>
                </div>
            ";
        }

        // Format notes if provided
        $notesSection = '';
        if (!empty($notes)) {
            $notesSection = "
                <div class='booking-details'>
                    <h3>Special Instructions</h3>
                    <div class='notes-content'>
                        " . nl2br(htmlspecialchars($notes)) . "
                    </div>
                </div>
            ";
        }

        // Determine GST display
        $gstDisplay = ($gst == 0)
            ? '<span class="gst-free">GST FREE</span>'
            : '<span>$' . number_format($gst, 2) . '</span>';

        // Email body
        $mail->Body = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <style>
                body { 
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif; 
                    line-height: 1.7; 
                    color: #2c3e50; 
                    margin: 0;
                    padding: 0;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                }
                .email-wrapper {
                    padding: 40px 20px;
                }
                .container { 
                    max-width: 650px; 
                    margin: 0 auto; 
                    background-color: #ffffff;
                    border-radius: 16px;
                    overflow: hidden;
                    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                }
                .logo-section {
                    padding: 40px 20px;
                    text-align: center;
                    background: #fff;
                }
                .logo-section img {
                    max-width: 180px;
                    height: auto;
                    margin-bottom: 20px;
                }
                .header { 
                    background: linear-gradient(135deg, #fbb06b 0%, #f9a04f 100%);
                    color: white; 
                    padding: 35px 30px; 
                    text-align: center;
                    position: relative;
                }
                .header::before {
                    content: '✓';
                    font-size: 60px;
                    display: block;
                    margin-bottom: 10px;
                    opacity: 0.9;
                }
                .header h1 {
                    margin: 0;
                    font-size: 32px;
                    font-weight: 600;
                    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
                .header p {
                    margin: 10px 0 0 0;
                    font-size: 16px;
                    opacity: 0.95;
                }
                .content { 
                    padding: 40px 30px; 
                }
                .greeting {
                    font-size: 20px;
                    color: #3c5170;
                    margin-bottom: 15px;
                    font-weight: 600;
                }
                .intro-text {
                    font-size: 16px;
                    color: #555;
                    margin-bottom: 30px;
                }
                .reference-highlight {
                    background: linear-gradient(135deg, #fbb06b 0%, #f9a04f 100%);
                    color: white;
                    padding: 25px;
                    text-align: center;
                    border-radius: 12px;
                    margin: 30px 0;
                    box-shadow: 0 4px 15px rgba(251,176,107,0.3);
                }
                .reference-highlight .label {
                    font-size: 13px;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                    opacity: 0.9;
                    margin-bottom: 8px;
                }
                .reference-highlight strong {
                    font-size: 28px;
                    display: block;
                    font-weight: 700;
                    letter-spacing: 2px;
                }
                .booking-details { 
                    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                    padding: 25px; 
                    margin: 25px 0;
                    border-radius: 12px;
                    border-left: 5px solid #3c5170;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                }
                .booking-details h3 {
                    color: #3c5170;
                    margin: 0 0 20px 0;
                    font-size: 18px;
                    font-weight: 600;
                    display: flex;
                    align-items: center;
                }
                .booking-details h3::before {
                    content: '';
                    width: 4px;
                    height: 20px;
                    background-color: #fbb06b;
                    margin-right: 10px;
                    border-radius: 2px;
                }
                .booking-details ul {
                    margin: 0;
                    padding-left: 20px;
                    color: #555;
                }
                .booking-details ul li {
                    margin: 8px 0;
                }
                .detail-row { 
                    display: flex; 
                    justify-content: space-between;
                    align-items: flex-start;
                    padding: 15px 0; 
                    border-bottom: 1px solid rgba(0,0,0,0.06);
                }
                .detail-row:last-child {
                    border-bottom: none;
                }
                .detail-row strong {
                    color: #3c5170;
                    font-weight: 600;
                    font-size: 15px;
                    min-width: 150px;
                }
                .detail-row span {
                    text-align: right;
                    color: #555;
                    font-size: 15px;
                    flex: 1;
                }
                .price-breakdown {
                    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
                    border-left: 5px solid #4caf50;
                    padding: 25px;
                    margin: 25px 0;
                    border-radius: 12px;
                }
                .price-breakdown h3 {
                    color: #2e7d32;
                    margin: 0 0 20px 0;
                    font-size: 18px;
                    font-weight: 600;
                }
                .price-row {
                    display: flex;
                    justify-content: space-between;
                    padding: 10px 0;
                    color: #555;
                    align-items: center;
                }
                .price-row.total {
                    border-top: 2px solid #4caf50;
                    margin-top: 15px;
                    padding-top: 15px;
                    font-weight: 700;
                    font-size: 18px;
                    color: #2e7d32;
                }
                .gst-free {
                    background: #4caf50;
                    color: white;
                    padding: 4px 12px;
                    border-radius: 20px;
                    font-size: 13px;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }
                .disclaimer {
                    background: #fff3cd;
                    border-left: 5px solid #ffc107;
                    padding: 15px 20px;
                    margin: 20px 0;
                    border-radius: 8px;
                    font-size: 14px;
                    color: #856404;
                }
                .notes-content {
                    background: white;
                    padding: 15px;
                    border-radius: 8px;
                    color: #555;
                    font-size: 14px;
                    line-height: 1.6;
                }
                .info-box {
                    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
                    border-left: 5px solid #3c5170;
                    padding: 20px 25px;
                    margin: 25px 0;
                    border-radius: 8px;
                }
                .info-box strong {
                    color: #3c5170;
                    font-size: 16px;
                    display: block;
                    margin-bottom: 12px;
                }
                .info-box ul {
                    margin: 0;
                    padding-left: 20px;
                    color: #555;
                }
                .info-box li {
                    margin: 8px 0;
                    line-height: 1.6;
                }
                .contact-section {
                    background-color: #f8f9fa;
                    padding: 25px;
                    border-radius: 12px;
                    margin: 30px 0;
                }
                .contact-section h4 {
                    color: #3c5170;
                    margin: 0 0 15px 0;
                    font-size: 18px;
                }
                .contact-section p {
                    margin: 8px 0;
                    color: #555;
                }
                .contact-section a {
                    color: #fbb06b;
                    text-decoration: none;
                    font-weight: 500;
                }
                .footer { 
                    background: linear-gradient(135deg, #2a3d56 0%, #3c5170 100%);
                    text-align: center; 
                    padding: 30px 20px; 
                    color: rgba(255,255,255,0.8);
                }
                .footer p {
                    margin: 8px 0;
                    font-size: 13px;
                }
                .footer strong {
                    color: #fbb06b;
                }
                .divider {
                    height: 2px;
                    background: linear-gradient(90deg, transparent, #fbb06b, transparent);
                    margin: 30px 0;
                }
                @media only screen and (max-width: 600px) {
                    .email-wrapper {
                        padding: 20px 10px;
                    }
                    .content {
                        padding: 30px 20px;
                    }
                    .detail-row, .price-row {
                        flex-direction: column;
                        align-items: flex-start;
                    }
                    .detail-row span, .price-row span {
                        text-align: left;
                        margin-top: 5px;
                    }
                    .header h1 {
                        font-size: 26px;
                    }
                    .logo-section img {
                        max-width: 140px;
                    }
                }
            </style>
        </head>
        <body>
            <div class='email-wrapper'>
                <div class='container'>
                    <div class='logo-section'>
                        <img src='https://zerohan.site/landing_page/logo.png' alt='In & Out Cleaning Services' />
                    </div>
                    
                    <div class='header'>
                        <h1>Booking Confirmed!</h1>
                        <p>Your appointment has been successfully scheduled</p>
                    </div>
                    
                    <div class='content'>
                        <p class='greeting'>Dear $name,</p>
                        <p class='intro-text'>Thank you for choosing <strong>In & Out Cleaning Services</strong>! We're excited to serve you and make your space spotlessly clean.</p>
                        
                        <div class='reference-highlight'>
                            <div class='label'>Your Booking Reference</div>
                            <strong>$booking_ref</strong>
                        </div>
                        
                        <div class='booking-details'>
                            <h3>📋 Booking Information</h3>
                            <div class='detail-row'>
                                <strong>🧹 Service:</strong>
                                <span>$service</span>
                            </div>
                            <div class='detail-row'>
                                <strong>📅 Date:</strong>
                                <span>$date November 2025</span>
                            </div>
                            <div class='detail-row'>
                                <strong>🕐 Time:</strong>
                                <span>$time</span>
                            </div>
                        </div>

                        <div class='booking-details'>
                            <h3>👤 Customer Information</h3>
                            <div class='detail-row'>
                                <strong>Name:</strong>
                                <span>$name</span>
                            </div>
                            <div class='detail-row'>
                                <strong>Email:</strong>
                                <span>$email</span>
                            </div>
                            <div class='detail-row'>
                                <strong>Phone:</strong>
                                <span>$phone</span>
                            </div>
                        </div>

                        <div class='booking-details'>
                            <h3>📍 Service Location</h3>
                            <div class='detail-row'>
                                <strong>Street Address:</strong>
                                <span>$address</span>
                            </div>
                            <div class='detail-row'>
                                <strong>City:</strong>
                                <span>$city</span>
                            </div>
                            <div class='detail-row'>
                                <strong>State:</strong>
                                <span>$state</span>
                            </div>
                            <div class='detail-row'>
                                <strong>ZIP Code:</strong>
                                <span>$zip</span>
                            </div>
                        </div>
                        
                        $addonsSection
                        
                        <div class='price-breakdown'>
                            <h3>💰 Price Breakdown</h3>
                            <div class='price-row'>
                                <span>Base Service Price:</span>
                                <span>$" . number_format($basePrice, 2) . "</span>
                            </div>
                            " . (!empty($addons) ? "
                            <div class='price-row'>
                                <span>Add-ons Total:</span>
                                <span>$" . number_format($addonsTotal, 2) . "</span>
                            </div>
                            " : "") . "
                            <div class='price-row'>
                                <span>Subtotal:</span>
                                <span>$" . number_format($subtotal, 2) . "</span>
                            </div>
                            <div class='price-row'>
                                <span>GST:</span>
                                $gstDisplay
                            </div>
                            <div class='price-row total'>
                                <span>Estimated Total:</span>
                                <span>$" . number_format($total, 2) . "</span>
                            </div>
                        </div>
                        
                        <div class='disclaimer'>
                            <strong>⚠️ Important Note:</strong> This is an estimated price based on your selections. The final price will be determined after our team completes an on-site inspection of your property.
                        </div>
                        
                        $notesSection
                        
                        <div class='divider'></div>
                        
                        <div class='info-box'>
                            <strong>📱 What Happens Next?</strong>
                            <ul>
                                <li>📧 You'll receive a reminder 24 hours before your appointment</li>
                                <li>👥 Our professional cleaning team will arrive on time</li>
                                <li>🔍 We'll conduct a quick inspection to confirm the final price</li>
                                <li>🧴 All cleaning supplies and equipment are provided by us</li>
                                <li>✨ Expect exceptional service and sparkling results</li>
                            </ul>
                        </div>

                        <div class='contact-section'>
                            <h4>Need to Make Changes?</h4>
                            <p>If you need to reschedule or cancel your appointment, please contact us at least 24 hours in advance.</p>
                            <p style='margin-top: 15px;'>
                                <strong>📧 Email:</strong> <a href='mailto:Rohantaar70@gmail.com'>Rohantaar70@gmail.com</a><br>
                                <strong>📞 Phone:</strong> [Your Phone Number]
                            </p>
                        </div>

                        <p style='text-align: center; margin-top: 35px; color: #666; font-size: 15px;'>
                            We look forward to making your space shine!<br>
                            <strong style='color: #3c5170; font-size: 16px;'>— The In & Out Cleaning Services Team</strong>
                        </p>
                    </div>
                    
                    <div class='footer'>
                        <p><strong>In & Out Cleaning Services</strong></p>
                        <p>This is an automated confirmation email.</p>
                        <p style='margin-top: 15px;'>© 2025 In & Out Cleaning Services. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </body>
        </html>
        ";

        // Plain text version
        $addonsPlain = '';
        if (!empty($addons)) {
            $addonsList = array_map(function ($addon) {
                return '- ' . $addon['name'] . ' (+$' . number_format(floatval($addon['price']), 2) . ')';
            }, $addons);
            $addonsPlain = "\n\nSelected Add-ons:\n" . implode("\n", $addonsList);
        }

        $notesPlain = !empty($notes) ? "\n\nSpecial Instructions:\n$notes" : '';
        $gstPlainText = ($gst == 0) ? 'GST FREE' : '$' . number_format($gst, 2);

        $mail->AltBody = "BOOKING CONFIRMATION\n\n"
            . "Dear $name,\n\n"
            . "Your booking has been confirmed!\n\n"
            . "BOOKING REFERENCE: $booking_ref\n\n"
            . "=== BOOKING DETAILS ===\n"
            . "Service: $service\n"
            . "Date: $date November 2025\n"
            . "Time: $time\n\n"
            . "=== CUSTOMER INFORMATION ===\n"
            . "Name: $name\n"
            . "Email: $email\n"
            . "Phone: $phone\n\n"
            . "=== SERVICE LOCATION ===\n"
            . "Address: $address\n"
            . "City: $city\n"
            . "State: $state\n"
            . "ZIP: $zip\n"
            . $addonsPlain
            . "\n\n=== PRICE BREAKDOWN ===\n"
            . "Base Service: $" . number_format($basePrice, 2) . "\n"
            . (!empty($addons) ? "Add-ons Total: $" . number_format($addonsTotal, 2) . "\n" : "")
            . "Subtotal: $" . number_format($subtotal, 2) . "\n"
            . "GST: $gstPlainText\n"
            . "------------------------\n"
            . "Estimated Total: $" . number_format($total, 2) . "\n\n"
            . "* Final price will be determined after on-site inspection\n"
            . $notesPlain
            . "\n\n=== WHAT HAPPENS NEXT ===\n"
            . "- You'll receive a reminder 24 hours before your appointment\n"
            . "- Our professional team will arrive on time\n"
            . "- We'll conduct a quick inspection to confirm the final price\n"
            . "- All cleaning supplies and equipment are provided\n"
            . "- Expect exceptional service and sparkling results\n\n"
            . "Need to make changes? Contact us at least 24 hours in advance.\n"
            . "Email: Rohantaar70@gmail.com\n\n"
            . "We look forward to serving you!\n"
            . "— In & Out Cleaning Services Team";
        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Email Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>