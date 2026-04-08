<?php
require_once 'config/database.php';

try {
    $stmt = $pdo->query("SELECT id, username, email FROM admin");
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<h1>Admin Accounts in Database:</h1>";
    if (empty($admins)) {
        echo "<p style='color:red;'>NO ADMIN ACCOUNTS FOUND!</p>";
    } else {
        echo "<table border='1'><tr><th>ID</th><th>Username</th><th>Email</th></tr>";
        foreach ($admins as $admin) {
            echo "<tr><td>{$admin['id']}</td><td>{$admin['username']}</td><td>{$admin['email']}</td></tr>";
        }
        echo "</table>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
