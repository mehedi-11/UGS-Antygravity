<?php
// partners.php
require_once __DIR__ . '/components/header.php';

$partners = [];
try {
    $partners = $pdo->query("SELECT * FROM partners ORDER BY position ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

// We can also fetch the partner logos from the 'about' table if we want a global banner of logos.
$about_info = [];
try {
    $about_info = $pdo->query("SELECT partner_names, partner_logos FROM about LIMIT 1")->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {}
?>

<!-- Page Header -->
<section class="relative bg-dark py-24 lg:py-32 overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute inset-0 opacity-20" style="background-image: url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=1600&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-dark to-dark/80"></div>
    <div class="absolute top-0 left-0 w-full h-full text-secondary opacity-5 pointer-events-none fade-grid z-0"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 animate-on-scroll">Our Industry Partners</h1>
        <div class="flex items-center justify-center gap-2 text-slate-300 text-sm font-medium animate-on-scroll delay-100">
            <a href="index.php" class="hover:text-secondary transition">Home</a>
            <i class="ph ph-caret-right"></i>
            <span class="text-secondary">Partners</span>
        </div>
    </div>
</section>

<!-- Partners Grid -->
<section class="py-20 bg-slate-50 min-h-[50vh]">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-16 animate-on-scroll">
            <h4 class="text-secondary font-bold tracking-wider uppercase text-sm mb-2">Global Network</h4>
            <h2 class="text-3xl md:text-4xl font-bold text-dark mb-4">Organizations We <span class="text-secondary">Trust</span></h2>
            <p class="text-slate-500">We work closely with elite universities and industry leaders to provide the best opportunities for our students.</p>
        </div>

        <?php if(!empty($partners)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach($partners as $index => $partner): ?>
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-xl transition duration-300 text-center group animate-on-scroll" style="animation-delay: <?php echo ($index * 50); ?>ms;">
                        <div class="h-24 flex items-center justify-center mb-6">
                            <?php if($partner['logo']): ?>
                                <img src="uploads/partners/<?php echo htmlspecialchars($partner['logo']); ?>" alt="<?php echo htmlspecialchars($partner['company_name']); ?>" class="max-h-full max-w-full object-contain grayscale group-hover:grayscale-0 transition duration-500 transform group-hover:scale-110">
                            <?php else: ?>
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 text-2xl"><i class="ph ph-buildings"></i></div>
                            <?php endif; ?>
                        </div>
                        <h3 class="text-xl font-bold text-dark mb-2"><?php echo htmlspecialchars($partner['company_name']); ?></h3>
                        <?php if($partner['company_location']): ?>
                            <p class="text-xs font-semibold text-secondary uppercase tracking-wider mb-4"><i class="ph ph-map-pin"></i> <?php echo htmlspecialchars($partner['company_location']); ?></p>
                        <?php endif; ?>
                        <p class="text-slate-500 text-sm leading-relaxed line-clamp-4">
                            <?php echo htmlspecialchars($partner['details']); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Fallback if no specific partners are added yet but about table has a list -->
            <?php if(!empty($about_info['partner_names'])): ?>
                <?php 
                    $p_names = explode(',', str_replace(array("\r", "\n", ";"), ',', $about_info['partner_names']));
                    $p_names = array_filter(array_map('trim', $p_names));
                ?>
                <div class="flex flex-wrap justify-center gap-4">
                    <?php foreach($p_names as $name): ?>
                        <span class="px-6 py-3 bg-white border border-slate-200 rounded-full font-bold text-slate-600 shadow-sm"><?php echo htmlspecialchars($name); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-20 text-slate-400">
                    <i class="ph-light ph-briefcase text-6xl mb-4"></i>
                    <p>Partners list is currently being updated.</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Call to action -->
<section class="py-16 bg-dark text-white text-center">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-4">Want to partner with us?</h2>
        <p class="text-slate-400 mb-8 max-w-2xl mx-auto">We are always looking to expand our network to provide more valuable opportunities for international students.</p>
        <a href="contact.php" class="inline-flex items-center gap-2 bg-secondary text-white px-8 py-3 rounded-full font-bold hover:bg-accent transition shadow-lg">Become a Partner <i class="ph ph-arrow-right"></i></a>
    </div>
</section>

<?php require_once __DIR__ . '/components/footer.php'; ?>
