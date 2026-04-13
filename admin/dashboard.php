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

    // --- NEW ADVANCED ANALYTICS ---
    // 1. Total Unique Visitors (All time)
    $stmt_uv = $pdo->query("SELECT COUNT(DISTINCT ip_address) FROM visitor_logs");
    $stats['unique_visitors'] = $stmt_uv->fetchColumn();

    // 2. Visitors Today
    $stmt_today = $pdo->query("SELECT COUNT(DISTINCT ip_address) FROM visitor_logs WHERE DATE(created_at) = CURDATE()");
    $stats['visitors_today'] = $stmt_today->fetchColumn();

    // 3. Top 5 Countries
    $stmt_top_countries = $pdo->query("SELECT country, COUNT(*) as count FROM visitor_logs GROUP BY country ORDER BY count DESC LIMIT 5");
    $stats['top_countries'] = $stmt_top_countries->fetchAll();

    // 4. Recent Traffic (Last 10 visits)
    $stmt_recent = $pdo->query("SELECT * FROM visitor_logs ORDER BY created_at DESC LIMIT 10");
    $stats['recent_traffic'] = $stmt_recent->fetchAll();

} catch (PDOException $e) {
    $stats = [];
}
?>

<!-- Advanced Analytics Row -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 mt-4">
    <!-- Stat Card 1 -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-black text-secondary/70 uppercase tracking-widest">Total Countries</span>
            <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-secondary text-xl border border-orange-100/50">
                <i class="ph ph-globe-hemisphere-west"></i>
            </div>
        </div>
        <div>
            <h3 class="text-3xl font-black text-slate-800"><?php echo $stats['countries'] ?? 0; ?></h3>
            <p class="text-xs font-bold text-slate-400 mt-1">Partnership Destinations</p>
        </div>
    </div>
    
    <!-- Stat Card 2 -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-black text-blue-500 uppercase tracking-widest">Universities</span>
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 text-xl border border-blue-100/50">
                <i class="ph ph-buildings"></i>
            </div>
        </div>
        <div>
            <h3 class="text-3xl font-black text-slate-800"><?php echo $stats['universities'] ?? 0; ?></h3>
            <p class="text-xs font-bold text-slate-400 mt-1">Listed Institutions</p>
        </div>
    </div>
    
    <!-- Visitors Today -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between hover:shadow-md transition bg-gradient-to-br from-white to-orange-50/30">
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-black text-secondary uppercase tracking-widest">Visitors Today</span>
            <div class="w-10 h-10 rounded-xl bg-secondary/10 flex items-center justify-center text-secondary text-xl animate-pulse">
                <i class="ph ph-users-three"></i>
            </div>
        </div>
        <div>
            <h3 class="text-3xl font-black text-slate-800 tracking-tight"><?php echo $stats['visitors_today'] ?? 0; ?></h3>
            <p class="text-xs font-bold text-slate-400 mt-1">Unique IP Addresses</p>
        </div>
    </div>

    <!-- Total Unique Visitors -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-black text-slate-500 uppercase tracking-widest">Total reach</span>
            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 text-xl">
                <i class="ph ph-chart-line-up"></i>
            </div>
        </div>
        <div>
            <h3 class="text-3xl font-black text-slate-800"><?php echo $stats['unique_visitors'] ?? 0; ?></h3>
            <p class="text-xs font-bold text-slate-400 mt-1">Total Unique Visitors</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Top Countries Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 lg:col-span-1">
        <div class="flex items-center justify-between mb-6 border-b border-slate-50 pb-4">
            <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Top Traffic Locations</h4>
            <i class="ph ph-map-trifold text-xl text-slate-400"></i>
        </div>
        <div class="space-y-4">
            <?php if(!empty($stats['top_countries'])): ?>
                <?php foreach($stats['top_countries'] as $c): ?>
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center text-secondary text-xs font-bold">
                                <?php echo substr($c['country'], 0, 2); ?>
                            </span>
                            <span class="text-sm font-bold text-slate-600 group-hover:text-secondary transition"><?php echo htmlspecialchars($c['country']); ?></span>
                        </div>
                        <span class="text-sm font-black text-slate-400 bg-slate-50 px-2 py-1 rounded-md"><?php echo $c['count']; ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-slate-400 text-xs italic">Awaiting visitor data...</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Traffic Log -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 lg:col-span-2 overflow-hidden">
        <div class="flex items-center justify-between mb-6 border-b border-slate-50 pb-4">
            <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Recent Activity Log</h4>
            <span class="px-2 py-1 bg-green-100 text-green-700 text-[10px] font-black uppercase rounded-md">Live Feed</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-4 py-3">Visitor Info</th>
                        <th class="px-4 py-3">Location</th>
                        <th class="px-4 py-3">Page / Referrer</th>
                        <th class="px-4 py-3">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if(!empty($stats['recent_traffic'])): ?>
                        <?php foreach($stats['recent_traffic'] as $log): ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-4">
                                    <div class="text-xs font-bold text-slate-700"><?php echo htmlspecialchars($log['ip_address']); ?></div>
                                    <div class="text-[10px] text-slate-400 truncate max-w-[120px]" title="<?php echo htmlspecialchars($log['user_agent']); ?>">
                                        <?php echo htmlspecialchars(substr($log['user_agent'], 0, 30)); ?>...
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="text-xs font-bold text-secondary"><?php echo htmlspecialchars($log['country']); ?></div>
                                    <div class="text-[10px] text-slate-400"><?php echo htmlspecialchars($log['city']); ?></div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="text-xs text-slate-600 truncate max-w-[150px]" title="<?php echo htmlspecialchars($log['page_url']); ?>">
                                        <?php echo str_replace('https://unilinkglobal.com/', '', $log['page_url']); ?>
                                    </div>
                                    <div class="text-[10px] text-slate-400"><?php echo htmlspecialchars($log['referrer']); ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-[10px] font-bold text-slate-500"><?php echo date('h:i A', strtotime($log['created_at'])); ?></div>
                                    <div class="text-[9px] text-slate-400"><?php echo date('d M', strtotime($log['created_at'])); ?></div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="px-4 py-8 text-center text-slate-400 italic">No logs found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- System & Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6 border-b border-slate-50 pb-4">Management Centre</h4>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <a href="about.php" class="p-4 border border-slate-100 rounded-2xl hover:border-secondary hover:text-secondary text-center transition flex flex-col items-center gap-2 group text-slate-600 hover:bg-slate-50">
                <i class="ph ph-info text-2xl group-hover:scale-110 transition"></i>
                <span class="text-xs font-bold uppercase tracking-wider">Company info</span>
            </a>
            <a href="appointments.php" class="p-4 border border-slate-100 rounded-2xl hover:border-secondary hover:text-secondary text-center transition flex flex-col items-center gap-2 group text-slate-600 hover:bg-slate-50">
                <i class="ph ph-notebook text-2xl group-hover:scale-110 transition"></i>
                <span class="text-xs font-bold uppercase tracking-wider">Fresh Leads</span>
            </a>
            <a href="universities.php" class="p-4 border border-slate-100 rounded-2xl hover:border-secondary hover:text-secondary text-center transition flex flex-col items-center gap-2 group text-slate-600 hover:bg-slate-50">
                <i class="ph ph-buildings text-2xl group-hover:scale-110 transition"></i>
                <span class="text-xs font-bold uppercase tracking-wider">Institutions</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6 border-b border-slate-50 pb-4">System Intelligence</h4>
        <div class="space-y-4">
            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl border border-slate-100 hover:border-secondary transition">
                <span class="text-xs font-bold text-slate-500">DATABASE STATUS</span>
                <span class="px-2 py-1 bg-green-100 text-green-700 text-[10px] font-black uppercase rounded-md border border-green-200">OPTIMIZED</span>
            </div>
            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl border border-slate-100">
                <span class="text-xs font-bold text-slate-500">AUTHORIZED ADMINS</span>
                <span class="text-xs font-black text-slate-800">
                    <?php echo $pdo->query("SELECT count(*) FROM admin")->fetchColumn(); ?> Accounts
                </span>
            </div>
            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl border border-slate-100">
                <span class="text-xs font-bold text-slate-500">MESSAGES / INBOX</span>
                <span class="text-xs font-black text-slate-800">
                    <?php echo $pdo->query("SELECT count(*) FROM subscriber")->fetchColumn(); ?> Active
                </span>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/components/footer.php'; ?>
