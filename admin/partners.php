<?php
// admin/partners.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_partners')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

require_once __DIR__ . '/components/header.php';

// Handle Delete
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = (int)$_POST['id'];
    $partner = $pdo->query("SELECT logo FROM partners WHERE id=$id")->fetch();
    if ($partner && $partner['logo'] && file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/partners/' . $partner['logo'])) {
        unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/partners/' . $partner['logo']);
    }
    $pdo->prepare("DELETE FROM partners WHERE id = ?")->execute([$id]);
    set_flash_msg('success', 'Partner deleted.');
    redirect('partners.php');
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'save') {
    $id = $_POST['id'] ?? '';
    $company_name = sanitize($_POST['company_name']);
    $company_location = sanitize($_POST['company_location']);
    $partnered_from = $_POST['partnered_from'];
    $details = sanitize($_POST['details']);
    $logo = '';

    if (isset($_FILES['logo']['name']) && !empty($_FILES['logo']['name'])) {
        $uploaded = upload_image($_FILES['logo'], 'partners');
        if ($uploaded) {
            $logo = $uploaded;
        }
    }

    if ($id) {
        $old = $pdo->query("SELECT logo FROM partners WHERE id=".(int)$id)->fetch();
        if ($logo) {
            if ($old && $old['logo'] && file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/partners/' . $old['logo'])) {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/partners/' . $old['logo']);
            }
        } else {
            $logo = $old['logo'] ?? '';
        }

        $stmt = $pdo->prepare("UPDATE partners SET company_name=?, company_location=?, partnered_from=?, details=?, logo=? WHERE id=?");
        $stmt->execute([$company_name, $company_location, $partnered_from, $details, $logo, $id]);
        set_flash_msg('success', 'Partner updated.');
    } else {
        $pos = $pdo->query("SELECT MAX(position) FROM partners")->fetchColumn();
        $pos = $pos ? $pos + 1 : 1;

        $stmt = $pdo->prepare("INSERT INTO partners (company_name, company_location, partnered_from, details, logo, position) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$company_name, $company_location, $partnered_from, $details, $logo, $pos]);
        set_flash_msg('success', 'Partner added.');
    }
    redirect('partners.php');
}

$partners = $pdo->query("SELECT * FROM partners ORDER BY position ASC")->fetchAll();
?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Industry Partners</h3>
            <p class="text-slate-500 text-sm">Drag and drop rows to reorder positions.</p>
        </div>
        <button onclick="openModal()" class="px-4 py-2 bg-secondary hover:bg-accent text-white font-medium rounded-lg shadow transform transition flex items-center gap-2">
            <i class="ph ph-plus-circle text-xl"></i> Add Partner
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="dataTable">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b w-10"></th>
                    <th class="p-4 border-b">Logo</th>
                    <th class="p-4 border-b">Company Name</th>
                    <th class="p-4 border-b">Location</th>
                    <th class="p-4 border-b">Partnered From</th>
                    <th class="p-4 border-b text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="sortableBody" class="text-slate-700 text-sm">
                <?php foreach($partners as $item): ?>
                <tr class="hover:bg-slate-50 border-b cursor-move" data-id="<?php echo $item['id']; ?>">
                    <td class="p-4 text-slate-400"><i class="ph ph-dots-six-vertical text-xl"></i></td>
                    <td class="p-4">
                        <?php if($item['logo']): ?>
                        <div class="w-16 h-10 object-contain overflow-hidden flex items-center">
                            <img src="/uploads/partners/<?php echo $item['logo']; ?>" class="max-h-full max-w-full">
                        </div>
                        <?php else: ?>
                        <span class="text-slate-400 text-xs">No Logo</span>
                        <?php endif; ?>
                    </td>
                    <td class="p-4 font-semibold text-slate-800"><?php echo htmlspecialchars($item['company_name']); ?></td>
                    <td class="p-4"><?php echo htmlspecialchars($item['company_location']); ?></td>
                    <td class="p-4"><?php echo htmlspecialchars($item['partnered_from']); ?></td>
                    <td class="p-4 flex gap-2 justify-center">
                        <button type="button" onclick='editItem(<?php echo json_encode($item); ?>)' class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition">
                            <i class="ph ph-pencil-simple text-lg"></i>
                        </button>
                        <form action="partners.php" method="POST" onsubmit="return confirm('Delete this partner?');" class="inline">
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
<div id="itemModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl overflow-hidden mt-10 mb-10">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="text-lg font-bold text-slate-800" id="modalTitle">Add Partner</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition">
                <i class="ph ph-x text-xl"></i>
            </button>
        </div>
        <form method="POST" action="partners.php" enctype="multipart/form-data" class="p-6 space-y-4">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" id="item_id">
            
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Company Name</label>
                    <input type="text" name="company_name" id="company_name" required class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Location</label>
                    <input type="text" name="company_location" id="company_location" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Partnered From (Date)</label>
                    <input type="date" name="partnered_from" id="partnered_from" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Logo</label>
                    <input type="file" name="logo" id="logo" accept="image/*" class="w-full text-sm px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Details</label>
                    <textarea name="details" id="details" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t mt-4">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 transition">Cancel</button>
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-secondary text-white hover:bg-accent transition">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    if(document.getElementById('sortableBody')) {
        new Sortable(document.getElementById('sortableBody'), {
            animation: 150,
            ghostClass: 'bg-orange-50',
            onEnd: function (evt) {
                let order = [];
                $('#sortableBody tr').each(function() {
                    order.push($(this).data('id'));
                });
                
                $.post('api/update_position.php', {
                    table: 'partners',
                    order: order
                });
            }
        });
    }

    const modal = document.getElementById('itemModal');
    
    function openModal() {
        document.getElementById('modalTitle').innerText = 'Add Partner';
        document.getElementById('item_id').value = '';
        document.getElementById('company_name').value = '';
        document.getElementById('company_location').value = '';
        document.getElementById('partnered_from').value = '';
        document.getElementById('details').value = '';
        modal.classList.remove('hidden');
    }

    function editItem(data) {
        document.getElementById('modalTitle').innerText = 'Edit Partner';
        document.getElementById('item_id').value = data.id;
        document.getElementById('company_name').value = data.company_name;
        document.getElementById('company_location').value = data.company_location;
        document.getElementById('partnered_from').value = data.partnered_from;
        document.getElementById('details').value = data.details;
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
