<?php
// admin/api/update_position.php
require_once __DIR__ . '/../../config/database.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table = $_POST['table'] ?? '';
    $order = $_POST['order'] ?? [];

    $allowed_tables = ['team', 'partners', 'social_media', 'working_process', 'services', 'gallery', 'country', 'university', 'achievement', 'event', 'testimonial', 'hero'];

    if (!in_array($table, $allowed_tables)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid table']);
        exit;
    }

    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("UPDATE `$table` SET `position` = :position WHERE `id` = :id");
        
        foreach ($order as $index => $id) {
            $stmt->execute(['position' => $index + 1, 'id' => (int)$id]);
        }
        
        $pdo->commit();
        echo json_encode(['status' => 'success']);
    } catch(PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
