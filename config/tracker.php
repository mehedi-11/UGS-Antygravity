<?php
// config/tracker.php

/**
 * Advanced Visitor Tracking System
 * Logs IP, Geolocation (Country/City), Page URLs, and Referral information.
 */

try {
    // 1. Ensure the tracking table exists (Auto-Migration)
    $table_check = $pdo->query("SHOW TABLES LIKE 'visitor_logs'")->fetch();
    if (!$table_check) {
        $pdo->exec("CREATE TABLE visitor_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ip_address VARCHAR(45) NOT NULL,
            country VARCHAR(100) DEFAULT 'Unknown',
            city VARCHAR(100) DEFAULT 'Unknown',
            page_url TEXT,
            referrer TEXT,
            user_agent TEXT,
            session_id VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    // 2. Identify Visitor IP
    $ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    // 3. Prevent logging of admin user activity (Optional but recommended)
    if (isset($_SESSION['admin_id'])) {
        // We skip logging if an admin is browsing, to keep analytics clean.
        // Uncomment the next line if you want to log admins too.
        // return; 
    }

    // 4. Geolocation (Once per session to maintain performance)
    if (!isset($_SESSION['v_country']) || $_SESSION['v_ip'] !== $ip) {
        $_SESSION['v_ip'] = $ip;
        
        // Use ip-api.com (Free for non-commercial/testing)
        $ctx = stream_context_create(['http' => ['timeout' => 2]]); // 2 second timeout
        $geo_data = @file_get_contents("http://ip-api.com/json/{$ip}", false, $ctx);
        
        if ($geo_data) {
            $json = json_decode($geo_data, true);
            $_SESSION['v_country'] = $json['country'] ?? 'Unknown';
            $_SESSION['v_city'] = $json['city'] ?? 'Unknown';
        } else {
            $_SESSION['v_country'] = 'Unknown';
            $_SESSION['v_city'] = 'Unknown';
        }
    }

    // 5. Capture Page & Referral Data
    $page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $referrer = $_SERVER['HTTP_REFERER'] ?? 'Direct';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    $session_id = session_id();

    // 6. Log the Visit
    $stmt = $pdo->prepare("INSERT INTO visitor_logs (ip_address, country, city, page_url, referrer, user_agent, session_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $ip,
        $_SESSION['v_country'],
        $_SESSION['v_city'],
        $page_url,
        $referrer,
        $user_agent,
        $session_id
    ]);

} catch (Exception $e) {
    // Fail silently in production to avoid crashing the main site if tracker fails
    error_log("Analytics Error: " . $e->getMessage());
}
