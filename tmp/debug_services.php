<?php
require_once __DIR__ . '/../config/database.php';
$stmt = $pdo->query("SELECT id, title, icon_class, image FROM services");
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: " . $row['id'] . " | Title: " . $row['title'] . " | Icon: " . $row['icon_class'] . " | Image: " . $row['image'] . "\n";
}
?>
