<?php
// admin/about.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_about')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

require_once __DIR__ . '/components/header.php';

// Fetch existing about data (assuming single row with id = 1)
$about = $pdo->query("SELECT * FROM about LIMIT 1")->fetch();

if (!$about) {
    // Insert empty row if not exists
    $pdo->exec("INSERT INTO about (id, company_name) VALUES (1, 'Unilink Global Solution')");
    $about = $pdo->query("SELECT * FROM about LIMIT 1")->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company_name = sanitize($_POST['company_name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $whatsapp = sanitize($_POST['whatsapp']);
    $address = sanitize($_POST['address']);
    $about_company = $_POST['about_company']; // Rich text potentially
    $mission = $_POST['mission'];
    $vision = $_POST['vision'];
    
    // Stats
    $country = (int)$_POST['country'];
    $university = (int)$_POST['university'];
    $student = (int)$_POST['student'];
    $happy_smile = (int)$_POST['happy_smile'];
    
    $logo = $about['logo'];
    $favicon = $about['favicon'];
    
    // File uploads
    if (isset($_FILES['logo']['name']) && !empty($_FILES['logo']['name'])) {
        $uploaded = upload_image($_FILES['logo'], 'about');
        if ($uploaded) {
            // Delete old if exists
            if ($logo && file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/about/' . $logo)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/about/' . $logo);
            }
            $logo = $uploaded;
        }
    }
    
    if (isset($_FILES['favicon']['name']) && !empty($_FILES['favicon']['name'])) {
        $uploaded = upload_image($_FILES['favicon'], 'about');
        if ($uploaded) {
            if ($favicon && file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/about/' . $favicon)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/about/' . $favicon);
            }
            $favicon = $uploaded;
        }
    }

    try {
        $stmt = $pdo->prepare("UPDATE about SET 
            company_name=?, email=?, phone=?, whatsapp=?, address=?, 
            about_company=?, mission=?, vision=?, country=?, university=?, 
            student=?, happy_smile=?, logo=?, favicon=? WHERE id=1");
        
        $stmt->execute([
            $company_name, $email, $phone, $whatsapp, $address,
            $about_company, $mission, $vision, $country, $university,
            $student, $happy_smile, $logo, $favicon
        ]);
        
        set_flash_msg('success', 'About information updated successfully.');
        redirect('about.php');
    } catch(PDOException $e) {
        set_flash_msg('error', 'Update Failed: ' . $e->getMessage());
    }
}
?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="mb-6 pb-4 border-b">
        <h3 class="text-xl font-bold text-slate-800">Manage About Information</h3>
        <p class="text-slate-500 text-sm">Update company description, contact info, and site logo</p>
    </div>

    <form method="POST" action="about.php" enctype="multipart/form-data" class="space-y-8">
        
        <!-- General Info -->
        <div>
            <h4 class="text-lg font-semibold text-slate-700 mb-4 flex items-center gap-2"><i class="ph ph-buildings"></i> Company Details</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Company Name</label>
                    <input type="text" name="company_name" id="company_name" value="<?php echo htmlspecialchars($about['company_name'] ?? ''); ?>" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($about['email'] ?? ''); ?>" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" value="<?php echo htmlspecialchars($about['phone'] ?? ''); ?>" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">WhatsApp Number</label>
                    <input type="text" name="whatsapp" value="<?php echo htmlspecialchars($about['whatsapp'] ?? ''); ?>" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Address</label>
                    <textarea name="address" rows="2" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none"><?php echo htmlspecialchars($about['address'] ?? ''); ?></textarea>
                </div>
            </div>
        </div>

        <!-- Descriptions -->
        <div>
            <h4 class="text-lg font-semibold text-slate-700 mb-4 flex items-center gap-2"><i class="ph ph-article"></i> Descriptions</h4>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">About Company</label>
                    <textarea name="about_company" id="about_company" rows="4" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none"><?php echo htmlspecialchars($about['about_company'] ?? ''); ?></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Mission</label>
                        <textarea name="mission" id="mission" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none"><?php echo htmlspecialchars($about['mission'] ?? ''); ?></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Vision</label>
                        <textarea name="vision" id="vision" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none"><?php echo htmlspecialchars($about['vision'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Site Stats -->
        <div>
            <h4 class="text-lg font-semibold text-slate-700 mb-4 flex items-center gap-2"><i class="ph ph-chart-line-up"></i> Counter Stats</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Countries</label>
                    <input type="number" name="country" value="<?php echo htmlspecialchars($about['country'] ?? '0'); ?>" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Universities</label>
                    <input type="number" name="university" value="<?php echo htmlspecialchars($about['university'] ?? '0'); ?>" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Students</label>
                    <input type="number" name="student" value="<?php echo htmlspecialchars($about['student'] ?? '0'); ?>" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Happy Smiles (Reviews)</label>
                    <input type="number" name="happy_smile" value="<?php echo htmlspecialchars($about['happy_smile'] ?? '0'); ?>" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>
            </div>
        </div>

        <!-- Media -->
        <div>
            <h4 class="text-lg font-semibold text-slate-700 mb-4 flex items-center gap-2"><i class="ph ph-image"></i> Logos & Media</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="border p-4 rounded-xl">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Main Logo</label>
                    <?php if(!empty($about['logo'])): ?>
                        <div class="mb-3 p-2 bg-slate-100 rounded inline-block">
                            <img src="/uploads/about/<?php echo $about['logo']; ?>" alt="Logo" class="h-12 object-contain">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="logo" accept="image/*" class="w-full text-sm">
                </div>
                
                <div class="border p-4 rounded-xl">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Favicon</label>
                    <?php if(!empty($about['favicon'])): ?>
                        <div class="mb-3 p-2 bg-slate-100 rounded inline-block">
                            <img src="/uploads/about/<?php echo $about['favicon']; ?>" alt="Favicon" class="h-8 object-contain">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="favicon" accept="image/*" class="w-full text-sm">
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4 border-t">
            <button type="submit" class="px-6 py-3 bg-secondary hover:bg-accent text-white font-medium rounded-xl shadow-lg shadow-orange-500/30 transition">
                Save About Information
            </button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/components/footer.php'; ?>
