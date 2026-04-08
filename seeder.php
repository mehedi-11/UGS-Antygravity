<?php
require_once __DIR__ . '/config/database.php';

// Seed Services
$services = [
    ['title' => 'University Admission', 'icon_class' => 'fa-solid fa-graduation-cap', 'details' => 'End-to-end support for applying to the best global universities.'],
    ['title' => 'Visa Processing', 'icon_class' => 'fa-solid fa-passport', 'details' => 'Expert guidance to ensure your visa application is flawless.'],
    ['title' => 'Scholarship Assistance', 'icon_class' => 'fa-solid fa-award', 'details' => 'Help securing financial aid and scholarships for your studies.'],
];
foreach($services as $i => $s) {
    // Check if exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM services WHERE title=?");
    $stmt->execute([$s['title']]);
    if ($stmt->fetchColumn() == 0) {
        $stmt = $pdo->prepare("INSERT INTO services (title, icon_class, details, position) VALUES (?, ?, ?, ?)");
        $stmt->execute([$s['title'], $s['icon_class'], $s['details'], $i+1]);
    }
}

// Seed Achievement
try {
    $achs = [
        ['name' => '10+', 'details' => 'Years Experience'],
        ['name' => '500+', 'details' => 'Partner Universities'],
        ['name' => '50k+', 'details' => 'Successful Students'],
        ['name' => '98%', 'details' => 'Visa Success Rate'],
    ];
    foreach($achs as $i => $a) {
        // We handle achievement vs achievements table name
        $stmt = $pdo->prepare("INSERT INTO achievements (title, details, position) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$a['name'], $a['details'], $i+1]);
        } catch(Exception $e) {
             $stmt2 = $pdo->prepare("INSERT INTO achievement (name, details, position) VALUES (?, ?, ?)");
             try {
                $stmt2->execute([$a['name'], $a['details'], $i+1]);
             } catch(Exception $e2) {}
        }
    }
} catch(Exception $e) {}

echo "Seeded successfully.\n";
?>
