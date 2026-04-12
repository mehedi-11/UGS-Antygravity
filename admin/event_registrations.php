<?php
// admin/event_registrations.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_events')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

// Self-healing: Ensure table exists
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS event_registrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        event_id INT NOT NULL,
        name VARCHAR(255),
        email VARCHAR(255),
        phone VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
} catch (Exception $e) {}

$event_id = (int)($_GET['id'] ?? 0);
$event = $pdo->query("SELECT title FROM event WHERE id = $event_id")->fetch();

if (!$event) {
    set_flash_msg('error', 'Event not found.');
    redirect('events.php');
}

// Handle Download CSV
if (isset($_GET['download']) && $_GET['download'] == 'csv') {
    $registrations = $pdo->query("SELECT name, email, phone, created_at FROM event_registrations WHERE event_id = $event_id ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    
    $filename = "registrations_" . str_replace(' ', '_', strtolower($event['title'])) . "_" . date('Y-m-d') . ".csv";
    
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);
    
    $output = fopen('php://output', 'w');
    // Add UTF-8 BOM for Excel compatibility
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    fputcsv($output, ['Name', 'Email', 'Phone', 'Registration Date']);
    
    foreach ($registrations as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

require_once __DIR__ . '/components/header.php';

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = (int)$_POST['reg_id'];
    $pdo->prepare("DELETE FROM event_registrations WHERE id = ?")->execute([$id]);
    set_flash_msg('success', 'Registration removed.');
    redirect("event_registrations.php?id=$event_id");
}

$registrations = $pdo->query("SELECT * FROM event_registrations WHERE event_id = $event_id ORDER BY id DESC")->fetchAll();
?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="events.php" class="text-secondary hover:underline flex items-center gap-1 text-sm font-medium">
                    <i class="ph ph-arrow-left"></i> Back to Events
                </a>
            </div>
            <h3 class="text-xl font-bold text-slate-800"><?php echo htmlspecialchars($event['title']); ?></h3>
            <p class="text-slate-500 text-sm">Attendee List & Registrations</p>
        </div>
        <div class="flex gap-2">
            <a href="event_registrations.php?id=<?php echo $event_id; ?>&download=csv" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm transition flex items-center gap-2 text-sm">
                <i class="ph ph-download-simple text-lg"></i> Download CSV
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse datatable">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b font-medium">Name</th>
                    <th class="p-4 border-b font-medium">Contact Info</th>
                    <th class="p-4 border-b font-medium">Date</th>
                    <th class="p-4 border-b font-medium text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-slate-700 text-sm">
                <?php foreach($registrations as $item): ?>
                <tr class="hover:bg-slate-50 border-b last:border-0">
                    <td class="p-4 font-bold text-slate-800"><?php echo htmlspecialchars($item['name']); ?></td>
                    <td class="p-4">
                        <div class="font-medium text-slate-600"><?php echo htmlspecialchars($item['email']); ?></div>
                        <div class="text-xs text-secondary"><?php echo htmlspecialchars($item['phone']); ?></div>
                    </td>
                    <td class="p-4 text-slate-400 text-xs">
                        <?php echo date('M d, Y', strtotime($item['created_at'])); ?><br>
                        <?php echo date('H:i', strtotime($item['created_at'])); ?>
                    </td>
                    <td class="p-4 text-center">
                        <form action="event_registrations.php?id=<?php echo $event_id; ?>" method="POST" onsubmit="return confirm('Remove registration?');" class="inline">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="reg_id" value="<?php echo $item['id']; ?>">
                            <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition">
                                <i class="ph ph-trash text-lg"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/components/footer.php'; ?>
