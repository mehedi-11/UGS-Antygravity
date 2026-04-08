<?php
// admin/countries.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_countries')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

require_once __DIR__ . '/components/header.php';

// Delete Action
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = (int)$_POST['id'];
    $item = $pdo->query("SELECT country_image, banner_image FROM country WHERE id=$id")->fetch();
    
    if ($item['country_image'] && file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/countries/' . $item['country_image'])) {
        unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/countries/' . $item['country_image']);
    }
    if ($item['banner_image'] && file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/countries/' . $item['banner_image'])) {
        unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/countries/' . $item['banner_image']);
    }
    
    $pdo->prepare("DELETE FROM country WHERE id = ?")->execute([$id]);
    set_flash_msg('success', 'Country deleted.');
    redirect('countries.php');
}

// Add/Edit Action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'save') {
    $id = $_POST['id'] ?? '';
    $country_name = sanitize($_POST['country_name']);
    $about_country = $_POST['about_country'];
    $study_opportunity = $_POST['study_opportunity'];
    $admission_requirements = $_POST['admission_requirements'];
    $lifestyle_culture = $_POST['lifestyle_culture'];
    
    $country_image = '';
    $banner_image = '';

    if (isset($_FILES['country_image']['name']) && !empty($_FILES['country_image']['name'])) {
        $uploaded = upload_image($_FILES['country_image'], 'countries');
        if($uploaded) $country_image = $uploaded;
    }
    if (isset($_FILES['banner_image']['name']) && !empty($_FILES['banner_image']['name'])) {
        $uploaded = upload_image($_FILES['banner_image'], 'countries');
        if($uploaded) $banner_image = $uploaded;
    }

    if ($id) {
        $old = $pdo->query("SELECT country_image, banner_image FROM country WHERE id=".(int)$id)->fetch();
        
        if ($country_image) {
            if ($old['country_image'] && file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/countries/' . $old['country_image'])) {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/countries/' . $old['country_image']);
            }
        } else {
            $country_image = $old['country_image'];
        }
        
        if ($banner_image) {
            if ($old['banner_image'] && file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/countries/' . $old['banner_image'])) {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/countries/' . $old['banner_image']);
            }
        } else {
            $banner_image = $old['banner_image'];
        }

        $stmt = $pdo->prepare("UPDATE country SET country_name=?, about_country=?, study_opportunity=?, admission_requirements=?, lifestyle_culture=?, country_image=?, banner_image=? WHERE id=?");
        $stmt->execute([$country_name, $about_country, $study_opportunity, $admission_requirements, $lifestyle_culture, $country_image, $banner_image, $id]);
        set_flash_msg('success', 'Country updated.');
    } else {
        $pos = $pdo->query("SELECT MAX(position) FROM country")->fetchColumn();
        $pos = $pos ? $pos + 1 : 1;

        $stmt = $pdo->prepare("INSERT INTO country (country_name, about_country, study_opportunity, admission_requirements, lifestyle_culture, country_image, banner_image, position) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$country_name, $about_country, $study_opportunity, $admission_requirements, $lifestyle_culture, $country_image, $banner_image, $pos]);
        set_flash_msg('success', 'Country added.');
    }
    redirect('countries.php');
}

$countries = $pdo->query("SELECT * FROM country ORDER BY position ASC")->fetchAll();
?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Manage Countries</h3>
            <p class="text-slate-500 text-sm">Drag and drop to reorder destination countries.</p>
        </div>
        <button onclick="openModal()" class="px-4 py-2 bg-secondary hover:bg-accent text-white font-medium rounded-lg shadow transform transition flex items-center gap-2">
            <i class="ph ph-plus-circle text-xl"></i> Add Country
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b w-10"></th>
                    <th class="p-4 border-b w-24">Image</th>
                    <th class="p-4 border-b">Country Name</th>
                    <th class="p-4 border-b text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="sortableBody" class="text-slate-700 text-sm">
                <?php foreach($countries as $item): ?>
                <tr class="hover:bg-slate-50 border-b cursor-move" data-id="<?php echo $item['id']; ?>">
                    <td class="p-4 text-slate-400"><i class="ph ph-dots-six-vertical text-xl"></i></td>
                    <td class="p-4">
                        <?php if($item['country_image']): ?>
                        <div class="w-16 h-10 object-cover overflow-hidden rounded border">
                            <img src="/uploads/countries/<?php echo $item['country_image']; ?>" class="w-full h-full object-cover">
                        </div>
                        <?php endif; ?>
                    </td>
                    <td class="p-4 font-semibold text-slate-800"><?php echo htmlspecialchars($item['country_name']); ?></td>
                    <td class="p-4 flex gap-2 justify-center">
                        <button type="button" onclick='editItem(<?php echo json_encode($item); ?>)' class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition">
                            <i class="ph ph-pencil-simple text-lg"></i>
                        </button>
                        <form action="countries.php" method="POST" onsubmit="return confirm('Delete this country?');" class="inline">
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
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl overflow-hidden my-4 max-h-[90vh] flex flex-col">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50 shrink-0">
            <h3 class="text-lg font-bold text-slate-800" id="modalTitle">Add Country</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition"><i class="ph ph-x text-xl"></i></button>
        </div>
        <div class="overflow-y-auto custom-scrollbar p-6">
            <form method="POST" action="countries.php" enctype="multipart/form-data" class="space-y-4" id="countryForm">
                <input type="hidden" name="action" value="save">
                <input type="hidden" name="id" id="item_id">
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Country Name</label>
                    <input type="text" name="country_name" id="country_name" required class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border p-4 rounded-xl relative">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Country Image (Main)</label>
                        <input type="file" name="country_image" id="country_image" accept="image/*" class="w-full px-3 py-2 border rounded-lg text-sm bg-white">
                    </div>
                    <div class="border p-4 rounded-xl relative">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Banner Image (Details Page)</label>
                        <input type="file" name="banner_image" id="banner_image" accept="image/*" class="w-full px-3 py-2 border rounded-lg text-sm bg-white">
                    </div>
                </div>

                <div class="space-y-4 pt-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">About Country</label>
                        <textarea name="about_country" id="about_country" rows="4" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Study Opportunity</label>
                        <textarea name="study_opportunity" id="study_opportunity" rows="4" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Admission Requirements</label>
                        <textarea name="admission_requirements" id="admission_requirements" rows="4" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Lifestyle & Culture</label>
                        <textarea name="lifestyle_culture" id="lifestyle_culture" rows="4" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 transition">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-secondary text-white hover:bg-accent transition">Save Country</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    if(document.getElementById('sortableBody')) {
        new Sortable(document.getElementById('sortableBody'), {
            animation: 150, ghostClass: 'bg-orange-50',
            onEnd: function (evt) {
                let order = [];
                $('#sortableBody tr').each(function() { order.push($(this).data('id')); });
                $.post('api/update_position.php', { table: 'country', order: order });
            }
        });
    }

    const modal = document.getElementById('itemModal');
    function openModal() {
        document.getElementById('countryForm').reset();
        document.getElementById('modalTitle').innerText = 'Add Country';
        document.getElementById('item_id').value = '';
        modal.classList.remove('hidden');
    }
    function editItem(data) {
        document.getElementById('countryForm').reset();
        document.getElementById('modalTitle').innerText = 'Edit Country';
        document.getElementById('item_id').value = data.id;
        document.getElementById('country_name').value = data.country_name;
        document.getElementById('about_country').value = data.about_country;
        document.getElementById('study_opportunity').value = data.study_opportunity;
        document.getElementById('admission_requirements').value = data.admission_requirements;
        document.getElementById('lifestyle_culture').value = data.lifestyle_culture;
        modal.classList.remove('hidden');
    }
    function closeModal() { modal.classList.add('hidden'); }
</script>
<?php require_once __DIR__ . '/components/footer.php'; ?>
