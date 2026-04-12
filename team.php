<?php
// team.php
require_once __DIR__ . '/components/header.php';

$all_members = [];
try {
    $all_members = $pdo->query("SELECT * FROM team ORDER BY position ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

// Extract Featured (First one in list)
$featured = !empty($all_members) ? $all_members[0] : null;
$others = [];
if ($featured) {
    for($i = 1; $i < count($all_members); $i++) {
        $others[] = $all_members[$i];
    }
}

// Group others by team_name
$tabs = [];
foreach($others as $m) {
    $tname = !empty($m['team_name']) ? $m['team_name'] : 'Our Experts';
    $tabs[$tname][] = $m;
}

$tab_names = array_keys($tabs);
?>

<!-- Featured CEO Message Section (Light Version) -->
<?php if($featured): ?>
<section class="relative bg-white pt-24 pb-20 lg:pt-32 lg:pb-24 border-b border-slate-100 overflow-hidden">
    <!-- Subtle Light Decor -->
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-secondary/5 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-slate-100 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/2"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
            
            <!-- Left: Content Column -->
            <div class="lg:w-1/2 text-center lg:text-left order-2 lg:order-1">
                <div class="inline-flex items-center gap-2 mb-6 animate-on-scroll">
                    <span class="w-10 h-[2px] bg-secondary"></span>
                    <span class="text-secondary font-bold text-xs uppercase tracking-widest">Message from CEO</span>
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-dark mb-6 leading-tight animate-on-scroll">
                    <?php echo htmlspecialchars($featured['name']); ?>
                </h1>
                
                <h4 class="text-secondary font-bold text-base mb-8 uppercase tracking-widest animate-on-scroll delay-100">
                    <?php echo htmlspecialchars($featured['designation']); ?>
                </h4>

                <div class="relative animate-on-scroll delay-200 bg-slate-50 p-8 rounded-3xl border border-slate-100 shadow-sm mb-8">
                    <i class="ph ph-quotes text-5xl text-slate-200 absolute -top-4 -left-2"></i>
                    <p class="text-slate-600 italic leading-relaxed text-[14px] text-justify relative z-10">
                        "<?php echo htmlspecialchars($featured['say']); ?>"
                    </p>
                </div>

                <div class="flex flex-wrap justify-center lg:justify-start gap-4 animate-on-scroll delay-300">
                    <a href="contact" class="bg-dark text-white px-8 py-3.5 rounded-full font-bold hover:bg-secondary transition shadow-lg active:scale-95">
                        Contact Office
                    </a>
                </div>
            </div>

            <!-- Right: Image Column -->
            <div class="lg:w-1/2 relative animate-on-scroll order-1 lg:order-2">
                <div class="relative z-10">
                    <div class="relative aspect-square max-w-[450px] mx-auto group">
                        <!-- Decorative Frame -->
                        <div class="absolute inset-0 border-2 border-dashed border-secondary/30 rounded-full animate-spin-slow group-hover:border-secondary transition-colors duration-500"></div>
                        
                        <!-- Main Image -->
                        <div class="absolute inset-4 rounded-full overflow-hidden border-8 border-white shadow-2xl">
                            <?php if($featured['profile_image']): ?>
                                <img src="uploads/team/<?php echo htmlspecialchars($featured['profile_image']); ?>" alt="CEO" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                    <i class="ph ph-user text-9xl"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<?php endif; ?>

<style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 15s linear infinite;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>

<!-- Team Tabs Section -->
<section class="py-24 bg-white relative">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16 animate-on-scroll">
            <h2 class="text-3xl md:text-5xl font-bold text-dark mb-6">Our Diverse <span class="text-secondary">Expertise</span></h2>
            <p class="text-slate-500 text-lg leading-relaxed">Meet the rest of our dedicated team members, categorized by their specialized focus areas.</p>
        </div>

        <?php if(!empty($tab_names)): ?>
            <!-- Tab Navigation -->
            <div class="flex flex-wrap justify-center gap-4 mb-16 animate-on-scroll">
                <?php foreach($tab_names as $index => $name): ?>
                    <button 
                        data-tab-target="<?php echo slugify($name); ?>" 
                        class="tab-btn px-8 py-3 rounded-full font-bold text-sm transition-all duration-300 <?php echo $index === 0 ? 'bg-secondary text-white shadow-lg shadow-secondary/20' : 'bg-slate-100 text-slate-500 hover:bg-slate-200'; ?>">
                        <?php echo htmlspecialchars($name); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Tab Contents -->
            <div class="relative min-h-[400px]">
                <?php foreach($tabs as $name => $members): ?>
                    <div id="<?php echo slugify($name); ?>" class="tab-content <?php echo $name === $tab_names[0] ? 'grid' : 'hidden'; ?> grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                        <?php foreach($members as $m): ?>
                            <div class="group flex flex-col items-center text-center animate-fade-in">
                                <!-- Circular Image Container -->
                                <div class="w-48 h-48 md:w-56 md:h-56 rounded-full p-2 border-2 border-dashed border-slate-200 group-hover:border-secondary group-hover:border-solid transition-all duration-500 mb-6 bg-white relative">
                                    <div class="w-full h-full rounded-full overflow-hidden border-4 border-white shadow-xl">
                                        <?php if($m['profile_image']): ?>
                                            <img src="uploads/team/<?php echo htmlspecialchars($m['profile_image']); ?>" alt="<?php echo htmlspecialchars($m['name']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                        <?php else: ?>
                                            <div class="w-full h-full bg-slate-50 flex items-center justify-center text-slate-300 text-5xl">
                                                <i class="ph ph-user"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Social Float -->
                                    <div class="absolute -right-2 top-1/2 -translate-y-1/2 flex flex-col gap-2 opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 transition-all duration-300">
                                        <a href="#" class="w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center text-sm shadow-lg hover:bg-dark transition"><i class="ph ph-facebook-logo"></i></a>
                                        <a href="#" class="w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center text-sm shadow-lg hover:bg-dark transition"><i class="ph ph-linkedin-logo"></i></a>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <h3 class="text-xl font-bold text-dark group-hover:text-secondary transition"><?php echo htmlspecialchars($m['name']); ?></h3>
                                    <p class="text-slate-400 text-sm font-medium uppercase tracking-wider"><?php echo htmlspecialchars($m['designation']); ?></p>
                                    
                                    <?php if(!empty($m['certified_by'])): ?>
                                        <div class="pt-4 mt-4 border-t border-slate-100 text-[10px] font-bold text-slate-400 flex items-center justify-center gap-1 uppercase tracking-widest">
                                            <i class="ph ph-seal-check text-secondary text-sm"></i> Certified by <?php echo htmlspecialchars($m['certified_by']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-20 text-slate-300 italic">
                Team category information will appear here soon.
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
    // Tab Switching Logic
    document.addEventListener('DOMContentLoaded', () => {
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const target = btn.getAttribute('data-tab-target');

                // Remove active classes
                tabBtns.forEach(b => {
                    b.classList.remove('bg-secondary', 'text-white', 'shadow-lg', 'shadow-secondary/20');
                    b.classList.add('bg-slate-100', 'text-slate-500');
                });
                tabContents.forEach(c => {
                    c.classList.add('hidden');
                    c.classList.remove('grid');
                });

                // Add active classes to current
                btn.classList.add('bg-secondary', 'text-white', 'shadow-lg', 'shadow-secondary/20');
                btn.classList.remove('bg-slate-100', 'text-slate-500');
                
                const targetContent = document.getElementById(target);
                targetContent.classList.remove('hidden');
                targetContent.classList.add('grid');
            });
        });
    });
</script>


<?php require_once __DIR__ . '/components/footer.php'; ?>
