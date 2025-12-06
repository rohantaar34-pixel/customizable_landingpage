<?php
session_start();

// Load Composer's autoloader
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Database configuration
$host = 'localhost';
$dbname = 'inandout';
$username = 'root';
$password = '';

// $host = 'localhost';
// $dbname = 'u469776567_inandout';
// $username = 'u469776567_iao';
// $password = '^;yJpD3yjOe5';

// Initialize response
$response = [
    'success' => false,
    'message' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Sanitize and validate input
        $full_name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $service_type = trim($_POST['service_type'] ?? '');
        $contact_method = trim($_POST['contact_method'] ?? 'email');
        $message = trim($_POST['message'] ?? '');
        $agree_terms = isset($_POST['agree_terms']) ? 1 : 0;

        // Validation
        if (empty($full_name) || empty($email) || empty($phone) || empty($service_type) || empty($message)) {
            throw new Exception('Please fill in all required fields.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Please provide a valid email address.');
        }

        if (!$agree_terms) {
            throw new Exception('You must agree to the terms and conditions.');
        }

        // Connect to database
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert contact inquiry into database
        $stmt = $pdo->prepare("
            INSERT INTO contact_inquiries 
            (full_name, email, phone, service_type, contact_method, message, agree_terms, created_at) 
            VALUES 
            (:full_name, :email, :phone, :service_type, :contact_method, :message, :agree_terms, NOW())
        ");

        $stmt->execute([
            ':full_name' => $full_name,
            ':email' => $email,
            ':phone' => $phone,
            ':service_type' => $service_type,
            ':contact_method' => $contact_method,
            ':message' => $message,
            ':agree_terms' => $agree_terms
        ]);

        $inquiry_id = $pdo->lastInsertId();

        // Send email notification using PHPMailer
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
            $mail->setFrom('rohantaar34@gmail.com', 'In & Out Cleaning Service');
            $mail->addAddress('rohantaar34@gmail.com', 'Admin');
            $mail->addReplyTo($email, $full_name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'New Contact Inquiry - ' . ucwords(str_replace('_', ' ', $service_type));

            $mail->Body = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background-color: #3d5a80; color: white; padding: 20px; text-align: center; }
                        .content { background-color: #f9f9f9; padding: 20px; margin-top: 20px; }
                        .field { margin-bottom: 15px; }
                        .label { font-weight: bold; color: #3d5a80; }
                        .value { margin-left: 10px; }
                        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #666; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h2>New Contact Inquiry</h2>
                            <p>Inquiry ID: #$inquiry_id</p>
                        </div>
                        <div class='content'>
                            <div class='field'>
                                <span class='label'>Name:</span>
                                <span class='value'>$full_name</span>
                            </div>
                            <div class='field'>
                                <span class='label'>Email:</span>
                                <span class='value'>$email</span>
                            </div>
                            <div class='field'>
                                <span class='label'>Phone:</span>
                                <span class='value'>$phone</span>
                            </div>
                            <div class='field'>
                                <span class='label'>Service Requested:</span>
                                <span class='value'>" . ucwords(str_replace('_', ' ', $service_type)) . "</span>
                            </div>
                            <div class='field'>
                                <span class='label'>Preferred Contact:</span>
                                <span class='value'>" . ucwords($contact_method) . "</span>
                            </div>
                            <div class='field'>
                                <span class='label'>Message:</span>
                                <div class='value' style='margin-top: 10px; padding: 15px; background-color: white; border-left: 3px solid #3d5a80;'>
                                    " . nl2br(htmlspecialchars($message)) . "
                                </div>
                            </div>
                        </div>
                        <div class='footer'>
                            <p>This inquiry was submitted on " . date('F j, Y \a\t g:i A') . "</p>
                        </div>
                    </div>
                </body>
                </html>
            ";

            $mail->AltBody = "
                New Contact Inquiry - #$inquiry_id\n
                Name: $full_name\n
                Email: $email\n
                Phone: $phone\n
                Service: " . ucwords(str_replace('_', ' ', $service_type)) . "\n
                Preferred Contact: " . ucwords($contact_method) . "\n
                Message:\n$message\n
                Submitted: " . date('F j, Y \a\t g:i A') . "
            ";

            $mail->send();

            // Send confirmation email to customer
            $customerMail = new PHPMailer(true);
            $customerMail->isSMTP();
            $customerMail->Host = 'smtp.gmail.com';
            $customerMail->SMTPAuth = true;
            $customerMail->Username = 'Rohantaar70@gmail.com';
            $customerMail->Password = 'eyxy jnch yuhc vghd';
            $customerMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $customerMail->Port = 587;

            $customerMail->setFrom('Rohantaar70@gmail.com', 'In & Out Cleaning Service');
            $customerMail->addAddress($email, $full_name);

            $customerMail->isHTML(true);
            $customerMail->Subject = 'Thank You for Contacting In & Out Cleaning Service';

            $customerMail->Body = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                        .header { background-color: #3d5a80; color: white; padding: 20px; text-align: center; }
                        .content { background-color: #f9f9f9; padding: 20px; margin-top: 20px; }
                        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #666; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h2>Thank You for Reaching Out!</h2>
                        </div>
                        <div class='content'>
                            <p>Hi $full_name,</p>
                            <p>Thank you for contacting In & Out Cleaning Service. We have received your inquiry regarding <strong>" . ucwords(str_replace('_', ' ', $service_type)) . "</strong>.</p>
                            <p>Our team will review your message and get back to you within 24-48 hours via your preferred contact method: <strong>" . ucwords($contact_method) . "</strong>.</p>
                            <p><strong>Your Inquiry Summary:</strong></p>
                            <p style='padding: 15px; background-color: white; border-left: 3px solid #3d5a80;'>
                                " . nl2br(htmlspecialchars($message)) . "
                            </p>
                            <p>If you have any urgent questions, please don't hesitate to call us at <strong>+1 (555) 123-4567</strong>.</p>
                            <p>We look forward to serving you!</p>
                            <p>Best regards,<br>The In & Out Cleaning Team</p>
                        </div>
                        <div class='footer'>
                            <p>This is an automated confirmation email. Please do not reply directly to this email.</p>
                        </div>
                    </div>
                </body>
                </html>
            ";

            $customerMail->send();

        } catch (Exception $e) {
            error_log("Email sending failed: {$mail->ErrorInfo}");
            // Continue even if email fails - inquiry is already saved
        }

        $response['success'] = true;
        $response['message'] = 'Thank you for contacting us! We have received your inquiry and will get back to you soon.';
        $_SESSION['contact_success'] = $response['message'];

        // Redirect back to contact page with success message
        header('Location: contact.php?success=1');
        exit;

    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $response['message'] = 'Sorry, there was a problem processing your request. Please try again later.';
        $_SESSION['contact_error'] = $response['message'];
        header('Location: contact.php?error=1');
        exit;

    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
        $_SESSION['contact_error'] = $response['message'];
        header('Location: contact.php?error=1');
        exit;
    }
} else {
    header('Location: contact.php');
    exit;
}
?>