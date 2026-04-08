<?php
// admin/event_registrations.php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/functions.php';

check_login();

if (!has_permission('manage_events')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

$event_id = (int)($_GET['id'] ?? 0);
$event = $pdo->query("SELECT title FROM event WHERE id = $event_id")->fetch();

if (!$event) {
    set_flash_msg('error', 'Event not found.');
    redirect('events.php');
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
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="events.php" class="text-secondary hover:underline flex items-center gap-1 text-sm font-medium">
                    <i class="ph ph-arrow-left"></i> Back to Events
                </a>
            </div>
            <h3 class="text-xl font-bold text-slate-800">Registrations: <?php echo htmlspecialchars($event['title']); ?></h3>
            <p class="text-slate-500 text-sm">List of people signed up for this seminar/event.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse datatable">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b">Name</th>
                    <th class="p-4 border-b">Contact Info</th>
                    <th class="p-4 border-b">Registration Date</th>
                    <th class="p-4 border-b text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-slate-700 text-sm">
                <?php foreach($registrations as $item): ?>
                <tr class="hover:bg-slate-50 border-b">
                    <td class="p-4 font-semibold text-slate-800"><?php echo htmlspecialchars($item['name']); ?></td>
                    <td class="p-4">
                        <div class="text-xs text-slate-500">Email: <?php echo htmlspecialchars($item['email']); ?></div>
                        <div class="text-xs text-secondary">Phone: <?php echo htmlspecialchars($item['phone']); ?></div>
                    </td>
                    <td class="p-4 text-slate-500"><?php echo date('M d, Y H:i', strtotime($item['created_at'])); ?></td>
                    <td class="p-4 text-center">
                         <form action="event_registrations.php?id=<?php echo $event_id; ?>" method="POST" onsubmit="return confirm('Remove registration?');" class="inline">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="reg_id" value="<?php echo $item['id']; ?>">
                            <button type="submit" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-200 transition">
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
