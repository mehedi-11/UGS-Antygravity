<?php
// admin/dashboard.php
require_once __DIR__ . '/components/header.php';

// Quick stats query
try {
    $stats = [
        'countries' => $pdo->query("SELECT count(*) FROM country")->fetchColumn(),
        'universities' => $pdo->query("SELECT count(*) FROM university")->fetchColumn(),
        'appointments' => $pdo->query("SELECT count(*) FROM appointment")->fetchColumn(),
        'chatbots' => $pdo->query("SELECT count(*) FROM chatbot_leads")->fetchColumn(),
        'events' => $pdo->query("SELECT count(*) FROM event")->fetchColumn(),
        'teams' => $pdo->query("SELECT count(*) FROM team")->fetchColumn(),
    ];
} catch (PDOException $e) {
    $stats = [];
}
?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Stat Card 1 -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-sm font-medium text-slate-500 uppercase tracking-wider mb-1">Total Countries</p>
            <h3 class="text-3xl font-bold text-slate-800"><?php echo $stats['countries'] ?? 0; ?></h3>
        </div>
        <div class="w-14 h-14 rounded-full bg-orange-100 flex items-center justify-center text-secondary text-2xl">
            <i class="ph-fill ph-globe-hemisphere-west"></i>
        </div>
    </div>
    
    <!-- Stat Card 2 -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-sm font-medium text-slate-500 uppercase tracking-wider mb-1">Universities</p>
            <h3 class="text-3xl font-bold text-slate-800"><?php echo $stats['universities'] ?? 0; ?></h3>
        </div>
        <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-2xl">
            <i class="ph-fill ph-buildings"></i>
        </div>
    </div>
    
    <!-- Stat Card 3 -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-sm font-medium text-slate-500 uppercase tracking-wider mb-1">Appointments</p>
            <h3 class="text-3xl font-bold text-slate-800"><?php echo $stats['appointments'] ?? 0; ?></h3>
        </div>
        <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-2xl">
            <i class="ph-fill ph-notebook"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h4 class="text-lg font-semibold text-slate-800 mb-4 border-b pb-2">Quick Actions</h4>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <a href="about.php" class="p-4 border rounded-xl hover:border-secondary hover:text-secondary text-center transition flex flex-col items-center gap-2 group text-slate-600">
                <i class="ph ph-info text-3xl group-hover:drop-shadow-md"></i>
                <span class="text-sm font-medium">Edit About</span>
            </a>
            <a href="appointments.php" class="p-4 border rounded-xl hover:border-secondary hover:text-secondary text-center transition flex flex-col items-center gap-2 group text-slate-600">
                <i class="ph ph-notebook text-3xl group-hover:drop-shadow-md"></i>
                <span class="text-sm font-medium">View Leads</span>
            </a>
            <a href="universities.php" class="p-4 border rounded-xl hover:border-secondary hover:text-secondary text-center transition flex flex-col items-center gap-2 group text-slate-600">
                <i class="ph ph-buildings text-3xl group-hover:drop-shadow-md"></i>
                <span class="text-sm font-medium">Manage Universities</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h4 class="text-lg font-semibold text-slate-800 mb-4 border-b pb-2">System Status</h4>
        <div class="space-y-4 text-sm text-slate-600">
            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-lg border">
                <span>Database Connection</span>
                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-md">Online</span>
            </div>
            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-lg border">
                <span>Active Admins</span>
                <span class="font-bold text-slate-800">
                    <?php echo $pdo->query("SELECT count(*) FROM admin")->fetchColumn(); ?>
                </span>
            </div>
            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-lg border">
                <span>Total Subscribers</span>
                <span class="font-bold text-slate-800">
                    <?php echo $pdo->query("SELECT count(*) FROM subscriber")->fetchColumn(); ?>
                </span>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/components/footer.php'; ?>
