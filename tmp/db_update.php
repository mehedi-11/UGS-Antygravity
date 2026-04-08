<?php
require_once __DIR__ . '/../config/database.php';

try {
    $pdo->exec("ALTER TABLE services ADD COLUMN icon_class VARCHAR(255) DEFAULT NULL AFTER title");
    echo "Column icon_class added successfully to services table.";
} catch (PDOException $e) {
    if ($e->getCode() == '42S21') {
        echo "Column icon_class already exists.";
    } else {
        echo "Error: " . $e->getMessage();
    }
}
?>
