<?php
// config/functions.php
ob_start();
session_start();
require_once __DIR__ . '/config.php';

// Redirect helper
function redirect($url) {
    header("Location: " . $url);
    exit;
}

// Check logged in admin
function check_login() {
    if(!isset($_SESSION['admin_id'])) {
        redirect('/admin/index.php');
    }
}

// Basic flash message system
function set_flash_msg($type, $msg) {
    $_SESSION['flash'][$type] = $msg;
}

function display_flash_msg() {
    if(isset($_SESSION['flash'])) {
        foreach($_SESSION['flash'] as $type => $msg) {
            $bg = $type == 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
            echo "<div class='border px-4 py-3 rounded relative mb-4 $bg' role='alert'><span class='block sm:inline'>$msg</span></div>";
        }
        unset($_SESSION['flash']);
    }
}

// Sanitize user input (anti-XSS)
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Check permissions
function has_permission($required_perm) {
    if(!isset($_SESSION['admin_permissions'])) {
        // If logged in but no permissions in session, maybe stale session?
        // For safety, return false, but we should suggest a re-login.
        return false;
    }
    
    // Super admin bypass
    if(in_array('all', $_SESSION['admin_permissions'])) {
        return true;
    }
    
    return in_array($required_perm, $_SESSION['admin_permissions']);
}

// Handle Image Upload
function upload_image($file, $target_dir) {
    if ($file['error'] == 0) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
        
        if (in_array(strtolower($ext), $allowed)) {
            // Ensure unique filename
            $new_name = uniqid() . time() . '.' . $ext;
            
            // Build the absolute path to the project's 'uploads' directory
            $base_dir = rtrim(__DIR__, '/\\') . '/../uploads/';
            $dest = $base_dir . $target_dir . '/' . $new_name;
            
            // Check if directory exists
            if (!is_dir($base_dir . $target_dir)) {
                mkdir($base_dir . $target_dir, 0777, true);
            }
            
            if (move_uploaded_file($file['tmp_name'], $dest)) {
                return $new_name;
            }
        }
    }
    return false;
}
