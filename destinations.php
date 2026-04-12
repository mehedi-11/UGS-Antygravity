<?php
// destinations.php
require_once __DIR__ . '/components/header.php';

$countries = [];
try {
    $countries = $pdo->query("SELECT * FROM country ORDER BY position ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

?>

<!-- Page Header -->
<section class="relative bg-slate-50 py-24 lg:py-32 overflow-hidden border-b border-slate-100">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-multiply"></div>
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-secondary rounded-full filter blur-[150px] opacity-20 translate-x-1/3 -translate-y-1/3"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-800 mb-4 animate-on-scroll">Global Destinations</h1>
        <p class="text-lg text-slate-500 max-w-2xl mx-auto mb-6 animate-on-scroll delay-100">Explore the world's most vibrant, high-quality, and sought-after education hubs.</p>
        <div class="flex items-center justify-center gap-2 text-slate-400 text-sm font-medium animate-on-scroll delay-200">
            <a href="index" class="hover:text-secondary transition text-slate-500 font-bold">Home</a>
            <i class="ph ph-caret-right"></i>
            <span class="text-secondary font-bold">Destinations</span>
        </div>
    </div>
</section>

<!-- Destinations Grid -->
<section class="py-24 bg-slate-50 min-h-[60vh]">
    <div class="container mx-auto px-4">
        
        <?php if(!empty($countries)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach($countries as $index => $country): ?>
                    <a href="country-<?php echo $country['id']; ?>-<?php echo slugify($country['country_name']); ?>" class="block group relative rounded-[2rem] overflow-hidden shadow-sm hover:shadow-2xl transition duration-500 h-[380px] animate-on-scroll" style="animation-delay: <?php echo ($index * 100); ?>ms;">
                        <?php if($country['country_image']): ?>
                            <img src="uploads/countries/<?php echo htmlspecialchars($country['country_image']); ?>" class="w-full h-full object-cover group-hover:scale-110 group-hover:rotate-1 transition duration-700 ease-out">
                        <?php else: ?>
                            <div class="w-full h-full bg-slate-200 flex flex-col items-center justify-center text-slate-400">
                                <i class="ph ph-globe-hemisphere-west text-6xl"></i>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-dark/95 via-dark/50 to-transparent opacity-95 transition duration-500"></div>
                        
                        <!-- Content -->
                        <div class="absolute inset-0 p-6 flex flex-col justify-end">
                            <div class="transition duration-500 ease-out pb-2">
                                <h3 class="text-2xl font-bold text-white mb-2"><?php echo htmlspecialchars($country['country_name']); ?></h3>
                                
                                <p class="text-slate-300 text-sm line-clamp-2 mb-5 leading-relaxed font-light">Explore world-class universities and vibrant student life in <?php echo htmlspecialchars($country['country_name']); ?>.</p>
                                <span class="bg-secondary text-white px-5 py-2.5 rounded-full text-xs font-bold inline-flex items-center gap-2 shadow-lg shadow-orange-500/20 w-fit">
                                    Explore <i class="ph ph-arrow-right font-bold"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-slate-200 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-400 text-4xl">
                    <i class="ph ph-compass"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-600 mb-2">No Destinations Found</h2>
                <p class="text-slate-500">We are constantly updating our database. Please check back soon.</p>
            </div>
        <?php endif; ?>
        
    </div>
</section>

<!-- Call to action -->
<section class="py-20 bg-primary relative overflow-hidden text-center">
    <!-- Overlay/Pattern -->
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#f97316 1px, transparent 1px); background-size: 24px 24px;"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <h2 class="text-3xl md:text-5xl font-bold text-dark mb-6">Confused about where to study?</h2>
        <p class="text-slate-600 text-lg max-w-2xl mx-auto mb-10">Our expert counselors can help you choose the best country based on your academic profile, budget, and future career goals.</p>
        <a href="appointment" class="bg-secondary hover:bg-accent text-white px-10 py-4 rounded-full font-bold shadow-xl transition transform hover:-translate-y-1 inline-flex items-center gap-2">
            Talk to an Expert <i class="ph ph-chat-circle-dots"></i>
        </a>
    </div>
</section>

<?php require_once __DIR__ . '/components/footer.php'; ?>
