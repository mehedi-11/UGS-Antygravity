<?php
// country-view.php
require_once __DIR__ . '/components/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$country = null;
$universities = [];

if ($id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM country WHERE id = ?");
        $stmt->execute([$id]);
        $country = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($country) {
            $uniStmt = $pdo->prepare("SELECT * FROM university WHERE country_name = ? ORDER BY position ASC");
            $uniStmt->execute([$country['country_name']]);
            $universities = $uniStmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (Exception $e) {}
}

if (!$country) {
    set_flash_msg('error', 'Destination not found.');
    redirect('destinations.php');
}
?>

<!-- Country Hero Header -->
<section class="relative bg-slate-50 pt-24 pb-16 lg:pt-32 lg:pb-24 overflow-hidden border-b border-slate-100">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-multiply"></div>
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-secondary rounded-full filter blur-[150px] opacity-20 translate-x-1/3 -translate-y-1/3"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col lg:flex-row gap-12 items-center">
            
            <!-- Information -->
            <div class="lg:w-1/2">
                <div class="flex items-center gap-2 text-slate-400 text-sm font-bold uppercase tracking-widest mb-6 animate-on-scroll">
                    <a href="index.php" class="hover:text-secondary transition">Home</a>
                    <i class="ph ph-caret-right"></i>
                    <a href="destinations.php" class="hover:text-secondary transition">Destinations</a>
                    <i class="ph ph-caret-right"></i>
                    <span class="text-secondary"><?php echo htmlspecialchars($country['country_name']); ?></span>
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-800 mb-6 animate-on-scroll delay-100 tracking-tight">
                    Study in <span class="text-secondary"><?php echo htmlspecialchars($country['country_name']); ?></span>
                </h1>
                
                <div class="prose prose-lg prose-slate max-w-none mb-8 animate-on-scroll delay-200">
                    <p class="leading-relaxed text-slate-600">
                        <?php echo nl2br(htmlspecialchars($country['details'] ?? 'Discover world-class universities and vibrant student life in ' . $country['country_name'] . '.')); ?>
                    </p>
                </div>
                
                <div class="flex flex-wrap gap-4 animate-on-scroll delay-300">
                    <a href="#universities-section" class="bg-secondary hover:bg-accent text-white px-8 py-3.5 rounded-full font-bold shadow-lg shadow-orange-500/30 transition transform hover:-translate-y-1 flex items-center gap-2">
                        Explore Universities <i class="ph ph-arrow-down"></i>
                    </a>
                    <a href="appointment.php" class="bg-white border border-slate-200 hover:border-secondary hover:text-secondary text-slate-600 px-8 py-3.5 rounded-full font-bold shadow-sm transition transform hover:-translate-y-1 flex items-center gap-2">
                        Book Consultation <i class="ph ph-calendar-check"></i>
                    </a>
                </div>
            </div>
            
            <!-- Image Frame -->
            <div class="lg:w-1/2 w-full animate-on-scroll delay-200">
                <div class="relative rounded-[2rem] overflow-hidden shadow-2xl border-4 border-white aspect-video md:aspect-[4/3] group">
                    <?php if($country['country_image']): ?>
                        <img src="uploads/countries/<?php echo htmlspecialchars($country['country_image']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <?php else: ?>
                        <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400 text-6xl">
                            <i class="ph ph-globe-hemisphere-west"></i>
                        </div>
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent mix-blend-multiply opacity-0 group-hover:opacity-100 transition duration-500"></div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Related Universities Section -->
<section id="universities-section" class="py-24 bg-white min-h-[50vh]">
    <div class="container mx-auto px-4">
        
        <div class="text-center max-w-2xl mx-auto mb-16 animate-on-scroll">
            <h4 class="text-secondary font-bold tracking-wider uppercase text-sm mb-2">Partner Institutions</h4>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800">Universities in <span class="text-secondary"><?php echo htmlspecialchars($country['country_name']); ?></span></h2>
        </div>
        
        <?php if(!empty($universities)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach($universities as $index => $uni): ?>
                    <a href="university-view.php?id=<?php echo $uni['id']; ?>" class="bg-slate-50 rounded-3xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-2 transition duration-300 border border-slate-100 group flex flex-col text-center block animate-on-scroll" style="animation-delay: <?php echo ($index * 100); ?>ms;">
                        
                        <div class="h-40 mb-6 flex items-center justify-center bg-white rounded-2xl relative overflow-hidden shadow-sm border border-slate-100 group-hover:border-secondary/20 transition">
                            <?php if($uni['image']): ?>
                                <img src="uploads/universities/<?php echo htmlspecialchars($uni['image']); ?>" class="max-w-[70%] max-h-[70%] object-contain group-hover:scale-110 transition duration-500">
                            <?php else: ?>
                                <i class="ph ph-graduation-cap text-6xl text-slate-300"></i>
                            <?php endif; ?>
                        </div>
                        
                        <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-secondary transition min-h-[3.5rem] flex items-center justify-center leading-snug">
                            <?php echo htmlspecialchars($uni['university_name']); ?>
                        </h3>
                        
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center justify-center gap-1">
                            <i class="ph ph-map-pin text-secondary"></i> <?php echo htmlspecialchars($uni['country_name']); ?>
                        </p>
                        
                        <p class="text-slate-500 text-sm leading-relaxed mb-6 flex-grow line-clamp-3">
                            <?php echo htmlspecialchars($uni['details']); ?>
                        </p>
                        
                        <div class="mt-auto pt-4 border-t border-slate-200">
                            <span class="text-secondary font-bold group-hover:text-accent flex items-center justify-center gap-2 transition">
                                University Details <i class="ph ph-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-16 bg-slate-50 rounded-3xl border border-slate-100 max-w-3xl mx-auto">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 text-4xl shadow-sm">
                    <i class="ph ph-buildings"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-700 mb-2">No Universities Listed Yet</h3>
                <p class="text-slate-500 max-w-md mx-auto">We are currently updating our database for universities in <?php echo htmlspecialchars($country['country_name']); ?>.</p>
                <div class="mt-6">
                    <a href="contact.php" class="inline-flex items-center gap-2 text-secondary font-bold hover:text-accent transition">Contact us for details <i class="ph ph-arrow-right"></i></a>
                </div>
            </div>
        <?php endif; ?>
        
    </div>
</section>

<?php require_once __DIR__ . '/components/footer.php'; ?>
