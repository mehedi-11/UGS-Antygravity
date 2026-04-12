<?php
// admin/contacts.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_contacts')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

// Self-healing: Ensure table exists
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS contact_messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        subject VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        status ENUM('unread', 'read') DEFAULT 'unread',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
} catch (Exception $e) {}

require_once __DIR__ . '/components/header.php';

// Handle Action
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = (int)$_POST['id'];
    $pdo->prepare("DELETE FROM contact_messages WHERE id = ?")->execute([$id]);
    set_flash_msg('success', 'Message deleted.');
    redirect('contacts.php');
}

$messages = $pdo->query("SELECT * FROM contact_messages ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800">Contact Messages</h3>
        <p class="text-slate-500 text-sm">Review recently submitted messages from the contact form.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse datatable">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b font-medium">Date</th>
                    <th class="p-4 border-b font-medium">Visitor</th>
                    <th class="p-4 border-b font-medium text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-slate-700 text-sm">
                <?php foreach($messages as $msg): ?>
                <tr class="hover:bg-slate-50 border-b last:border-0 <?php echo $msg['status'] == 'unread' ? 'bg-orange-50/50' : ''; ?>">
                    <td class="p-4 align-top">
                        <div class="text-xs font-bold text-slate-400 uppercase"><?php echo date('M d, Y', strtotime($msg['created_at'])); ?></div>
                        <div class="text-[10px] text-slate-400"><?php echo date('H:i', strtotime($msg['created_at'])); ?></div>
                    </td>
                    <td class="p-4 align-top">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-bold text-slate-800"><?php echo htmlspecialchars($msg['name']); ?></span>
                            <?php if($msg['status'] == 'unread'): ?>
                                <span class="px-1.5 py-0.5 bg-secondary text-white text-[10px] rounded font-bold uppercase tracking-tighter">New</span>
                            <?php endif; ?>
                        </div>
                        <div class="text-xs text-slate-500 mb-2 italic"><?php echo htmlspecialchars($msg['email']); ?></div>
                        <div class="text-sm font-semibold text-slate-700"><?php echo htmlspecialchars($msg['subject']); ?></div>
                        <div class="text-xs text-slate-400 mt-1 line-clamp-2"><?php echo htmlspecialchars($msg['message']); ?></div>
                    </td>
                    <td class="p-4 text-center align-top">
                        <div class="flex justify-center gap-2">
                            <a href="contact_view.php?id=<?php echo $msg['id']; ?>" class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition" title="View Message">
                                <i class="ph ph-eye text-lg"></i>
                            </a>
                            <form action="contacts.php" method="POST" onsubmit="return confirm('Delete this message?');" class="inline">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-200 transition">
                                    <i class="ph ph-trash text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/components/footer.php'; ?>
