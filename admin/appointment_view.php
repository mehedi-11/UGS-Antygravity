<?php
// admin/appointment_view.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_appointments')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    redirect('appointments.php');
}

// Fetch appointment
$stmt = $pdo->prepare("SELECT * FROM appointment WHERE id = ?");
$stmt->execute([$id]);
$appointment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$appointment) {
    set_flash_msg('error', 'Appointment not found.');
    redirect('appointments.php');
}

// Fetch about info for header
$about = [];
try {
    $about = $pdo->query("SELECT * FROM about LIMIT 1")->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

$company_name = $about['company_name'] ?? 'Unilink Global Solution';
$phone = $about['phone'] ?? '+880 1234 567890';
$email = $about['email'] ?? 'info@unilinkgs.com';
$address = $about['address'] ?? '123 Education Street, Dhaka, Bangladesh';
$logo = isset($about['logo']) && !empty($about['logo']) ? '../uploads/about/' . $about['logo'] : '../assets/images/logo-placeholder.png';
$website = "www.unilinkgs.com"; // Requested explicitly by user

// Do not require standard header/footer layout to keep print clean, but we can include Tailwind.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Detail - <?php echo htmlspecialchars($appointment['name']); ?></title>
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Tailwind CSS (via CDN for print/standalone) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #f1f5f9; }
        @media print {
            body { background-color: white; }
            .no-print { display: none !important; }
            .print-container { box-shadow: none !important; margin: 0 !important; width: 100% !important; max-width: 100% !important; padding: 0 !important; }
        }
    </style>
</head>
<body class="p-8 font-sans text-slate-800">

    <div class="max-w-4xl mx-auto mb-6 flex justify-between items-center no-print">
        <a href="appointments.php" class="text-slate-500 hover:text-slate-800 font-bold flex items-center gap-2 transition">
            <i class="ph ph-arrow-left text-xl"></i> Back to Appointments
        </a>
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold shadow transition flex items-center gap-2">
            <i class="ph ph-printer text-xl"></i> Print Format
        </button>
    </div>

    <div class="bg-white p-10 print-container mx-auto max-w-4xl shadow-xl rounded-2xl border border-slate-200">
        
        <!-- Company Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b-2 border-slate-200 pb-8 mb-8">
            <div class="mb-6 md:mb-0">
                <img src="<?php echo htmlspecialchars($logo); ?>" alt="Company Logo" class="h-16 object-contain mb-4">
                <h1 class="text-2xl font-black text-slate-800 uppercase tracking-wider"><?php echo htmlspecialchars($company_name); ?></h1>
                <p class="text-sm text-slate-500 italic max-w-xs mt-1"><?php echo nl2br(htmlspecialchars($address)); ?></p>
            </div>
            
            <div class="text-left md:text-right text-sm text-slate-600 space-y-1">
                <p class="flex items-center md:justify-end gap-2"><i class="ph ph-phone"></i> <strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
                <p class="flex items-center md:justify-end gap-2"><i class="ph ph-envelope"></i> <strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p class="flex items-center md:justify-end gap-2"><i class="ph ph-globe"></i> <strong>Web:</strong> <?php echo htmlspecialchars($website); ?></p>
            </div>
        </div>

        <div class="mb-8 text-center text-slate-600">
            <h2 class="text-3xl font-black text-slate-800 uppercase mb-2">Consultation Booking</h2>
            <p>Submitted on: <strong><?php echo date('F d, Y - h:i A', strtotime($appointment['created_at'])); ?></strong></p>
        </div>

        <!-- Appointment Data Blocks -->
        <div class="space-y-8">
            
            <!-- Block 1: Contact -->
            <div>
                <h3 class="bg-slate-100 text-slate-700 px-4 py-2 uppercase font-bold text-sm tracking-wider mb-4 border-l-4 border-slate-400">1. Applicant Details</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8 px-4 text-sm">
                    <div><span class="block text-slate-400 uppercase text-xs font-bold">Full Name</span><span class="font-semibold text-lg"><?php echo htmlspecialchars($appointment['name'] ?? 'N/A'); ?></span></div>
                    <div><span class="block text-slate-400 uppercase text-xs font-bold">Phone Number</span><span class="font-semibold text-lg"><?php echo htmlspecialchars($appointment['phone'] ?? 'N/A'); ?></span></div>
                    <div><span class="block text-slate-400 uppercase text-xs font-bold">Email Address</span><span class="font-semibold"><?php echo htmlspecialchars($appointment['email'] ?? 'N/A'); ?></span></div>
                    <div><span class="block text-slate-400 uppercase text-xs font-bold">Complete Address</span><span class="font-semibold"><?php echo htmlspecialchars($appointment['address'] ?? 'N/A'); ?></span></div>
                </div>
            </div>

            <!-- Block 2: Academic Background -->
            <div>
                <h3 class="bg-slate-100 text-slate-700 px-4 py-2 uppercase font-bold text-sm tracking-wider mb-4 border-l-4 border-slate-400">2. Academic Background</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8 px-4 text-sm">
                    <div><span class="block text-slate-400 uppercase text-xs font-bold">Last Education</span><span class="font-semibold"><?php echo htmlspecialchars($appointment['last_academic_education'] ?? 'N/A'); ?></span></div>
                    <div><span class="block text-slate-400 uppercase text-xs font-bold">Passing Year</span><span class="font-semibold"><?php echo htmlspecialchars($appointment['passing_year'] ?? 'N/A'); ?></span></div>
                    <div><span class="block text-slate-400 uppercase text-xs font-bold">Department/Subject</span><span class="font-semibold"><?php echo htmlspecialchars($appointment['department'] ?? 'N/A'); ?></span></div>
                    <div><span class="block text-slate-400 uppercase text-xs font-bold">Institution Name</span><span class="font-semibold"><?php echo htmlspecialchars($appointment['institution_name'] ?? 'N/A'); ?></span></div>
                </div>
            </div>

            <!-- Block 3: Language Proficiency -->
            <div>
                <h3 class="bg-slate-100 text-slate-700 px-4 py-2 uppercase font-bold text-sm tracking-wider mb-4 border-l-4 border-slate-400">3. Language Proficiency</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-y-4 gap-x-8 px-4 text-sm">
                    <div><span class="block text-slate-400 uppercase text-xs font-bold">Test Taken?</span><span class="font-bold <?php echo strtolower($appointment['english_test'] ?? '') === 'yes' ? 'text-green-600' : 'text-red-500'; ?>"><?php echo htmlspecialchars($appointment['english_test'] ?? 'No'); ?></span></div>
                    <?php if(strtolower($appointment['english_test'] ?? '') === 'yes'): ?>
                        <div><span class="block text-slate-400 uppercase text-xs font-bold">Test Name</span><span class="font-semibold"><?php echo htmlspecialchars($appointment['test_name'] ?? 'N/A'); ?></span></div>
                        <div><span class="block text-slate-400 uppercase text-xs font-bold">Overall Score</span><span class="font-semibold"><?php echo htmlspecialchars($appointment['test_results'] ?? 'N/A'); ?></span></div>
                    <?php else: ?>
                        <div class="col-span-2"><span class="block text-slate-400 uppercase text-xs font-bold">Planned Exam Date</span><span class="font-semibold"><?php echo !empty($appointment['planned_exam_date']) ? date('F d, Y', strtotime($appointment['planned_exam_date'])) : 'Not specified'; ?></span></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Block 4: Processing Goal -->
            <div>
                <h3 class="bg-slate-100 text-slate-700 px-4 py-2 uppercase font-bold text-sm tracking-wider mb-4 border-l-4 border-slate-400">4. Target Preferences</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-y-4 gap-x-8 px-4 text-sm">
                    <div><span class="block text-slate-400 uppercase text-xs font-bold">Degree Sought</span><span class="font-semibold"><?php echo htmlspecialchars($appointment['degree'] ?? 'N/A'); ?></span></div>
                    <div><span class="block text-slate-400 uppercase text-xs font-bold">Target Country</span><span class="font-semibold"><?php echo htmlspecialchars($appointment['interest_country'] ?? 'N/A'); ?></span></div>
                    <div><span class="block text-slate-400 uppercase text-xs font-bold">Course / Major</span><span class="font-semibold text-lg text-blue-700"><?php echo htmlspecialchars($appointment['interested_course'] ?? 'N/A'); ?></span></div>
                </div>
            </div>
            
        </div>

        <div class="mt-16 pt-8 border-t-2 border-dashed border-slate-200 flex justify-between items-end no-print">
            <div class="text-xs text-slate-400 pr-10">This document was generated automatically by the UGS portal system for official review purposes only.</div>
            <div class="text-center">
                <div class="w-48 border-b-2 border-slate-800 mb-2"></div>
                <div class="font-bold text-slate-700 text-sm">Counselor Signature</div>
            </div>
        </div>

    </div>

</body>
</html>
