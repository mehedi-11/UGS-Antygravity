<?php
// admin/api/generate_ai.php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/functions.php';

// Check login and permission
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$title = sanitize($data['title'] ?? '');
$type = sanitize($data['type'] ?? 'general');

if (empty($title)) {
    echo json_encode(['success' => false, 'message' => 'Title is required to generate content.']);
    exit;
}

// Logic for OpenAI call if key exists
if (defined('OPENAI_API_KEY') && !empty(OPENAI_API_KEY)) {
    // Real OpenAI Implementation Placeholder
    // You can use curl to call https://api.openai.com/v1/chat/completions here
}

// Simulated AI Fallback
$generated_html = "";

switch ($type) {
    case 'blog':
        $generated_html = "<h2>Overview of $title</h2><p>In today's fast-paced world, <strong>$title</strong> has become a cornerstone of success. This article explores how it impacts the industry and why it matters to you.</p><ul><li>Reason 1: Innovation and growth</li><li>Reason 2: Academic excellence</li><li>Reason 3: Global opportunities</li></ul><p>By focusing on These key areas, Unilink Global Solution helps you achieve your goals with <em>professionalism</em> and <em>integrity</em>.</p>";
        break;
    case 'service':
        $generated_html = "<h3>Why Choose Our $title Service?</h3><p>At Unilink, our <strong>$title</strong> service is designed to provide comprehensive support for students. We ensure that every step of your journey is handled by experts.</p><p>Key Features:</p><ul><li>Expert guidance and specialized consulting</li><li>Proven track record with over 1000+ success stories</li><li>Direct partnership with top-tier universities</li></ul>";
        break;
    case 'about':
        $generated_html = "<p>Unilink Global Solution is dedicated to <strong>$title</strong>. Founded with a vision to empower students, we have grown into a leading consultancy firm.</p><p>Our commitment to excellence ensures that every student who walks through our doors receives the best possible advice for their future career.</p>";
        break;
    default:
        $generated_html = "<p>Professional content about <strong>$title</strong>. This comprehensive overview covers the essential aspects and provides valuable insights into the subject matter.</p>";
        break;
}

echo json_encode([
    'success' => true,
    'content' => $generated_html,
    'message' => 'Content generated successfully (Simulated AI)'
]);
