<?php
// about.php
require_once __DIR__ . '/components/header.php';

$about_info = [];
try {
    $about_info = $pdo->query("SELECT * FROM about LIMIT 1")->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

// Extract data with fallbacks
$company_name = $about_info['company_name'] ?? 'Unilink Global Solution';
$about_text = $about_info['about_company'] ?? 'We are dedicated to helping students study abroad.';
$mission = $about_info['mission'] ?? 'To empower students globally.';
$vision = $about_info['vision'] ?? 'To be the number one study abroad agency.';
$stats = [
    'Countries' => $about_info['country'] ?? '10+',
    'Universities' => $about_info['university'] ?? '500+',
    'Students' => $about_info['student'] ?? '50k+',
    'Happy Smiles' => $about_info['happy_smile'] ?? '98%'
];
?>

<!-- Page Header -->
<section class="relative bg-dark py-24 lg:py-32 overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute inset-0 opacity-20" style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1600&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-dark to-dark/80"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-secondary rounded-full filter blur-[120px] opacity-30"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 animate-on-scroll">About <?php echo htmlspecialchars($company_name); ?></h1>
        <div class="flex items-center justify-center gap-2 text-slate-300 text-sm font-medium animate-on-scroll delay-100">
            <a href="index.php" class="hover:text-secondary transition">Home</a>
            <i class="ph ph-caret-right"></i>
            <span class="text-secondary">About Us</span>
        </div>
    </div>
</section>

<!-- Company Overview -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center animate-on-scroll">
            <h4 class="text-secondary font-bold tracking-wider uppercase text-sm mb-4">Who We Are</h4>
            <h2 class="text-3xl md:text-4xl font-bold text-dark mb-8 leading-tight">Your Trusted Gateway to <span class="text-secondary">Global Education</span></h2>
            <div class="prose prose-lg mx-auto text-slate-600 leading-relaxed">
                <?php echo nl2br(htmlspecialchars($about_text)); ?>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-20 bg-slate-50 relative">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Mission -->
            <div class="bg-white p-10 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-xl transition duration-300 animate-on-scroll">
                <div class="absolute top-0 right-0 w-32 h-32 bg-secondary/5 rounded-bl-full -z-10 group-hover:bg-secondary/10 transition"></div>
                <div class="w-16 h-16 bg-secondary text-white rounded-2xl flex items-center justify-center text-3xl mb-8 shadow-md">
                    <i class="ph ph-target"></i>
                </div>
                <h3 class="text-2xl font-bold text-dark mb-4">Our Mission</h3>
                <p class="text-slate-600 leading-relaxed"><?php echo nl2br(htmlspecialchars($mission)); ?></p>
            </div>
            
            <!-- Vision -->
            <div class="bg-white p-10 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-xl transition duration-300 animate-on-scroll delay-100">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full -z-10 group-hover:bg-primary/10 transition"></div>
                <div class="w-16 h-16 bg-primary text-secondary rounded-2xl flex items-center justify-center text-3xl mb-8 shadow-md">
                    <i class="ph ph-eye"></i>
                </div>
                <h3 class="text-2xl font-bold text-dark mb-4">Our Vision</h3>
                <p class="text-slate-600 leading-relaxed"><?php echo nl2br(htmlspecialchars($vision)); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Grid -->
<section class="py-20 bg-dark text-white relative border-t border-slate-800">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <?php $delay = 0; foreach($stats as $label => $value): ?>
                <div class="animate-on-scroll" style="animation-delay: <?php echo $delay; ?>ms;">
                    <div class="text-4xl md:text-5xl font-extrabold text-secondary mb-3"><?php echo htmlspecialchars($value); ?></div>
                    <div class="text-sm font-semibold text-slate-400 uppercase tracking-widest"><?php echo $label; ?></div>
                </div>
            <?php $delay+=100; endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/components/footer.php'; ?>
