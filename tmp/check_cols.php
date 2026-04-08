<?php
require_once __DIR__ . '/../config/database.php';
$cols = $pdo->query("DESCRIBE services")->fetchAll(PDO::FETCH_COLUMN);
echo implode(", ", $cols);
?>
