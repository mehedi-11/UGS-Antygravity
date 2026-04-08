<?php
// gallery.php
require_once __DIR__ . '/components/header.php';

$gallery = [];
try {
    $gallery = $pdo->query("SELECT * FROM gallery ORDER BY position ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}
?>

<!-- Page Header -->
<section class="relative bg-dark py-24 lg:py-32 overflow-hidden">
    <div class="absolute inset-0 opacity-20" style="background-image: url('https://images.unsplash.com/photo-1523580494112-071dba92a5d3?q=80&w=1600&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-dark to-dark/80"></div>
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary rounded-full filter blur-[150px] opacity-20"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 animate-on-scroll">Our Gallery</h1>
        <p class="text-lg text-slate-300 max-w-2xl mx-auto mb-6 animate-on-scroll delay-100">Glimpses of our successful students, partner university seminars, and campus tours.</p>
        <div class="flex items-center justify-center gap-2 text-slate-400 text-sm font-medium animate-on-scroll delay-200">
            <a href="index.php" class="hover:text-secondary transition">Home</a>
            <i class="ph ph-caret-right"></i>
            <span class="text-secondary">Gallery</span>
        </div>
    </div>
</section>

<!-- Main Gallery Section -->
<section class="py-24 bg-slate-50 min-h-[60vh]">
    <div class="container mx-auto px-4">
        
        <?php if(!empty($gallery)): ?>
            <!-- Masonry-style Grid using standard cols -->
            <div class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-6 space-y-6">
                <?php foreach($gallery as $index => $item): ?>
                    <div class="relative group rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition duration-500 break-inside-avoid animate-on-scroll" style="animation-delay: <?php echo ($index * 50); ?>ms;">
                        <?php if($item['image_1']): ?>
                            <img src="uploads/gallery/<?php echo htmlspecialchars($item['image_1']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="w-full object-cover group-hover:scale-105 transition duration-700 ease-in-out">
                        <?php else: ?>
                            <div class="w-full h-64 bg-slate-200 flex items-center justify-center text-slate-300">
                                <i class="ph ph-image text-5xl"></i>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Hover Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-dark/90 via-dark/40 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-6 pointer-events-none">
                            <h3 class="text-white font-bold text-lg mb-1 translate-y-4 group-hover:translate-y-0 transition duration-300"><?php echo htmlspecialchars($item['title']); ?></h3>
                            <?php if($item['details']): ?>
                                <p class="text-slate-300 text-sm line-clamp-2 translate-y-4 group-hover:translate-y-0 transition duration-300 delay-75"><?php echo htmlspecialchars($item['details']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-slate-200 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-400 text-4xl">
                    <i class="ph ph-images"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-600 mb-2">Gallery is Empty</h2>
                <p class="text-slate-500">Photos will be uploaded soon. Please check back later!</p>
            </div>
        <?php endif; ?>
        
    </div>
</section>

<?php require_once __DIR__ . '/components/footer.php'; ?>
