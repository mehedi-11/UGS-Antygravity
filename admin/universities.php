<?php
// admin/universities.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_universities')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

require_once __DIR__ . '/components/header.php';

// Handle Delete
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = (int)$_POST['id'];
    $item = $pdo->query("SELECT university_logo, university_banner FROM university WHERE id=$id")->fetch();
    
    if ($item['university_logo'] && file_exists(__DIR__ . '/../uploads/universities/' . $item['university_logo'])) {
        unlink(__DIR__ . '/../uploads/universities/' . $item['university_logo']);
    }
    if ($item['university_banner'] && file_exists(__DIR__ . '/../uploads/universities/' . $item['university_banner'])) {
        unlink(__DIR__ . '/../uploads/universities/' . $item['university_banner']);
    }
    
    $pdo->prepare("DELETE FROM university WHERE id = ?")->execute([$id]);
    set_flash_msg('success', 'University deleted.');
    redirect('universities.php');
}

// Add/Edit Action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'save') {
    $id = $_POST['id'] ?? '';
    $university_name = sanitize($_POST['university_name']);
    $country = sanitize($_POST['country']);
    $location = sanitize($_POST['location']);
    $about_university = $_POST['about_university'];
    $student_facility = $_POST['student_facility'];
    
    $university_logo = '';
    $university_banner = '';

    if (isset($_FILES['university_logo']['name']) && !empty($_FILES['university_logo']['name'])) {
        $uploaded = upload_image($_FILES['university_logo'], 'universities');
        if($uploaded) $university_logo = $uploaded;
    }
    if (isset($_FILES['university_banner']['name']) && !empty($_FILES['university_banner']['name'])) {
        $uploaded = upload_image($_FILES['university_banner'], 'universities');
        if($uploaded) $university_banner = $uploaded;
    }

    if ($id) {
        $old = $pdo->query("SELECT university_logo, university_banner FROM university WHERE id=".(int)$id)->fetch();
        
        if ($university_logo) {
            if ($old['university_logo'] && file_exists(__DIR__ . '/../uploads/universities/' . $old['university_logo'])) {
                unlink(__DIR__ . '/../uploads/universities/' . $old['university_logo']);
            }
        } else { $university_logo = $old['university_logo']; }
        
        if ($university_banner) {
            if ($old['university_banner'] && file_exists(__DIR__ . '/../uploads/universities/' . $old['university_banner'])) {
                unlink(__DIR__ . '/../uploads/universities/' . $old['university_banner']);
            }
        } else { $university_banner = $old['university_banner']; }

        $stmt = $pdo->prepare("UPDATE university SET university_name=?, country=?, location=?, about_university=?, student_facility=?, university_logo=?, university_banner=? WHERE id=?");
        $stmt->execute([$university_name, $country, $location, $about_university, $student_facility, $university_logo, $university_banner, $id]);
        set_flash_msg('success', 'University updated.');
    } else {
        $pos = $pdo->query("SELECT MAX(position) FROM university")->fetchColumn();
        $pos = $pos ? $pos + 1 : 1;

        $stmt = $pdo->prepare("INSERT INTO university (university_name, country, location, about_university, student_facility, university_logo, university_banner, position) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$university_name, $country, $location, $about_university, $student_facility, $university_logo, $university_banner, $pos]);
        set_flash_msg('success', 'University added.');
    }
    redirect('universities.php');
}

$universities = $pdo->query("SELECT * FROM university ORDER BY position ASC")->fetchAll();
$countries = $pdo->query("SELECT country_name FROM country ORDER BY country_name ASC")->fetchAll(PDO::FETCH_COLUMN);

?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Manage Universities</h3>
            <p class="text-slate-500 text-sm">Organize partner universities. Drag and drop to reorder.</p>
        </div>
        <button onclick="openModal()" class="px-4 py-2 bg-secondary hover:bg-accent text-white font-medium rounded-lg shadow transform transition flex items-center gap-2">
            <i class="ph ph-plus-circle text-xl"></i> Add University
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b w-10"></th>
                    <th class="p-4 border-b w-24">Logo</th>
                    <th class="p-4 border-b">University Name</th>
                    <th class="p-4 border-b">Country</th>
                    <th class="p-4 border-b text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="sortableBody" class="text-slate-700 text-sm">
                <?php foreach($universities as $item): ?>
                <tr class="hover:bg-slate-50 border-b cursor-move" data-id="<?php echo $item['id']; ?>">
                    <td class="p-4 text-slate-400"><i class="ph ph-dots-six-vertical text-xl"></i></td>
                    <td class="p-4">
                        <?php if($item['university_logo']): ?>
                        <div class="w-16 h-10 object-contain overflow-hidden flex items-center bg-slate-50 p-1 border rounded">
                            <img src="../uploads/universities/<?php echo $item['university_logo']; ?>" class="max-h-full max-w-full">
                        </div>
                        <?php endif; ?>
                    </td>
                    <td class="p-4 font-semibold text-slate-800"><?php echo htmlspecialchars($item['university_name']); ?></td>
                    <td class="p-4"><span class="px-2 py-1 bg-slate-100 rounded text-xs"><?php echo htmlspecialchars($item['country']); ?></span></td>
                    <td class="p-4 flex gap-2 justify-center">
                        <button type="button" onclick='editItem(<?php echo json_encode($item); ?>)' class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition">
                            <i class="ph ph-pencil-simple text-lg"></i>
                        </button>
                        <form action="universities.php" method="POST" onsubmit="return confirm('Delete this university?');" class="inline">
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
            <h3 class="text-lg font-bold text-slate-800" id="modalTitle">Add University</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition"><i class="ph ph-x text-xl"></i></button>
        </div>
        <div class="overflow-y-auto custom-scrollbar p-6">
            <form method="POST" action="universities.php" enctype="multipart/form-data" class="space-y-4" id="itemForm">
                <input type="hidden" name="action" value="save">
                <input type="hidden" name="id" id="item_id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">University Name</label>
                        <input type="text" name="university_name" id="university_name" required class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Country</label>
                        <select name="country" id="country" required class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                            <option value="">Select Country</option>
                            <?php foreach($countries as $c): ?>
                                <option value="<?php echo $c; ?>"><?php echo $c; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Location Details</label>
                        <input type="text" name="location" id="location" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none placeholder:text-slate-300" placeholder="e.g. London, UK">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border p-4 rounded-xl">
                        <label class="block text-sm font-medium text-slate-700 mb-1">University Logo</label>
                        <input type="file" name="university_logo" id="university_logo" accept="image/*" class="w-full px-3 py-2 border rounded-lg text-sm bg-white">
                    </div>
                    <div class="border p-4 rounded-xl">
                        <label class="block text-sm font-medium text-slate-700 mb-1">University Banner</label>
                        <input type="file" name="university_banner" id="university_banner" accept="image/*" class="w-full px-3 py-2 border rounded-lg text-sm bg-white">
                    </div>
                </div>

                <div class="space-y-4 pt-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">About University</label>
                        <textarea name="about_university" id="about_university" rows="4" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Student Facilities</label>
                        <textarea name="student_facility" id="student_facility" rows="4" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 transition">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-secondary text-white hover:bg-accent transition">Save University</button>
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
                $.post('api/update_position.php', { table: 'university', order: order });
            }
        });
    }

    const modal = document.getElementById('itemModal');

    function openModal() {
        document.getElementById('itemForm').reset();
        document.getElementById('modalTitle').innerText = 'Add University';
        document.getElementById('item_id').value = '';
        modal.classList.remove('hidden');
    }
    function editItem(data) {
        document.getElementById('itemForm').reset();
        document.getElementById('modalTitle').innerText = 'Edit University';
        document.getElementById('item_id').value = data.id;
        document.getElementById('university_name').value = data.university_name;
        document.getElementById('country').value = data.country;
        document.getElementById('location').value = data.location;
        document.getElementById('about_university').value = data.about_university;
        document.getElementById('student_facility').value = data.student_facility;
        modal.classList.remove('hidden');
    }
    function closeModal() { modal.classList.add('hidden'); }
</script>
<?php require_once __DIR__ . '/components/footer.php'; ?>
