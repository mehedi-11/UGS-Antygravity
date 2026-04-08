<?php
// admin/appointments.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_appointments')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

require_once __DIR__ . '/components/header.php';

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = (int)$_POST['id'];
    $pdo->prepare("DELETE FROM appointment WHERE id = ?")->execute([$id]);
    set_flash_msg('success', 'Appointment deleted.');
    redirect('appointments.php');
}

$appointments = $pdo->query("SELECT * FROM appointment ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800">Booking Appointments</h3>
        <p class="text-slate-500 text-sm">Review requests from students for consultancy sessions.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse datatable">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b">Date Requested</th>
                    <th class="p-4 border-b">Visitor Info</th>
                    <th class="p-4 border-b">Study Preference</th>
                    <th class="p-4 border-b">Academic Info</th>
                    <th class="p-4 border-b text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-slate-700 text-sm">
                <?php foreach($appointments as $item): ?>
                <tr class="hover:bg-slate-50 border-b">
                    <td class="p-4 align-top"><?php echo date('M d, Y H:i', strtotime($item['created_at'])); ?></td>
                    <td class="p-4 align-top">
                        <div class="font-bold text-slate-800"><?php echo htmlspecialchars($item['name']); ?></div>
                        <div class="text-xs text-slate-500"><?php echo htmlspecialchars($item['email']); ?></div>
                        <div class="text-xs text-secondary mt-1 font-semibold"><?php echo htmlspecialchars($item['phone']); ?></div>
                        <div class="text-xs text-slate-400 mt-1"><?php echo htmlspecialchars(substr($item['address'] ?? '', 0, 50)); ?></div>
                    </td>
                    <td class="p-4 align-top">
                        <div class="text-xs font-semibold uppercase text-slate-400">Target Country</div>
                        <div class="mb-2 font-medium text-dark"><?php echo htmlspecialchars($item['interest_country'] ?? 'N/A'); ?></div>
                        <div class="text-xs font-semibold uppercase text-slate-400">Course & Degree</div>
                        <div class="text-secondary"><?php echo htmlspecialchars($item['interested_course'] ?? 'N/A'); ?> <span class="text-slate-500 text-xs">(<?php echo htmlspecialchars($item['degree'] ?? 'N/A'); ?>)</span></div>
                    </td>
                    <td class="p-4 align-top">
                        <div class="text-xs font-semibold uppercase text-slate-400">Last Education</div>
                        <div class="mb-2"><?php echo htmlspecialchars($item['last_academic_education'] ?? 'N/A'); ?> - <?php echo htmlspecialchars($item['passing_year'] ?? 'N/A'); ?></div>
                        <div class="text-xs font-semibold uppercase text-slate-400">English Test</div>
                        <div>
                            <?php if(!empty($item['english_test']) && strtolower($item['english_test']) === 'yes'): ?>
                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs"><?php echo htmlspecialchars($item['test_name']); ?>: <?php echo htmlspecialchars($item['test_results']); ?></span>
                            <?php else: ?>
                                <span class="bg-slate-100 text-slate-500 px-2 py-0.5 rounded text-xs">No Test Taken</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="p-4 text-center align-top flex justify-center gap-2">
                        <a href="appointment_view.php?id=<?php echo $item['id']; ?>" class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition">
                            <i class="ph ph-eye text-lg"></i>
                        </a>
                        <form action="appointments.php" method="POST" onsubmit="return confirm('Delete this record?');" class="inline">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <button type="submit" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-200 transition mx-auto">
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
