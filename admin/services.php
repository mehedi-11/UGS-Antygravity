<?php
// admin/services.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_services')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

require_once __DIR__ . '/components/header.php';

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = (int)$_POST['id'];
    $item = $pdo->query("SELECT image FROM services WHERE id=$id")->fetch();
    if ($item && $item['image'] && file_exists(__DIR__ . '/../uploads/services/' . $item['image'])) {
        unlink(__DIR__ . '/../uploads/services/' . $item['image']);
    }
    $pdo->prepare("DELETE FROM services WHERE id = ?")->execute([$id]);
    set_flash_msg('success', 'Service deleted.');
    redirect('services.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'save') {
    $id = $_POST['id'] ?? '';
    $title = sanitize($_POST['title']);
    $icon_class = sanitize($_POST['icon_class']);
    $details = sanitize($_POST['details']);
    $image = '';

    if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
        $uploaded = upload_image($_FILES['image'], 'services');
        if ($uploaded) {
            $image = $uploaded;
        }
    }

    if ($id) {
        $old = $pdo->query("SELECT image FROM services WHERE id=".(int)$id)->fetch();
        if ($image) {
            if ($old && $old['image'] && file_exists(__DIR__ . '/../uploads/services/' . $old['image'])) {
                unlink(__DIR__ . '/../uploads/services/' . $old['image']);
            }
        } else {
            $image = $old['image'] ?? '';
        }

        $stmt = $pdo->prepare("UPDATE services SET title=?, icon_class=?, details=?, image=? WHERE id=?");
        $stmt->execute([$title, $icon_class, $details, $image, $id]);
        set_flash_msg('success', 'Service updated.');
    } else {
        $pos = $pdo->query("SELECT MAX(position) FROM services")->fetchColumn();
        $pos = $pos ? $pos + 1 : 1;

        $stmt = $pdo->prepare("INSERT INTO services (title, icon_class, details, image, position) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $icon_class, $details, $image, $pos]);
        set_flash_msg('success', 'Service added.');
    }
    redirect('services.php');
}

$services = $pdo->query("SELECT * FROM services ORDER BY position ASC")->fetchAll();
?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Manage Services</h3>
            <p class="text-slate-500 text-sm">Drag and drop rows to reorder positions.</p>
        </div>
        <button onclick="openModal()" class="px-4 py-2 bg-secondary hover:bg-accent text-white font-medium rounded-lg shadow transform transition flex items-center gap-2">
            <i class="ph ph-plus-circle text-xl"></i> Add Service
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b w-10"></th>
                    <th class="p-4 border-b w-24">Image/Icon</th>
                    <th class="p-4 border-b">Title</th>
                    <th class="p-4 border-b">Details</th>
                    <th class="p-4 border-b text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="sortableBody" class="text-slate-700 text-sm">
                <?php foreach($services as $item): ?>
                <tr class="hover:bg-slate-50 border-b cursor-move" data-id="<?php echo $item['id']; ?>">
                    <td class="p-4 text-slate-400"><i class="ph ph-dots-six-vertical text-xl"></i></td>
                    <td class="p-4">
                        <?php if($item['image']): ?>
                        <div class="w-16 h-12 object-cover overflow-hidden rounded border inline-block">
                            <img src="../uploads/services/<?php echo $item['image']; ?>" class="w-full h-full object-cover">
                        </div>
                        <?php elseif($item['icon_class']): ?>
                        <div class="w-12 h-12 bg-orange-100 text-secondary rounded flex items-center justify-center text-2xl border border-orange-200">
                            <i class="<?php echo htmlspecialchars($item['icon_class']); ?>"></i>
                        </div>
                        <?php else: ?>
                        <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded flex items-center justify-center text-xl border">
                             <i class="ph ph-image-square"></i>
                        </div>
                        <?php endif; ?>
                    </td>
                    <td class="p-4 font-semibold text-slate-800"><?php echo htmlspecialchars($item['title']); ?></td>
                    <td class="p-4"><div class="w-64 truncate"><?php echo htmlspecialchars($item['details']); ?></div></td>
                    <td class="p-4 flex gap-2 justify-center">
                        <button type="button" onclick='editItem(<?php echo json_encode($item); ?>)' class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition">
                            <i class="ph ph-pencil-simple text-lg"></i>
                        </button>
                        <form action="services.php" method="POST" onsubmit="return confirm('Delete this service?');" class="inline">
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

<!-- Modal -->
<div id="itemModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl overflow-hidden mt-10 mb-10">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="text-lg font-bold text-slate-800" id="modalTitle">Add Service</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition"><i class="ph ph-x text-xl"></i></button>
        </div>
        <form method="POST" action="services.php" enctype="multipart/form-data" class="p-6 space-y-4">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" id="item_id">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Service Title</label>
                    <input type="text" name="title" id="title" required class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">FontAwesome Icon Class</label>
                    <input type="text" name="icon_class" id="icon_class" placeholder="e.g. fa-solid fa-gear" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Details</label>
                <textarea name="details" id="details" rows="4" required class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Image / Icon (Optional if Icon Class is used)</label>
                <input type="file" name="image" id="image" accept="image/*" class="w-full px-3 py-2 border rounded-lg">
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t mt-4">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 transition">Cancel</button>
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-secondary text-white hover:bg-accent transition">Save Service</button>
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
                $.post('api/update_position.php', { table: 'services', order: order });
            }
        });
    }

    const modal = document.getElementById('itemModal');

    function openModal() {
        document.getElementById('modalTitle').innerText = 'Add Service';
        document.getElementById('item_id').value = '';
        document.getElementById('title').value = '';
        document.getElementById('icon_class').value = '';
        document.getElementById('details').value = '';
        modal.classList.remove('hidden');
    }
    function editItem(data) {
        document.getElementById('modalTitle').innerText = 'Edit Service';
        document.getElementById('item_id').value = data.id;
        document.getElementById('title').value = data.title;
        document.getElementById('icon_class').value = data.icon_class;
        document.getElementById('details').value = data.details;
        modal.classList.remove('hidden');
    }
    function closeModal() { modal.classList.add('hidden'); }
</script>
<?php require_once __DIR__ . '/components/footer.php'; ?>
