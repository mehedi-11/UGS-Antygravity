<?php
// admin/subscribers.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_subscribers')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

require_once __DIR__ . '/components/header.php';

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = (int)$_POST['id'];
    $pdo->prepare("DELETE FROM subscriber WHERE id = ?")->execute([$id]);
    set_flash_msg('success', 'Subscriber removed.');
    redirect('subscribers.php');
}

$subscribers = $pdo->query("SELECT * FROM subscriber ORDER BY id DESC")->fetchAll();
?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Email Subscribers</h3>
            <p class="text-slate-500 text-sm">List of people who subscribed to your newsletter.</p>
        </div>
        <button onclick="exportCSV()" class="px-4 py-2 bg-slate-800 hover:bg-black text-white font-medium rounded-lg shadow transform transition flex items-center gap-2">
            <i class="ph ph-file-csv text-xl"></i> Export CSV
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse datatable">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b">Email Address</th>
                    <th class="p-4 border-b">Subscription Date</th>
                    <th class="p-4 border-b text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-slate-700 text-sm">
                <?php foreach($subscribers as $item): ?>
                <tr class="hover:bg-slate-50 border-b">
                    <td class="p-4 font-semibold text-slate-800"><?php echo htmlspecialchars($item['email']); ?></td>
                    <td class="p-4 text-slate-500"><?php echo date('M d, Y H:i', strtotime($item['created_at'])); ?></td>
                    <td class="p-4 text-center">
                         <form action="subscribers.php" method="POST" onsubmit="return confirm('Remove this email?');" class="inline">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
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

<script>
    function exportCSV() {
        let csv = 'Email,Date\n';
        <?php foreach($subscribers as $item): ?>
        csv += '<?php echo $item['email']; ?>,<?php echo $item['created_at']; ?>\n';
        <?php endforeach; ?>
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.setAttribute('hidden', '');
        a.setAttribute('href', url);
        a.setAttribute('download', 'subscribers.csv');
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
