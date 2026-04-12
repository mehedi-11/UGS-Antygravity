<?php
// admin/admins.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_admins')) {
    set_flash_msg('error', 'You do not have permission to view this page.');
    redirect('dashboard.php');
}

require_once __DIR__ . '/components/header.php';

// Handle Add / Edit Admin
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = (int)$_POST['id'];
        
        // Check if current user is Super Admin (has 'all' permission)
        if (!in_array('all', $_SESSION['admin_permissions'])) {
            set_flash_msg('error', 'Only Super Admins can delete other administrators.');
        } elseif ($id == $_SESSION['admin_id']) {
            set_flash_msg('error', 'Cannot delete yourself!');
        } else {
            $pdo->prepare("DELETE FROM admin WHERE id = ?")->execute([$id]);
            set_flash_msg('success', 'Admin deleted successfully.');
        }
    } else {
        $id = $_POST['admin_id'] ?? '';
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $phone = sanitize($_POST['phone']);
        $username = sanitize($_POST['username']);
        $permissions = isset($_POST['permissions']) ? json_encode($_POST['permissions']) : json_encode([]);
        
        if ($id) {
            // Update
            $password = $_POST['password'];
            if (!empty($password)) {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE admin SET name=?, email=?, phone=?, username=?, password=?, permissions=? WHERE id=?");
                $stmt->execute([$name, $email, $phone, $username, $hashed, $permissions, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE admin SET name=?, email=?, phone=?, username=?, permissions=? WHERE id=?");
                $stmt->execute([$name, $email, $phone, $username, $permissions, $id]);
            }
            set_flash_msg('success', 'Admin updated successfully.');
        } else {
            // Insert
            $password = $_POST['password'];
            if(empty($password)) $password = 'password123'; // fallback
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO admin (name, email, phone, username, password, permissions) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $username, $hashed, $permissions]);
            set_flash_msg('success', 'Admin created successfully.');
        }
    }
    redirect('admins.php');
}

$admins = $pdo->query("SELECT * FROM admin")->fetchAll();

$available_permissions = [
    'all' => 'Super Admin (All Access)',
    'manage_profile' => 'Manage Profile',
    'manage_admins' => 'Manage Admins',
    'manage_hero' => 'Manage Hero',
    'manage_about' => 'Manage About',
    'manage_services' => 'Manage Services',
    'manage_working_process' => 'Manage Working Process',
    'manage_countries' => 'Manage Countries',
    'manage_universities' => 'Manage Universities',
    'manage_team' => 'Manage Team',
    'manage_partners' => 'Manage Partners',
    'manage_gallery' => 'Manage Gallery',
    'manage_blogs' => 'Manage Blogs',
    'manage_events' => 'Manage Events',
    'manage_achievements' => 'Manage Achievements',
    'manage_testimonials' => 'Manage Testimonials',
    'manage_social_media' => 'Manage Social Media',
    'manage_appointments' => 'Manage Appointments',
    'manage_chatbot' => 'Manage Chatbot',
    'manage_subscribers' => 'Manage Subscribers',
    'manage_contacts' => 'Manage Contact Messages',
];
?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Manage Admins</h3>
            <p class="text-slate-500 text-sm">Add, edit, or delete administrators and their roles</p>
        </div>
        <button onclick="openModal()" class="px-4 py-2 bg-secondary hover:bg-accent text-white font-medium rounded-lg shadow transform transition flex items-center gap-2">
            <i class="ph ph-plus-circle text-xl"></i> Add Admin
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse datatable">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b font-medium">Name</th>
                    <th class="p-4 border-b font-medium">Username</th>
                    <th class="p-4 border-b font-medium">Email</th>
                    <th class="p-4 border-b font-medium text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-slate-700 text-sm">
                <?php foreach($admins as $adm): ?>
                <tr class="hover:bg-slate-50 border-b last:border-0">
                    <td class="p-4 font-semibold text-slate-800"><?php echo htmlspecialchars($adm['name']); ?></td>
                    <td class="p-4"><?php echo htmlspecialchars($adm['username']); ?></td>
                    <td class="p-4"><?php echo htmlspecialchars($adm['email']); ?></td>
                    <td class="p-4 flex gap-2 justify-center">
                        <button onclick='editAdmin(<?php echo json_encode($adm); ?>)' class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition">
                            <i class="ph ph-pencil-simple text-lg"></i>
                        </button>
                        <?php if($adm['id'] != $_SESSION['admin_id'] && in_array('all', $_SESSION['admin_permissions'])): ?>
                        <form action="admins.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this admin?');" class="inline">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $adm['id']; ?>">
                            <button type="submit" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-200 transition">
                                <i class="ph ph-trash text-lg"></i>
                            </button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="adminModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden mt-10 mb-10">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="text-lg font-bold text-slate-800" id="modalTitle">Add New Admin</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition">
                <i class="ph ph-x text-xl"></i>
            </button>
        </div>
        <form method="POST" action="admins.php" class="p-6">
            <input type="hidden" name="admin_id" id="admin_id">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                    <input type="text" name="name" id="name" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                    <input type="text" name="username" id="username" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Phone</label>
                    <input type="text" name="phone" id="phone" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-secondary focus:outline-none">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-secondary focus:outline-none" placeholder="Leave blank to keep unchanged (for edit)">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-800 mb-2 border-b pb-1">Permissions</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mt-2 h-40 overflow-y-auto custom-scrollbar p-2 border rounded-lg bg-slate-50">
                    <?php foreach($available_permissions as $key => $label): ?>
                    <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer p-1 hover:bg-slate-200 rounded">
                        <input type="checkbox" name="permissions[]" value="<?php echo $key; ?>" class="perm-checkbox rounded text-secondary focus:ring-secondary">
                        <span class="truncate"><?php echo $label; ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 font-medium transition">Cancel</button>
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-secondary text-white font-medium hover:bg-accent transition shadow-md shadow-orange-500/20">Save Admin</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('adminModal');
    
    function openModal() {
        document.getElementById('modalTitle').innerText = 'Add New Admin';
        document.getElementById('admin_id').value = '';
        document.getElementById('name').value = '';
        document.getElementById('username').value = '';
        document.getElementById('email').value = '';
        document.getElementById('phone').value = '';
        document.getElementById('password').required = true;
        document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = false);
        modal.classList.remove('hidden');
    }

    function editAdmin(admin) {
        document.getElementById('modalTitle').innerText = 'Edit Admin';
        document.getElementById('admin_id').value = admin.id;
        document.getElementById('name').value = admin.name;
        document.getElementById('username').value = admin.username;
        document.getElementById('email').value = admin.email;
        document.getElementById('phone').value = admin.phone;
        document.getElementById('password').required = false;
        
        let perms = [];
        try { perms = JSON.parse(admin.permissions) || []; } catch(e){}
        
        document.querySelectorAll('.perm-checkbox').forEach(cb => {
            cb.checked = perms.includes(cb.value);
        });
        
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
