<?php
// university-view.php
require_once __DIR__ . '/components/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$university = null;

if ($id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM university WHERE id = ?");
        $stmt->execute([$id]);
        $university = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {}
}

if (!$university) {
    set_flash_msg('error', 'University not found.');
    redirect('universities');
}
?>

<!-- University Hero Header -->
<section class="relative bg-dark pt-24 pb-20 lg:pt-32 lg:pb-28 overflow-hidden">
    <!-- Banner Background Image with Overlay -->
    <?php if(!empty($university['university_banner'])): ?>
        <div class="absolute inset-0">
            <img src="uploads/universities/<?php echo htmlspecialchars($university['university_banner']); ?>" class="w-full h-full object-cover" alt="Banner">
            <div class="absolute inset-0 bg-slate-900/80 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-dark via-dark/80 to-transparent opacity-90"></div>
        </div>
    <?php else: ?>
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-multiply"></div>
        <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-primary rounded-full filter blur-[150px] opacity-20 translate-x-1/3 -translate-y-1/3"></div>
    <?php endif; ?>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row gap-10 items-center justify-between">
            
            <!-- Information -->
            <div class="md:w-2/3">
                <div class="flex flex-wrap items-center gap-2 text-slate-300 text-sm font-bold uppercase tracking-widest mb-6 animate-on-scroll">
                    <a href="index" class="hover:text-secondary transition text-slate-400">Home</a>
                    <i class="ph ph-caret-right text-slate-500"></i>
                    <a href="universities" class="hover:text-secondary transition text-slate-400">Universities</a>
                    <i class="ph ph-caret-right text-slate-500"></i>
                    <span class="text-secondary"><?php echo htmlspecialchars($university['university_name']); ?></span>
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 animate-on-scroll delay-100 tracking-tight leading-tight">
                    <?php echo htmlspecialchars($university['university_name']); ?>
                </h1>
                
                <div class="flex flex-wrap items-center gap-6 text-sm font-bold uppercase tracking-widest mb-10 animate-on-scroll delay-200">
                    <span class="flex items-center gap-2 text-primary">
                        <i class="ph-fill ph-map-pin text-xl"></i> <?php echo htmlspecialchars($university['country'] ?? ''); ?>
                    </span>
                    <?php if(!empty($university['location'])): ?>
                    <span class="flex items-center gap-2 text-slate-300">
                        <i class="ph-fill ph-navigation-arrow text-xl"></i> <?php echo htmlspecialchars($university['location']); ?>
                    </span>
                    <?php endif; ?>
                </div>
                
                <div class="flex flex-wrap gap-4 animate-on-scroll delay-300">
                    <a href="appointment" class="bg-secondary hover:bg-accent text-white px-8 py-3.5 rounded-full font-bold shadow-lg shadow-orange-500/30 transition transform hover:-translate-y-1 flex items-center gap-2">
                        Apply Now <i class="ph ph-paper-plane-tilt"></i>
                    </a>
                </div>
            </div>

            <!-- Logo Card -->
            <div class="md:w-1/3 flex justify-center md:justify-end animate-on-scroll delay-200">
                <div class="w-56 h-56 md:w-64 md:h-64 bg-white/10 backdrop-blur-md rounded-[2rem] shadow-2xl border border-white/20 flex items-center justify-center p-8 group relative overflow-hidden">
                    <div class="absolute inset-0 bg-white group-hover:opacity-95 opacity-100 transition duration-500"></div>
                    <div class="relative z-10 w-full h-full flex items-center justify-center">
                        <?php if(!empty($university['university_logo'])): ?>
                            <img src="uploads/universities/<?php echo htmlspecialchars($university['university_logo']); ?>" class="max-w-full max-h-full object-contain group-hover:scale-110 transition duration-500">
                        <?php else: ?>
                            <i class="ph ph-graduation-cap text-8xl text-slate-300 group-hover:text-secondary transition"></i>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Details Section -->
<section class="py-20 bg-slate-50 min-h-[50vh]">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- Left Content: About -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-sm border border-slate-100 mb-8 animate-on-scroll">
                    <div class="flex items-center gap-4 border-b border-slate-100 pb-6 mb-8">
                        <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-secondary text-2xl"><i class="ph ph-buildings"></i></div>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-800">
                            About University
                        </h2>
                    </div>

                    <div class="prose prose-lg prose-slate max-w-none text-slate-600 leading-relaxed font-light">
                        <?php if(!empty($university['about_university'])): ?>
                            <?php echo nl2br(htmlspecialchars($university['about_university'])); ?>
                        <?php else: ?>
                            <p class="italic text-slate-400">Detailed information about this university is being updated.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if(!empty($university['student_facility'])): ?>
                <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-sm border border-slate-100 mb-8 animate-on-scroll delay-100">
                    <div class="flex items-center gap-4 border-b border-slate-100 pb-6 mb-8">
                        <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-secondary text-2xl"><i class="ph-fill ph-star"></i></div>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-800">
                            Student Facilities
                        </h2>
                    </div>

                    <div class="prose prose-lg prose-slate max-w-none text-slate-600 leading-relaxed font-light">
                        <?php echo nl2br(htmlspecialchars($university['student_facility'])); ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>

            <!-- Right Sidebar: CTA -->
            <div class="lg:col-span-1 space-y-8 animate-on-scroll delay-200 sticky top-24 h-max">

                <!-- Call to action block -->
                <div class="bg-dark rounded-3xl p-8 shadow-xl text-center relative overflow-hidden group">
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-multiply group-hover:opacity-20 transition duration-500"></div>
                    <div class="relative z-10 text-white">
                        <i class="ph flex justify-center ph-headset text-5xl text-secondary mb-4 w-full"></i>
                        <h3 class="text-xl font-bold mb-2">Need Guidance?</h3>
                        <p class="text-slate-400 text-sm mb-6 leading-relaxed">Our expert counselors can help you with the admission process and visa applications.</p>
                        <a href="appointment" class="bg-secondary hover:bg-accent text-white px-6 py-3 rounded-full font-bold transition w-full block">
                            Consult an Expert
                        </a>
                    </div>
                </div>

            </div>

        </div>
        
        <div class="text-center mt-12 animate-on-scroll delay-200">
            <a href="universities" class="inline-flex items-center gap-2 text-slate-500 hover:text-secondary font-bold transition bg-white px-8 py-3 rounded-full border border-slate-200 shadow-sm"><i class="ph ph-arrow-left"></i> Back to all Universities</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/components/footer.php'; ?>
