<?php
require_once 'config/database.php';

try {
    // Clear existing for clean start as requested
    $pdo->exec("TRUNCATE TABLE admin");
    
    $name = 'Mehedi Hasan (Superadmin)';
    $email = 'mehedimridul1919@gmail.com';
    $phone = '01776323859';
    $username = 'Mehedi19';
    $password = '$2y$10$UZk0iPSxAk14hl/Xv01hf.cE/MbitOlMYMznQVr.J65EL187o3zou';
    $permissions = json_encode(['all']);
    
    $stmt = $pdo->prepare("INSERT INTO admin (name, email, phone, username, password, permissions) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $phone, $username, $password, $permissions]);
    
    echo "<h1>Database Updated Successfully!</h1>";
    echo "<p>Admin <b>Mehedi19</b> has been created.</p>";
} catch (Exception $e) {
    echo "<h1>Error: " . $e->getMessage() . "</h1>";
}
?>
