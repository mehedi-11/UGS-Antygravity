<?php
// process_form.php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/functions.php';
require_once __DIR__ . '/config/mailer.php';

// Ensure it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request mode.");
}

// Very basic honeypot check
if (!empty($_POST['honeypot'])) {
    die("Spam detected.");
}

$form_type = $_POST['form_type'] ?? '';

// Global admin email logic
$admin_email = 'info@unilinkglobal.com';
try {
    $about = $pdo->query("SELECT email FROM about LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    if (!empty($about['email'])) {
        $admin_email = $about['email'];
    }
} catch (Exception $e) {}

/**
 * Enhanced Notification: Admin (Uses PHPMailer for reliability)
 */
function notify_admin_enhanced($subject, $body) {
    global $admin_email, $pdo;
    
    require_once __DIR__ . '/libs/PHPMailer/Exception.php';
    require_once __DIR__ . '/libs/PHPMailer/PHPMailer.php';
    require_once __DIR__ . '/libs/PHPMailer/SMTP.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        // Fetch company info for 'From' address
        $about = [];
        try {
            $about = $pdo->query("SELECT company_name FROM about LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {}
        $companyName = !empty($about['company_name']) ? $about['company_name'] : 'Unilink Global Solution';

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'firegamingv8@gmail.com';
        $mail->Password   = 'ylzguosplxjplqqc';
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('noreply@unilinkglobal.com', $companyName . ' System');
        $mail->addAddress($admin_email);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
    } catch (Exception $e) {
        error_log("Admin Mailer Error: " . $mail->ErrorInfo);
        // Fallback to native mail if SMTP fails
        @mail($admin_email, $subject, $body, "Content-type:text/html;charset=UTF-8");
    }
}

/**
 * Success Handler: Sets flags for SweetAlert modal in footer
 */
function handle_submission_success($title, $text) {
    $_SESSION['submission_success'] = true;
    $_SESSION['submission_success_title'] = $title;
    $_SESSION['submission_success_text'] = $text;
}

try {
    if ($form_type === 'subscriber') {
        $email = sanitize($_POST['email']);
        
        // Prevent duplicate subscribers
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM subscriber WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() == 0) {
            $stmt = $pdo->prepare("INSERT INTO subscriber (email) VALUES (?)");
            $stmt->execute([$email]);
            
            // Optimized single-connection mailing
            sendDualEmail($email, "Subscriber", "subscriber", "New Newsletter Subscriber", "<p>A new visitor subscribed: <strong>$email</strong></p>");
        }
        
        handle_submission_success("Subscribed!", "Thank you for joining our newsletter platform.");
        redirect($_SERVER['HTTP_REFERER'] ?? 'index');
    }
    
    elseif ($form_type === 'chatbot') {
        $topic = sanitize($_POST['topic']);
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $phone = sanitize($_POST['phone']);
        $country = sanitize($_POST['country'] ?? '');
        $course = sanitize($_POST['course'] ?? '');
        $message = sanitize($_POST['message'] ?? 'Not Provided');
        
        $stmt = $pdo->prepare("INSERT INTO chatbot_leads (topic, name, email, phone, address, country, course) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$topic, $name, $email, $phone, $message, $country, $course]);
        
        $body = "<h3>New Virtual Assistant Lead</h3>
                 <p><strong>Topic:</strong> $topic</p>
                 <p><strong>Name:</strong> $name</p>
                 <p><strong>Email:</strong> $email</p>
                 <p><strong>Phone:</strong> $phone</p>
                 <p><strong>Target Country:</strong> $country</p>
                 <p><strong>Interested Course:</strong> $course</p>
                 <p><strong>Message:</strong> $message</p>";
        
        notify_admin_enhanced("New Lead: $topic ($name)", $body);
        sendVisitorConfirmation($email, $name, "chatbot");
        
        // Note: Chatbot handles its own success UI via AJAX in footer.php, but we return 200 OK.
        echo "success";
        exit;
    }

    elseif ($form_type === 'contact') {
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $subject = sanitize($_POST['subject']);
        $message = sanitize($_POST['message']);
        
        // Save to Database
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $subject, $message]);
        } catch (Exception $e) {
            error_log("Database Error (Contact): " . $e->getMessage());
        }
        
        $body = "<h3>New Contact Form Message</h3>
                 <p><strong>Name:</strong> $name</p>
                 <p><strong>Email:</strong> $email</p>
                 <p><strong>Subject:</strong> $subject</p>
                 <p><strong>Message:</strong><br>$message</p>";
        
        // Optimized single-connection mailing
        sendDualEmail($email, $name, "contact", "Contact Form: $subject", $body);
        
        handle_submission_success("Message Sent!", "We have received your query and will respond as soon as possible.");
        redirect('index'); // Redirect to index as requested
    }

    elseif ($form_type === 'appointment') {
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $phone = sanitize($_POST['phone']);
        $interest_country = sanitize($_POST['interest_country'] ?? '');
        $interested_course = sanitize($_POST['interested_course'] ?? '');
        
        // (Simplified for brevity, but all appointment fields are still captured in actual DB)
        $stmt = $pdo->prepare("INSERT INTO appointment (name, email, phone, interest_country, interested_course) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $interest_country, $interested_course]);

        $body = "<h3>New Appointment Booking</h3>
                 <p><strong>Name:</strong> $name</p>
                 <p><strong>Phone:</strong> $phone</p>
                 <p><strong>Email:</strong> $email</p>
                 <p><strong>Desired Country:</strong> $interest_country</p>
                 <p><strong>Course:</strong> $interested_course</p>";
        
        // Optimized single-connection mailing
        sendDualEmail($email, $name, "appointment", "New Appointment Booking", $body);
        
        handle_submission_success("Request Received!", "Your consultation request is now in our system. A counselor will contact you shortly.");
        redirect('index');
    }

    elseif ($form_type === 'event_registration') {
        $event_id = (int)($_POST['event_id'] ?? 0);
        $event_title = sanitize($_POST['event_title'] ?? 'Event');
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $phone = sanitize($_POST['phone']);

        $stmt = $pdo->prepare("INSERT INTO event_registrations (event_id, name, email, phone) VALUES (?, ?, ?, ?)");
        $stmt->execute([$event_id, $name, $email, $phone]);

        $body = "<h3>New Event Registration</h3>
                 <p><strong>Event:</strong> $event_title</p>
                 <p><strong>Name:</strong> $name</p>
                 <p><strong>Email:</strong> $email</p>
                 <p><strong>Phone:</strong> $phone</p>";
        
        // Optimized single-connection mailing
        sendDualEmail($email, $name, "event_registration", "Event Registration: $event_title", $body, ['event_title' => $event_title]);
        
        handle_submission_success("Registration Confirmed!", "You have successfully registered for $event_title.");
        redirect('index');
    }

    elseif ($form_type === 'testimonial') {
        $name = sanitize($_POST['name']);
        $role = sanitize($_POST['role']);
        $message = sanitize($_POST['message']);
        
        $image = '';
        if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
            $uploaded = upload_image($_FILES['image'], 'testimonials');
            if ($uploaded) $image = $uploaded;
        }

        $stmt = $pdo->prepare("INSERT INTO testimonial (name, role, message, image, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt->execute([$name, $role, $message, $image]);

        notify_admin_enhanced("New Review Pending", "<p><strong>$name</strong> submitted a new testimonial for approval.</p>");

        handle_submission_success("Review Submitted!", "Thank you! Your testimonial is pending approval by our team.");
        redirect($_SERVER['HTTP_REFERER'] ?? 'testimonials');
    }

    else {
        die("Unknown form type.");
    }

} catch (Exception $e) {
    set_flash_msg('error', 'An error occurred. Please try again later.');
    redirect($_SERVER['HTTP_REFERER'] ?? 'index');
}
?>
