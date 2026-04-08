<?php
ob_start(); // Buffer output to prevent "headers already sent"
require_once '../config/database.php';
require_once '../config/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login_id = sanitize($_POST['login_id'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($login_id) || empty($password)) {
        set_flash_msg('error', 'Please fill in all fields.');
        header("Location: index.php");
        exit;
    }

    try {
        // Find admin by email, username, or phone
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = :id OR username = :id OR phone = :id LIMIT 1");
        $stmt->execute(['id' => $login_id]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            // Valid login
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['admin_username'] = $admin['username'];
            
            // Decoded permissions
            $perms = json_decode($admin['permissions'], true);
            $_SESSION['admin_permissions'] = is_array($perms) ? $perms : [];
            
            // Success redirect
            header("Location: dashboard.php");
            exit;
        } else {
            set_flash_msg('error', 'Invalid credentials or account not found.');
            header("Location: index.php");
            exit;
        }
    } catch (PDOException $e) {
        set_flash_msg('error', 'Login error. Please try again.');
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
ob_end_flush();
