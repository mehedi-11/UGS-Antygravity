<?php
// admin/chatbot.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_chatbot')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

require_once __DIR__ . '/components/header.php';

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = (int)$_POST['id'];
    $pdo->prepare("DELETE FROM chatbot_leads WHERE id = ?")->execute([$id]);
    set_flash_msg('success', 'Lead deleted.');
    redirect('chatbot.php');
}

$leads = $pdo->query("SELECT * FROM chatbot_leads ORDER BY created_at DESC")->fetchAll();
?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800">Chatbot Leads</h3>
        <p class="text-slate-500 text-sm">View details gathered from the AI Chatbot interactions.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse datatable">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b">Date</th>
                    <th class="p-4 border-b">Topic</th>
                    <th class="p-4 border-b">Name</th>
                    <th class="p-4 border-b">Email/Phone</th>
                    <th class="p-4 border-b">Country/Course</th>
                    <th class="p-4 border-b text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-slate-700 text-sm">
                <?php foreach($leads as $item): ?>
                <tr class="hover:bg-slate-50 border-b">
                    <td class="p-4"><?php echo date('M d, Y H:i', strtotime($item['created_at'])); ?></td>
                    <td class="p-4 font-semibold text-slate-800"><span class="bg-orange-100 text-secondary px-2 py-1 rounded text-xs"><?php echo htmlspecialchars($item['topic']); ?></span></td>
                    <td class="p-4"><?php echo htmlspecialchars($item['name']); ?></td>
                    <td class="p-4">
                        <div class="flex flex-col">
                            <span class="text-secondary"><?php echo htmlspecialchars($item['email']); ?></span>
                            <span class="text-xs text-slate-500"><?php echo htmlspecialchars($item['phone']); ?></span>
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="flex flex-col">
                            <span class="font-medium"><?php echo htmlspecialchars($item['country']); ?></span>
                            <span class="text-xs text-slate-500"><?php echo htmlspecialchars($item['course']); ?></span>
                        </div>
                    </td>
                    <td class="p-4 flex gap-2 justify-center">
                        <a href="chatbot_view.php?id=<?php echo $item['id']; ?>" class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition">
                            <i class="ph ph-eye text-lg"></i>
                        </a>
                        <form action="chatbot.php" method="POST" onsubmit="return confirm('Delete this lead?');" class="inline">
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

<?php require_once __DIR__ . '/components/footer.php'; ?>
