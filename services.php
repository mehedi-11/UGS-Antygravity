<?php
// services.php
require_once __DIR__ . '/components/header.php';

// Fetch all services
$services = [];
try {
    $services = $pdo->query("SELECT * FROM services ORDER BY position ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}
?>

<!-- Page Header -->
<section class="relative bg-slate-50 py-24 lg:py-32 overflow-hidden">
    <div class="absolute inset-0 opacity-40 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-multiply"></div>
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary rounded-full filter blur-[120px] opacity-70 translate-x-1/3 -translate-y-1/3"></div>
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-orange-50 rounded-full filter blur-[150px] opacity-60 -translate-x-1/4 translate-y-1/4"></div>

    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-800 mb-4 animate-on-scroll tracking-tight">Our Services</h1>
        <p class="text-lg text-slate-500 max-w-2xl mx-auto mb-6 animate-on-scroll delay-100">Comprehensive support tailored to ensure your international education journey is seamless and successful.</p>
        <div class="flex items-center justify-center gap-2 text-slate-400 text-sm font-medium animate-on-scroll delay-200">
            <a href="index" class="hover:text-secondary transition text-slate-500 font-bold">Home</a>
            <i class="ph ph-caret-right"></i>
            <span class="text-secondary font-bold">Services</span>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="py-24 bg-white min-h-[60vh]">
    <div class="container mx-auto px-4">
        
        <?php if(!empty($services)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach($services as $index => $service): ?>
                    <div class="bg-slate-50 rounded-3xl p-8 shadow-sm hover:shadow-xl hover:-translate-y-2 transition duration-500 border border-slate-100 group flex flex-col h-full animate-on-scroll" style="animation-delay: <?php echo ($index * 100); ?>ms;">
                        
                        <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-4xl mb-6 shadow-sm bg-white text-secondary group-hover:scale-110 transition duration-300 transform border border-slate-100">
                            <?php if($service['icon_class']): ?>
                                <i class="<?php echo htmlspecialchars($service['icon_class']); ?>"></i>
                            <?php elseif($service['image']): ?>
                                <img src="uploads/services/<?php echo htmlspecialchars($service['image']); ?>" class="w-full h-full object-cover rounded-2xl">
                            <?php else: ?>
                                <i class="ph ph-briefcase cursor-pointer text-secondary"></i>
                            <?php endif; ?>
                        </div>

                        <h3 class="text-2xl font-bold text-slate-800 mb-4 group-hover:text-secondary transition"><?php echo htmlspecialchars($service['title']); ?></h3>
                        
                        <p class="text-slate-500 leading-relaxed mb-8 flex-grow">
                            <?php echo nl2br(htmlspecialchars($service['details'])); ?>
                        </p>
                        
                        <div class="mt-auto border-t border-slate-200 pt-6">
                            <a href="contact" class="inline-flex items-center gap-2 text-slate-600 font-bold hover:text-secondary transition">Get Assistance <i class="ph ph-arrow-right"></i></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-400 text-4xl shadow-inner border border-slate-100">
                    <i class="ph ph-briefcase"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-700 mb-2 mt-4">We are preparing our services</h2>
                <p class="text-slate-500">Please check back later to see what we offer.</p>
            </div>
        <?php endif; ?>
        
    </div>
</section>

<!-- Call to action -->
<section class="py-20 bg-secondary relative overflow-hidden text-center">
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Need personalized guidance?</h2>
        <p class="text-white/80 text-lg max-w-2xl mx-auto mb-10">Book a free consultation session with our experts today.</p>
        <a href="appointment" class="bg-white hover:bg-slate-50 text-secondary px-10 py-4 text-lg rounded-full font-bold shadow-xl transition transform hover:-translate-y-1 inline-flex items-center gap-2">
            Book an Appointment <i class="ph ph-calendar-check"></i>
        </a>
    </div>
</section>

<?php require_once __DIR__ . '/components/footer.php'; ?>
