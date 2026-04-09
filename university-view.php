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
    redirect('universities.php');
}
?>

<!-- University Hero Header -->
<section class="relative bg-slate-50 pt-24 pb-16 lg:pt-32 lg:pb-24 overflow-hidden border-b border-slate-100">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-multiply"></div>
    <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-primary rounded-full filter blur-[150px] opacity-50 translate-x-1/3 -translate-y-1/3"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col lg:flex-row gap-12 items-center">
            
            <!-- Logo & Title -->
            <div class="lg:w-2/3">
                <div class="flex items-center gap-2 text-slate-400 text-sm font-bold uppercase tracking-widest mb-6 animate-on-scroll">
                    <a href="index.php" class="hover:text-secondary transition text-slate-500">Home</a>
                    <i class="ph ph-caret-right"></i>
                    <a href="universities.php" class="hover:text-secondary transition text-slate-500">Universities</a>
                    <i class="ph ph-caret-right"></i>
                    <span class="text-secondary"><?php echo htmlspecialchars($university['university_name']); ?></span>
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-800 mb-4 animate-on-scroll delay-100 tracking-tight">
                    <?php echo htmlspecialchars($university['university_name']); ?>
                </h1>
                
                <p class="text-lg font-bold text-secondary uppercase tracking-widest mb-8 flex items-center gap-2 animate-on-scroll delay-200">
                    <i class="ph ph-map-pin"></i> <?php echo htmlspecialchars($university['country_name']); ?>
                </p>
                
                <div class="flex flex-wrap gap-4 animate-on-scroll delay-300">
                    <a href="appointment.php" class="bg-secondary hover:bg-accent text-white px-8 py-3.5 rounded-full font-bold shadow-lg shadow-orange-500/30 transition transform hover:-translate-y-1 flex items-center gap-2">
                        Apply Now <i class="ph ph-arrow-right"></i>
                    </a>
                    <a href="contact.php" class="bg-white border border-slate-200 hover:border-secondary hover:text-secondary text-slate-600 px-8 py-3.5 rounded-full font-bold shadow-sm transition transform hover:-translate-y-1 flex items-center gap-2">
                        Ask a Question <i class="ph ph-question"></i>
                    </a>
                </div>
            </div>
            
            <!-- Logo Frame -->
            <div class="lg:w-1/3 w-full animate-on-scroll delay-200 flex justify-center lg:justify-end">
                <div class="w-64 h-64 bg-white rounded-[2rem] shadow-xl border border-slate-100 flex items-center justify-center p-8 relative group">
                    <?php if($university['image']): ?>
                        <img src="uploads/universities/<?php echo htmlspecialchars($university['image']); ?>" class="w-full h-full object-contain group-hover:scale-110 transition duration-500">
                    <?php else: ?>
                        <i class="ph ph-graduation-cap text-8xl text-slate-300"></i>
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Details Section -->
<section class="py-20 bg-white min-h-[50vh]">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="bg-slate-50 rounded-3xl p-8 sm:p-12 shadow-sm border border-slate-100 relative overflow-hidden animate-on-scroll">
            
            <!-- Quick Facts Banner -->
            <div class="absolute top-0 right-0 bg-secondary text-white font-bold py-2 px-6 rounded-bl-2xl shadow-sm text-sm uppercase tracking-wider backdrop-blur">
                Partner Institution
            </div>

            <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-6 border-b border-slate-200 pb-4">
                About <?php echo htmlspecialchars($university['university_name']); ?>
            </h2>

            <div class="prose prose-lg prose-slate max-w-none text-slate-600 leading-relaxed mb-10">
                <?php echo nl2br(htmlspecialchars($university['details'])); ?>
            </div>

            <!-- Call to action block inside detail -->
            <div class="bg-white border border-slate-100 rounded-2xl p-8 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-sm">
                <div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Interested in applying?</h3>
                    <p class="text-slate-500 text-sm">Our expert counselors can help you with the admission process and visa applications.</p>
                </div>
                <a href="appointment.php" class="bg-slate-800 hover:bg-slate-900 text-white px-6 py-3 rounded-full font-bold transition flex-shrink-0 flex items-center gap-2">
                    Consult an Expert <i class="ph ph-chat-circle-dots"></i>
                </a>
            </div>

        </div>
        
        <div class="text-center mt-10">
            <a href="universities.php" class="inline-flex items-center gap-2 text-slate-500 hover:text-secondary font-bold transition"><i class="ph ph-arrow-left"></i> Back to all Universities</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/components/footer.php'; ?>
