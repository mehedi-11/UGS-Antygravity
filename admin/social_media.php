<?php
// admin/social_media.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_social_media')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

require_once __DIR__ . '/components/header.php';

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = (int)$_POST['id'];
    $pdo->prepare("DELETE FROM social_media WHERE id = ?")->execute([$id]);
    set_flash_msg('success', 'Link deleted.');
    redirect('social_media.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'save') {
    $id = $_POST['id'] ?? '';
    $social_media_name = sanitize($_POST['social_media_name']);
    $link = sanitize($_POST['link']);
    $icon = sanitize($_POST['icon']);

    if ($id) {
        $stmt = $pdo->prepare("UPDATE social_media SET social_media_name=?, link=?, icon=? WHERE id=?");
        $stmt->execute([$social_media_name, $link, $icon, $id]);
        set_flash_msg('success', 'Link updated.');
    } else {
        $pos = $pdo->query("SELECT MAX(position) FROM social_media")->fetchColumn();
        $pos = $pos ? $pos + 1 : 1;

        $stmt = $pdo->prepare("INSERT INTO social_media (social_media_name, link, icon, position) VALUES (?, ?, ?, ?)");
        $stmt->execute([$social_media_name, $link, $icon, $pos]);
        set_flash_msg('success', 'Link added.');
    }
    redirect('social_media.php');
}

$links = $pdo->query("SELECT * FROM social_media ORDER BY position ASC")->fetchAll();
?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Social Media Links</h3>
            <p class="text-slate-500 text-sm">Use Phosphor Icons (e.g. ph-facebook-logo) for standard icons.</p>
        </div>
        <button onclick="openModal()" class="px-4 py-2 bg-secondary hover:bg-accent text-white font-medium rounded-lg shadow transform transition flex items-center gap-2">
            <i class="ph ph-plus-circle text-xl"></i> Add Link
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b w-10"></th>
                    <th class="p-4 border-b">Icon/Name</th>
                    <th class="p-4 border-b">Link URL</th>
                    <th class="p-4 border-b text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="sortableBody" class="text-slate-700 text-sm">
                <?php foreach($links as $item): ?>
                <tr class="hover:bg-slate-50 border-b cursor-move" data-id="<?php echo $item['id']; ?>">
                    <td class="p-4 text-slate-400"><i class="ph ph-dots-six-vertical text-xl"></i></td>
                    <td class="p-4 font-semibold text-slate-800 flex items-center gap-2">
                        <i class="ph <?php echo htmlspecialchars($item['icon']); ?> text-2xl text-secondary"></i>
                        <?php echo htmlspecialchars($item['social_media_name']); ?>
                    </td>
                    <td class="p-4 text-blue-500"><a href="<?php echo htmlspecialchars($item['link']); ?>" target="_blank" class="hover:underline"><?php echo htmlspecialchars($item['link']); ?></a></td>
                    <td class="p-4 flex gap-2 justify-center">
                        <button type="button" onclick='editItem(<?php echo json_encode($item); ?>)' class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition">
                            <i class="ph ph-pencil-simple text-lg"></i>
                        </button>
                        <form action="social_media.php" method="POST" onsubmit="return confirm('Delete this link?');" class="inline">
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

<div id="itemModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl overflow-hidden mt-10 mb-10">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="text-lg font-bold text-slate-800" id="modalTitle">Add Link</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition"><i class="ph ph-x text-xl"></i></button>
        </div>
        <form method="POST" action="social_media.php" class="p-6 space-y-4">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" id="item_id">
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Platform Name (e.g., Facebook)</label>
                <input type="text" name="social_media_name" id="social_media_name" required class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">URL Link</label>
                <input type="url" name="link" id="link" required class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Phosphor Icon Class (e.g., ph-facebook-logo)</label>
                <input type="text" name="icon" id="icon" required class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                <a href="https://phosphoricons.com/" target="_blank" class="text-xs text-blue-500 hover:underline mt-1 inline-block">Find icons here</a>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t mt-4">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 transition">Cancel</button>
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-secondary text-white hover:bg-accent transition">Save Link</button>
            </div>
        </form>
    </div>
</div>

<script>
    if(document.getElementById('sortableBody')) {
        new Sortable(document.getElementById('sortableBody'), {
            animation: 150, ghostClass: 'bg-orange-50',
            onEnd: function (evt) {
                let order = [];
                $('#sortableBody tr').each(function() { order.push($(this).data('id')); });
                $.post('api/update_position.php', { table: 'social_media', order: order });
            }
        });
    }

    const modal = document.getElementById('itemModal');
    function openModal() {
        document.getElementById('modalTitle').innerText = 'Add Link';
        document.getElementById('item_id').value = '';
        document.getElementById('social_media_name').value = '';
        document.getElementById('link').value = '';
        document.getElementById('icon').value = '';
        modal.classList.remove('hidden');
    }
    function editItem(data) {
        document.getElementById('modalTitle').innerText = 'Edit Link';
        document.getElementById('item_id').value = data.id;
        document.getElementById('social_media_name').value = data.social_media_name;
        document.getElementById('link').value = data.link;
        document.getElementById('icon').value = data.icon;
        modal.classList.remove('hidden');
    }
    function closeModal() { modal.classList.add('hidden'); }
</script>
<?php require_once __DIR__ . '/components/footer.php'; ?>
