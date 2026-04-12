<?php
// config/mailer.php
require_once __DIR__ . '/../libs/PHPMailer/Exception.php';
require_once __DIR__ . '/../libs/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../libs/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

/**
 * Helper to get a pre-configured PHPMailer instance
 */
function getConfiguredMailer() {
    global $pdo;
    
    // Fetch Company Info once
    $about = [];
    try {
        $about = $pdo->query("SELECT email, company_name FROM about LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {}
    
    $companyEmail = !empty($about['email']) ? $about['email'] : 'info@unilinkglobal.com';
    $companyName = !empty($about['company_name']) ? $about['company_name'] : 'Unilink Global Solution';

    $mail = new PHPMailer(true);

    // SMTP Server Configuration
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'firegamingv8@gmail.com';
    $mail->Password   = 'ylzguosplxjplqqc';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    
    // Set default Sender
    $mail->setFrom($companyEmail, $companyName);
    
    return $mail;
}

/**
 * Global Mailer Helper
 * Sends a confirmation email to the visitor
 */
function sendVisitorConfirmation($to, $name, $type, $extraData = []) {
    global $pdo;
    
    try {
        $mail = getConfiguredMailer();

        // 3. Recipients
        $mail->addAddress($to, $name);

        // 4. Prepare Content
        $about = $pdo->query("SELECT company_name FROM about LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        $companyName = !empty($about['company_name']) ? $about['company_name'] : 'Unilink Global Solution';

        $subject = "Confirmation: Your submission to $companyName";
        $body = "";

        switch ($type) {
            case 'contact':
                $body = "<h2>Hello $name,</h2><p>Thank you for contacting us. We have received your message and our team will get back to you shortly.</p>";
                break;
            case 'subscriber':
                $body = "<h2>Welcome to our Newsletter!</h2><p>Thank you for subscribing. You'll now receive the latest updates and scholarship news directly in your inbox.</p>";
                break;
            case 'appointment':
                $body = "<h2>Appointment Request Received</h2><p>Dear $name, your consultation request has been successfully submitted. Our counselors will review your profile and contact you for the next steps.</p>";
                break;
            case 'chatbot':
                $body = "<h2>Inquiry Received</h2><p>Hi $name, thank you for using our Virtual Assistant. We have received your inquiry and will contact you via phone/email soon.</p>";
                break;
            case 'event_registration':
                $eventTitle = $extraData['event_title'] ?? 'the event';
                $body = "<h2>Registration Confirmed!</h2><p>Dear $name, you have successfully registered for <strong>$eventTitle</strong>. We look forward to seeing you there!</p>";
                break;
        }

        $body .= "<br><hr><p>Regards,<br><strong>$companyName Team</strong></p>";

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags(str_replace(['<br>', '<p>', '</h2>', '</strong>'], ["\n", "\n", "\n\n", ""], $body));

        return true;

    } catch (Exception $e) {
        error_log("PHPMailer Error: " . ($mail->ErrorInfo ?? $e->getMessage()));
        return false;
    }
}

/**
 * Optimized dual-email sender
 * Sends one email to visitor and one to admin using the SAME SMTP connection
 */
function sendDualEmail($visitorEmail, $visitorName, $type, $adminSubject, $adminBody, $extraData = []) {
    global $pdo, $admin_email;
    
    try {
        $mail = getConfiguredMailer();
        
        // 1. Fetch Company/Admin Info 
        // (Note: $admin_email is global from process_form.php, but we can fetch it here too)
        $about = $pdo->query("SELECT email, company_name FROM about LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        $companyName = !empty($about['company_name']) ? $about['company_name'] : 'Unilink Global Solution';
        $targetAdminEmail = !empty($about['email']) ? $about['email'] : 'info@unilinkglobal.com';

        // 2. Prepare Visitor Email Content (reuse logic from sendVisitorConfirmation)
        $visitorSubject = "Confirmation: Your submission to $companyName";
        $visitorBody = "";
        switch ($type) {
            case 'contact': $visitorBody = "<h2>Hello $visitorName,</h2><p>Thank you for contacting us. We have received your message and our team will get back to you shortly.</p>"; break;
            case 'subscriber': $visitorBody = "<h2>Welcome to our Newsletter!</h2><p>Thank you for subscribing. You'll now receive the latest updates and scholarship news directly in your inbox.</p>"; break;
            case 'appointment': $visitorBody = "<h2>Appointment Request Received</h2><p>Dear $visitorName, your consultation request has been successfully submitted. Our counselors will review your profile and contact you for the next steps.</p>"; break;
            case 'chatbot': $visitorBody = "<h2>Inquiry Received</h2><p>Hi $visitorName, thank you for using our Virtual Assistant. We have received your inquiry and will contact you via phone/email soon.</p>"; break;
            case 'event_registration': 
                $eventTitle = $extraData['event_title'] ?? 'the event';
                $visitorBody = "<h2>Registration Confirmed!</h2><p>Dear $visitorName, you have successfully registered for <strong>$eventTitle</strong>. We look forward to seeing you there!</p>"; 
                break;
        }
        $visitorBody .= "<br><hr><p>Regards,<br><strong>$companyName Team</strong></p>";

        // 3. Send to Visitor
        $mail->addAddress($visitorEmail, $visitorName);
        $mail->isHTML(true);
        $mail->Subject = $visitorSubject;
        $mail->Body    = $visitorBody;
        $mail->send();

        // 4. Clear and Send to Admin
        $mail->clearAddresses();
        $mail->addAddress($targetAdminEmail, $companyName . ' Admin');
        $mail->Subject = $adminSubject;
        $mail->Body    = $adminBody;
        $mail->send();

        return true;
    } catch (Exception $e) {
        error_log("Dual Mailer Error: " . ($mail->ErrorInfo ?? $e->getMessage()));
        return false;
    }
}

?>
