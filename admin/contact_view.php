<?php
// admin/contact_view.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_contacts')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = null;

if ($id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = ?");
        $stmt->execute([$id]);
        $message = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($message && $message['status'] == 'unread') {
            $pdo->prepare("UPDATE contact_messages SET status = 'read' WHERE id = ?")->execute([$id]);
        }
    } catch (Exception $e) {}
}

if (!$message) {
    set_flash_msg('error', 'Message not found.');
    redirect('contacts.php');
}

require_once __DIR__ . '/components/header.php';
?>

<div class="mb-6">
    <a href="contacts.php" class="inline-flex items-center gap-2 text-slate-500 hover:text-secondary transition text-sm font-medium">
        <i class="ph ph-arrow-left"></i> Back to Messages
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-slate-100 bg-slate-50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <h3 class="text-2xl font-bold text-slate-800"><?php echo htmlspecialchars($message['subject']); ?></h3>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-[10px] font-bold uppercase rounded-full">Contact Inquiry</span>
            </div>
            <p class="text-slate-500 text-sm">Received on <?php echo date('F d, Y \a\t H:i', strtotime($message['created_at'])); ?></p>
        </div>
        <div class="flex gap-2">
            <a href="mailto:<?php echo htmlspecialchars($message['email']); ?>" class="px-4 py-2 bg-secondary text-white rounded-lg hover:bg-accent transition flex items-center gap-2 text-sm font-bold">
                <i class="ph ph-paper-plane-tilt"></i> Reply via Email
            </a>
            <form action="contacts.php" method="POST" onsubmit="return confirm('Delete this message?');" class="inline">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?php echo $message['id']; ?>">
                <button type="submit" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                    <i class="ph ph-trash text-xl"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Body -->
    <div class="p-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Sender Name</p>
                <p class="text-slate-800 font-bold"><?php echo htmlspecialchars($message['name']); ?></p>
            </div>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Email Address</p>
                <p class="text-secondary font-bold underline italic"><?php echo htmlspecialchars($message['email']); ?></p>
            </div>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Submission status</p>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                    <p class="text-slate-800 font-bold capitalize">Stored & Logged</p>
                </div>
            </div>
        </div>

        <div>
            <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4 border-b pb-2">Message Content</h4>
            <div class="bg-white border rounded-2xl p-6 text-slate-700 leading-relaxed font-light whitespace-pre-wrap min-h-[200px]">
                <?php echo nl2br(htmlspecialchars($message['message'])); ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/components/footer.php'; ?>
