<?php
require_once __DIR__ . '/../config/database.php';
$res = $pdo->query('SELECT id, title, icon_class FROM services')->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($res, JSON_PRETTY_PRINT);
?>
