<?php
// admin/team.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_team')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

require_once __DIR__ . '/components/header.php';

// Handle Delete
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = (int)$_POST['id'];
    $team = $pdo->query("SELECT profile_image FROM team WHERE id=$id")->fetch();
    if ($team && $team['profile_image'] && file_exists(__DIR__ . '/../uploads/team/' . $team['profile_image'])) {
        unlink(__DIR__ . '/../uploads/team/' . $team['profile_image']);
    }
    $pdo->prepare("DELETE FROM team WHERE id = ?")->execute([$id]);
    set_flash_msg('success', 'Member deleted.');
    redirect('team.php');
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'save') {
    $id = $_POST['id'] ?? '';
    $name = sanitize($_POST['name']);
    $team_name = sanitize($_POST['team_name']);
    $designation = sanitize($_POST['designation']);
    $say = sanitize($_POST['say']);
    $joining_date = $_POST['joining_date'];
    $blood_group = sanitize($_POST['blood_group']);
    $certified_by = sanitize($_POST['certified_by']);
    $profile_image = '';

    if (isset($_FILES['profile_image']['name']) && !empty($_FILES['profile_image']['name'])) {
        $uploaded = upload_image($_FILES['profile_image'], 'team');
        if ($uploaded) {
            $profile_image = $uploaded;
        }
    }

    if ($id) {
        $old = $pdo->query("SELECT profile_image FROM team WHERE id=".(int)$id)->fetch();
        if ($profile_image) {
            if ($old && $old['profile_image'] && file_exists(__DIR__ . '/../uploads/team/' . $old['profile_image'])) {
                unlink(__DIR__ . '/../uploads/team/' . $old['profile_image']);
            }
        } else {
            $profile_image = $old['profile_image'] ?? '';
        }

        $stmt = $pdo->prepare("UPDATE team SET name=?, team_name=?, designation=?, say=?, joining_date=?, blood_group=?, certified_by=?, profile_image=? WHERE id=?");
        $stmt->execute([$name, $team_name, $designation, $say, $joining_date, $blood_group, $certified_by, $profile_image, $id]);
        set_flash_msg('success', 'Member updated.');
    } else {
        $pos = $pdo->query("SELECT MAX(position) FROM team")->fetchColumn();
        $pos = $pos ? $pos + 1 : 1;

        $stmt = $pdo->prepare("INSERT INTO team (name, team_name, designation, say, joining_date, blood_group, certified_by, profile_image, position) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $team_name, $designation, $say, $joining_date, $blood_group, $certified_by, $profile_image, $pos]);
        set_flash_msg('success', 'Member added.');
    }
    redirect('team.php');
}

$team_members = $pdo->query("SELECT * FROM team ORDER BY position ASC")->fetchAll();
?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Manage Team</h3>
            <p class="text-slate-500 text-sm">Drag and drop rows to reorder positions.</p>
        </div>
        <button onclick="openModal()" class="px-4 py-2 bg-secondary hover:bg-accent text-white font-medium rounded-lg shadow transform transition flex items-center gap-2">
            <i class="ph ph-plus-circle text-xl"></i> Add Member
        </button>
    </div>

    <div class="overflow-x-auto">
        <!-- datatable class removed to allow sortablejs complete control without pagination interfering with drag-drop -->
        <table class="w-full text-left border-collapse" id="teamTable">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b w-10"></th>
                    <th class="p-4 border-b">Image</th>
                    <th class="p-4 border-b">Name</th>
                    <th class="p-4 border-b">Designation</th>
                    <th class="p-4 border-b">Team</th>
                    <th class="p-4 border-b text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="sortableBody" class="text-slate-700 text-sm">
                <?php foreach($team_members as $member): ?>
                <tr class="hover:bg-slate-50 border-b cursor-move" data-id="<?php echo $member['id']; ?>">
                    <td class="p-4 text-slate-400"><i class="ph ph-dots-six-vertical text-xl"></i></td>
                    <td class="p-4">
                        <?php if($member['profile_image']): ?>
                        <div class="w-12 h-12 rounded-full overflow-hidden border">
                            <img src="../uploads/team/<?php echo $member['profile_image']; ?>" class="w-full h-full object-cover">
                        </div>
                        <?php else: ?>
                        <div class="w-12 h-12 rounded-full bg-slate-200 flex items-center justify-center">
                            <i class="ph ph-user text-xl text-slate-400"></i>
                        </div>
                        <?php endif; ?>
                    </td>
                    <td class="p-4 font-semibold text-slate-800"><?php echo htmlspecialchars($member['name']); ?></td>
                    <td class="p-4"><?php echo htmlspecialchars($member['designation']); ?></td>
                    <td class="p-4"><?php echo htmlspecialchars($member['team_name']); ?></td>
                    <td class="p-4 flex gap-2 justify-center">
                        <button type="button" onclick='editMember(<?php echo json_encode($member); ?>)' class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition">
                            <i class="ph ph-pencil-simple text-lg"></i>
                        </button>
                        <form action="team.php" method="POST" onsubmit="return confirm('Delete this member?');" class="inline">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
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

<!-- Add/Edit Modal -->
<div id="itemModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden mt-10 mb-10">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="text-lg font-bold text-slate-800" id="modalTitle">Add Team Member</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition">
                <i class="ph ph-x text-xl"></i>
            </button>
        </div>
        <form method="POST" action="team.php" enctype="multipart/form-data" class="p-6 space-y-4">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" id="item_id">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" required class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Designation</label>
                    <input type="text" name="designation" id="designation" required class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Team Name / Category</label>
                    <input type="text" name="team_name" id="team_name" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Profile Image</label>
                    <input type="file" name="profile_image" id="profile_image" accept="image/*" class="w-full text-sm px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Joining Date</label>
                    <input type="date" name="joining_date" id="joining_date" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Blood Group</label>
                    <input type="text" name="blood_group" id="blood_group" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Certified By</label>
                    <input type="text" name="certified_by" id="certified_by" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Short Quote / Say</label>
                <textarea name="say" id="say" rows="2" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t mt-4">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 transition">Cancel</button>
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-secondary text-white hover:bg-accent transition">Save Member</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Sortable initialization
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
                    table: 'team',
                    order: order
                }, function(res) {
                    if(res.status === 'success') {
                        // Success Toast
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Positions updated successfully'
                        });
                    } else {
                        Swal.fire('Error', 'Could not update position: ' + res.message, 'error');
                    }
                });
            }
        });
    }

    const modal = document.getElementById('itemModal');
    
    function openModal() {
        document.getElementById('modalTitle').innerText = 'Add Team Member';
        document.getElementById('item_id').value = '';
        document.getElementById('name').value = '';
        document.getElementById('team_name').value = '';
        document.getElementById('designation').value = '';
        document.getElementById('say').value = '';
        document.getElementById('joining_date').value = '';
        document.getElementById('blood_group').value = '';
        document.getElementById('certified_by').value = '';
        modal.classList.remove('hidden');
    }

    function editMember(data) {
        document.getElementById('modalTitle').innerText = 'Edit Team Member';
        document.getElementById('item_id').value = data.id;
        document.getElementById('name').value = data.name;
        document.getElementById('team_name').value = data.team_name;
        document.getElementById('designation').value = data.designation;
        document.getElementById('say').value = data.say;
        document.getElementById('joining_date').value = data.joining_date;
        document.getElementById('blood_group').value = data.blood_group;
        document.getElementById('certified_by').value = data.certified_by;
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
