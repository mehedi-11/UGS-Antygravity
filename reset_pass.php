<?php
require_once 'config/database.php';

try {
    $new_pass = password_hash('password123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE admin SET password = ? WHERE username = 'admin'");
    $stmt->execute([$new_pass]);
    
    if ($stmt->rowCount() > 0) {
        echo "<h1 style='color:green;'>Password for 'admin' has been reset to 'password123' successfully.</h1>";
    } else {
        echo "<h1 style='color:orange;'>No changes made. Either 'admin' user doesn't exist or password was already that.</h1>";
    }
} catch (Exception $e) {
    echo "<h1 style='color:red;'>Error: " . $e->getMessage() . "</h1>";
}
?>
