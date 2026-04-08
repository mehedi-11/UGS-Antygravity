<?php
require_once __DIR__ . '/../config/database.php';
$tables = ['hero', 'about', 'services', 'achievement', 'events', 'blogs'];
$out = [];
foreach($tables as $t) {
    try {
        $cols = $pdo->query('DESCRIBE '.$t)->fetchAll(PDO::FETCH_COLUMN);
        $out[$t] = $cols;
    } catch(Exception $e) {
        $out[$t] = $e->getMessage();
    }
}
file_put_contents(__DIR__ . '/db_schema.json', json_encode($out, JSON_PRETTY_PRINT));
?>
