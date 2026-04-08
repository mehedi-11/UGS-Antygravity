<?php
// blog_action.php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/functions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';

if (!$id || !$action) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

try {
    if ($action === 'like') {
        // Simple cookie-based prevention for multiple likes
        $cookie_name = "liked_blog_" . $id;
        if (isset($_COOKIE[$cookie_name])) {
            echo json_encode(['success' => false, 'message' => 'Already liked']);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE blogs SET likes = likes + 1 WHERE id = ?");
        $stmt->execute([$id]);
        
        // Fetch new count
        $newCount = $pdo->query("SELECT likes FROM blogs WHERE id = $id")->fetchColumn();
        
        // Set cookie for 30 days
        setcookie($cookie_name, "1", time() + (86400 * 30), "/");

        echo json_encode(['success' => true, 'new_count' => $newCount]);
    } 
    elseif ($action === 'share') {
        $stmt = $pdo->prepare("UPDATE blogs SET shares = shares + 1 WHERE id = ?");
        $stmt->execute([$id]);
        
        $newCount = $pdo->query("SELECT shares FROM blogs WHERE id = $id")->fetchColumn();
        echo json_encode(['success' => true, 'new_count' => $newCount]);
    } 
    elseif ($action === 'comment') {
        // Comment submission via AJAX
        $name = sanitize($_POST['name'] ?? '');
        $comment = sanitize($_POST['comment'] ?? '');

        if(empty($name) || empty($comment)){
            echo json_encode(['success' => false, 'message' => 'Name and comment are required']);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO blog_comments (blog_id, name, comment) VALUES (?, ?, ?)");
        $stmt->execute([$id, $name, $comment]);

        echo json_encode(['success' => true, 'message' => 'Comment added']);
    }
    else {
        echo json_encode(['success' => false, 'message' => 'Unknown action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>
