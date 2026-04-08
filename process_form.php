<?php
// process_form.php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/functions.php';

// Ensure it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request mode.");
}

// Very basic honeypot check (add <input type="text" name="honeypot" class="hidden"> to all forms in future)
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

// Basic notification email function
function notify_admin($subject, $body) {
    global $admin_email;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: <noreply@unilinkglobal.com>" . "\r\n";
    @mail($admin_email, $subject, $body, $headers);
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
            notify_admin("New Newsletter Subscriber", "<p>A new visitor subscribed to the newsletter: <strong>$email</strong></p>");
        }
        
        set_flash_msg('success', 'Thank you for subscribing to our newsletter!');
        $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        redirect($redirect);
    }
    
    elseif ($form_type === 'chatbot') {
        $topic = sanitize($_POST['topic']);
        $name = sanitize($_POST['name']);
        $phone = sanitize($_POST['phone']);
        $message = sanitize($_POST['message'] ?? '');
        $email = sanitize($_POST['email'] ?? 'Not Provided');
        
        $stmt = $pdo->prepare("INSERT INTO chatbot_leads (topic, name, email, phone, address, country, course) VALUES (?, ?, ?, ?, ?, ?, ?)");
        // address, country, course are default empty since chatbot only collects basics
        $stmt->execute([$topic, $name, $email, $phone, $message, '', '']);
        
        $body = "<h3>New Virtual Assistant Lead</h3>
                 <p><strong>Topic:</strong> $topic</p>
                 <p><strong>Name:</strong> $name</p>
                 <p><strong>Phone:</strong> $phone</p>
                 <p><strong>Message:</strong> $message</p>";
        notify_admin("New Lead: $topic ($name)", $body);
        
        set_flash_msg('success', 'Your request has been sent! Our team will contact you shortly.');
        $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        redirect($redirect);
    }

    elseif ($form_type === 'contact') {
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $subject = sanitize($_POST['subject']);
        $message = sanitize($_POST['message']);
        
        // No explicit table for contact messages mentioned, sending email directly.
        $body = "<h3>New Contact Form Submission</h3>
                 <p><strong>Name:</strong> $name</p>
                 <p><strong>Email:</strong> $email</p>
                 <p><strong>Subject:</strong> $subject</p>
                 <p><strong>Message:</strong><br>$message</p>";
        notify_admin("Contact Form: $subject", $body);
        
        set_flash_msg('success', 'Your message has been sent successfully. We will get back to you soon.');
        $redirect = $_SERVER['HTTP_REFERER'] ?? 'contact.php';
        redirect($redirect);
    }

    elseif ($form_type === 'appointment') {
        // Collect massive appointment post data
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $phone = sanitize($_POST['phone']);
        $address = sanitize($_POST['address'] ?? '');
        $last_academic_education = sanitize($_POST['last_academic_education'] ?? '');
        $passing_year = sanitize($_POST['passing_year'] ?? '');
        $department = sanitize($_POST['department'] ?? '');
        $institution_name = sanitize($_POST['institution_name'] ?? '');
        $english_test = sanitize($_POST['english_test'] ?? '');
        $test_name = sanitize($_POST['test_name'] ?? '');
        $test_results = sanitize($_POST['test_results'] ?? '');
        $planned_exam_date = sanitize($_POST['planned_exam_date'] ?? null);
        $degree = sanitize($_POST['degree'] ?? '');
        $interest_country = sanitize($_POST['interest_country'] ?? '');
        $interested_course = sanitize($_POST['interested_course'] ?? '');

        // Safe insertion handling date constraint
        if(empty($planned_exam_date)) $planned_exam_date = null;

        $stmt = $pdo->prepare("INSERT INTO appointment (
            name, email, phone, address, last_academic_education, passing_year, department, institution_name,
            english_test, test_name, test_results, planned_exam_date, degree, interest_country, interested_course
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $name, $email, $phone, $address, $last_academic_education, $passing_year, $department, $institution_name,
            $english_test, $test_name, $test_results, $planned_exam_date, $degree, $interest_country, $interested_course
        ]);

        $body = "<h3>New Appointment Booking</h3>
                 <p><strong>Name:</strong> $name</p>
                 <p><strong>Phone:</strong> $phone</p>
                 <p><strong>Email:</strong> $email</p>
                 <p><strong>Desired Country:</strong> $interest_country</p>
                 <p><strong>Course:</strong> $interested_course</p>
                 <p>Log in to the admin panel to view full details.</p>";
        notify_admin("New Appointment: $name", $body);
        
        set_flash_msg('success', 'Your appointment request has been recorded. Our counselors will contact you to confirm the date and time.');
        redirect('appointment.php');
    }

    elseif ($form_type === 'testimonial') {
        $name = sanitize($_POST['name']);
        $role = sanitize($_POST['role']); // 'student' or 'parents'
        $message = sanitize($_POST['message']);
        
        $image = '';
        if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
            $uploaded = upload_image($_FILES['image'], 'testimonials');
            if ($uploaded) {
                $image = $uploaded;
            }
        }

        // Insert as pending
        $stmt = $pdo->prepare("INSERT INTO testimonial (name, role, message, image, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt->execute([$name, $role, $message, $image]);

        notify_admin("New Review Pending Approval", "<p><strong>$name</strong> submitted a new testimonial/review. Please log in to approve it.</p>");

        set_flash_msg('success', 'Thank you! Your review has been submitted and is pending approval.');
        $redirect = $_SERVER['HTTP_REFERER'] ?? 'testimonials.php';
        redirect($redirect);
    }

    else {
        die("Unknown form type.");
    }

} catch (Exception $e) {
    // Log error, redirect back with error message
    set_flash_msg('error', 'An error occurred while processing your request. Please try again.');
    $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    redirect($redirect);
}
?>
