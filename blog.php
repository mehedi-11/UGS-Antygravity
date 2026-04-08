<?php
// blog.php
require_once __DIR__ . '/components/header.php';

$blogs = [];
try {
    $sql = "SELECT b.*, (SELECT COUNT(*) FROM blog_comments c WHERE c.blog_id = b.id) as comment_count 
            FROM blogs b ORDER BY created_at DESC";
    $blogs = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}
?>

<!-- Page Header -->
<section class="relative bg-dark py-24 lg:py-32 overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute inset-0 opacity-20" style="background-image: url('https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=1600&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-dark to-dark/80"></div>
    <div class="absolute -bottom-24 left-1/2 -translate-x-1/2 w-96 h-96 bg-secondary/30 rounded-full filter blur-[150px]"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 animate-on-scroll">Our Blog & News</h1>
        <p class="text-lg text-slate-300 max-w-2xl mx-auto mb-6 animate-on-scroll delay-100">Latest updates, study guides, and success stories from our global education experts.</p>
        <div class="flex items-center justify-center gap-2 text-slate-400 text-sm font-medium animate-on-scroll delay-200">
            <a href="index.php" class="hover:text-secondary transition">Home</a>
            <i class="ph ph-caret-right"></i>
            <span class="text-secondary">Blog</span>
        </div>
    </div>
</section>

<!-- Blog Grid -->
<section class="py-24 bg-slate-50 min-h-[60vh]">
    <div class="container mx-auto px-4">
        <?php if(!empty($blogs)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach($blogs as $index => $blog): ?>
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition duration-500 border border-slate-100 group flex flex-col animate-on-scroll" style="animation-delay: <?php echo ($index * 50); ?>ms;">
                        <a href="blog-details.php?id=<?php echo $blog['id']; ?>" class="block h-56 overflow-hidden relative">
                            <?php if($blog['image']): ?>
                                <img src="uploads/blogs/<?php echo htmlspecialchars($blog['image']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-in-out">
                            <?php else: ?>
                                <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-300"><i class="ph ph-image text-5xl"></i></div>
                            <?php endif; ?>
                            
                            <!-- Date Badge -->
                            <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm text-secondary font-bold py-1 px-3 rounded-xl shadow-sm text-center">
                                <span class="block text-xl"><?php echo date('d', strtotime($blog['created_at'])); ?></span>
                                <span class="block text-xs uppercase tracking-wider"><?php echo date('M', strtotime($blog['created_at'])); ?></span>
                            </div>
                        </a>
                        
                        <div class="p-8 flex flex-col flex-grow">
                            <div class="flex gap-4 mb-4 text-xs font-bold text-slate-400 uppercase tracking-widest">
                                <span class="flex items-center gap-1"><i class="ph ph-user text-secondary text-base"></i> Admin</span>
                            </div>
                            
                            <h3 class="text-2xl font-bold text-dark mb-4 leading-snug group-hover:text-secondary transition line-clamp-2">
                                <a href="blog-details.php?id=<?php echo $blog['id']; ?>"><?php echo htmlspecialchars($blog['title']); ?></a>
                            </h3>
                            
                            <p class="text-slate-500 text-sm leading-relaxed mb-6 flex-grow line-clamp-3">
                                <?php echo htmlspecialchars(strip_tags($blog['content'])); ?>
                            </p>
                            
                            <div class="mt-auto border-t border-slate-100 pt-6 flex items-center justify-between">
                                <div class="flex items-center gap-4 text-slate-500 text-sm font-semibold">
                                    <span class="flex items-center gap-1" title="Likes"><i class="ph-fill ph-heart text-secondary"></i> <?php echo $blog['likes']; ?></span>
                                    <span class="flex items-center gap-1" title="Comments"><i class="ph-fill ph-chat-circle text-primary"></i> <?php echo $blog['comment_count']; ?></span>
                                    <span class="flex items-center gap-1" title="Shares"><i class="ph-fill ph-share-network text-slate-400"></i> <?php echo $blog['shares']; ?></span>
                                </div>
                                <a href="blog-details.php?id=<?php echo $blog['id']; ?>" class="w-10 h-10 rounded-full bg-slate-50 hover:bg-secondary text-slate-600 hover:text-white flex items-center justify-center transition" title="Read Article">
                                    <i class="ph ph-arrow-right text-lg"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-slate-200 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-400 text-4xl">
                    <i class="ph ph-article"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-600 mb-2">No Articles Yet</h2>
                <p class="text-slate-500">Check back later for interesting reads and updates.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/components/footer.php'; ?>
