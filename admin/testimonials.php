<?php
// admin/testimonials.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_testimonials')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

require_once __DIR__ . '/components/header.php';

// Handle Action (Approve/Reject/Delete)
if (isset($_POST['action'])) {
    $id = (int)$_POST['id'];
    if ($_POST['action'] == 'approve') {
        $pdo->prepare("UPDATE testimonial SET status = 'approved' WHERE id = ?")->execute([$id]);
        set_flash_msg('success', 'Testimonial approved.');
    } elseif ($_POST['action'] == 'reject') {
        $pdo->prepare("UPDATE testimonial SET status = 'rejected' WHERE id = ?")->execute([$id]);
        set_flash_msg('success', 'Testimonial rejected.');
    } elseif ($_POST['action'] == 'delete') {
        $item = $pdo->query("SELECT image FROM testimonial WHERE id=$id")->fetch();
        if ($item && $item['image'] && file_exists(__DIR__ . '/../uploads/testimonials/' . $item['image'])) {
            unlink(__DIR__ . '/../uploads/testimonials/' . $item['image']);
        }
        $pdo->prepare("DELETE FROM testimonial WHERE id = ?")->execute([$id]);
        set_flash_msg('success', 'Testimonial deleted.');
    }
    redirect('testimonials.php');
}

$testimonials = $pdo->query("SELECT * FROM testimonial ORDER BY id DESC")->fetchAll();
?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800">Visitor Testimonials</h3>
        <p class="text-slate-500 text-sm">Approve or reject reviews submitted by visitors.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse datatable">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b">Image</th>
                    <th class="p-4 border-b">Name & Role</th>
                    <th class="p-4 border-b">Message</th>
                    <th class="p-4 border-b">Status</th>
                    <th class="p-4 border-b text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-slate-700 text-sm">
                <?php foreach($testimonials as $item): ?>
                <tr class="hover:bg-slate-50 border-b">
                    <td class="p-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden border">
                            <img src="<?php echo $item['image'] ? '../uploads/testimonials/'.$item['image'] : 'https://ui-avatars.com/api/?name='.urlencode($item['name']); ?>" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="font-semibold text-slate-800"><?php echo htmlspecialchars($item['name']); ?></div>
                        <div class="text-xs text-slate-500 capitalize"><?php echo htmlspecialchars($item['role']); ?></div>
                    </td>
                    <td class="p-4"><div class="max-w-xs text-xs italic">"<?php echo htmlspecialchars($item['message']); ?>"</div></td>
                    <td class="p-4">
                        <?php 
                        $status_class = [
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'approved' => 'bg-green-100 text-green-700',
                            'rejected' => 'bg-red-100 text-red-700'
                        ];
                        ?>
                        <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase <?php echo $status_class[$item['status']] ?? 'bg-slate-100 text-slate-700'; ?>">
                            <?php echo $item['status']; ?>
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex gap-2 justify-center">
                            <?php if($item['status'] != 'approved'): ?>
                            <form method="POST" action="testimonials.php">
                                <input type="hidden" name="action" value="approve">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <button type="submit" class="p-2 rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition" title="Approve">
                                    <i class="ph ph-check text-lg"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                            <?php if($item['status'] != 'rejected'): ?>
                            <form method="POST" action="testimonials.php">
                                <input type="hidden" name="action" value="reject">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <button type="submit" class="p-2 rounded-lg bg-orange-100 text-orange-600 hover:bg-orange-200 transition" title="Reject">
                                    <i class="ph ph-prohibit text-lg"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                            <form method="POST" action="testimonials.php" onsubmit="return confirm('Delete permanently?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <button type="submit" class="p-2 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition" title="Delete">
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
