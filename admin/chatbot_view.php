<?php
// admin/chatbot_view.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_chatbot')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    redirect('chatbot.php');
}

// Fetch lead
$stmt = $pdo->prepare("SELECT * FROM chatbot_leads WHERE id = ?");
$stmt->execute([$id]);
$lead = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$lead) {
    set_flash_msg('error', 'Lead not found.');
    redirect('chatbot.php');
}

require_once __DIR__ . '/components/header.php';
?>

<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="chatbot.php" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 transition">
            <i class="ph ph-arrow-left text-xl"></i>
        </a>
        <div>
            <h3 class="text-xl font-bold text-slate-800">Chatbot Lead Details</h3>
            <p class="text-slate-500 text-sm">Review full context captured by the AI.</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-3xl">
    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
        <div class="w-16 h-16 rounded-2xl bg-orange-100 text-secondary flex items-center justify-center text-3xl">
            <i class="ph ph-robot"></i>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-slate-800"><?php echo htmlspecialchars($lead['name']); ?></h2>
            <p class="text-slate-500">Submitted on: <?php echo date('F d, Y - h:i A', strtotime($lead['created_at'])); ?></p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div>
            <span class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Inquiry Topic</span>
            <span class="inline-block bg-orange-100 text-secondary px-3 py-1 rounded font-semibold text-sm"><?php echo htmlspecialchars($lead['topic']); ?></span>
        </div>
        <div>
            <span class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Contact Email</span>
            <span class="font-medium text-slate-800"><?php echo htmlspecialchars($lead['email']); ?></span>
        </div>
        <div>
            <span class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Phone Number</span>
            <span class="font-medium text-slate-800"><?php echo htmlspecialchars($lead['phone']); ?></span>
        </div>
        <div>
            <span class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Target Country</span>
            <span class="font-medium text-slate-800"><?php echo htmlspecialchars($lead['country'] ? $lead['country'] : 'Not Provided'); ?></span>
        </div>
        <div class="md:col-span-2">
            <span class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Desired Course / Program</span>
            <span class="font-medium text-slate-800"><?php echo htmlspecialchars($lead['course'] ? $lead['course'] : 'Not Provided'); ?></span>
        </div>
    </div>

    <div class="bg-slate-50 p-6 rounded-xl border border-slate-100">
        <span class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Message / Address Data</span>
        <p class="text-slate-700 leading-relaxed font-mono text-sm whitespace-pre-wrap"><?php echo htmlspecialchars($lead['address'] ? $lead['address'] : 'No additional message was provided during the chat.'); ?></p>
    </div>

    <div class="mt-8 pt-6 border-t border-slate-100 flex gap-4">
        <a href="mailto:<?php echo htmlspecialchars($lead['email']); ?>" class="bg-secondary hover:bg-accent text-white px-6 py-2 rounded-lg font-bold transition flex items-center gap-2">
            <i class="ph ph-envelope-simple-open"></i> Reply via Email
        </a>
    </div>
</div>

<?php require_once __DIR__ . '/components/footer.php'; ?>
