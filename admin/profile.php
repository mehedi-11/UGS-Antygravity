<?php
// admin/profile.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_profile')) {
    set_flash_msg('error', 'You do not have permission to view this page.');
    redirect('dashboard.php');
}

require_once __DIR__ . '/components/header.php';

$admin_id = $_SESSION['admin_id'];

// Handle Update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $username = sanitize($_POST['username']);
    $password = $_POST['password']; // optional

    try {
        if (!empty($password)) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE admin SET name=?, email=?, phone=?, username=?, password=? WHERE id=?");
            $stmt->execute([$name, $email, $phone, $username, $hashed, $admin_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE admin SET name=?, email=?, phone=?, username=? WHERE id=?");
            $stmt->execute([$name, $email, $phone, $username, $admin_id]);
        }
        
        // Update session
        $_SESSION['admin_name'] = $name;
        $_SESSION['admin_username'] = $username;
        
        set_flash_msg('success', 'Profile updated successfully.');
        redirect('profile.php');
    } catch(PDOException $e) {
        set_flash_msg('error', 'Update failed: ' . $e->getMessage());
    }
}

// Fetch current
$stmt = $pdo->prepare("SELECT * FROM admin WHERE id=?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch();
?>

<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
        <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center text-secondary text-3xl">
            <i class="ph-fill ph-user-gear"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">Manage Profile</h3>
            <p class="text-slate-500 text-sm">Update your personal information and password</p>
        </div>
    </div>

    <form method="POST" action="profile.php" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Full Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-secondary bg-slate-50">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-secondary bg-slate-50">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-secondary bg-slate-50">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Phone Number</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($admin['phone']); ?>" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-secondary bg-slate-50">
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100">
            <h4 class="text-md font-semibold text-slate-800 mb-4">Change Password</h4>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">New Password <span class="text-slate-400 text-xs font-normal">(Leave blank if unchanged)</span></label>
                <input type="password" name="password" class="w-full md:w-1/2 px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-secondary bg-slate-50">
            </div>
        </div>

        <div class="pt-6 flex justify-end">
            <button type="submit" class="px-6 py-3 bg-secondary hover:bg-accent text-white font-medium rounded-xl shadow-lg shadow-orange-500/30 transform transition hover:-translate-y-0.5">
                Save Changes
            </button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/components/footer.php'; ?>
