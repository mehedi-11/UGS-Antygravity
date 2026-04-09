<?php
// blog-details.php
require_once __DIR__ . '/components/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if(!$id) {
    redirect('blog.php');
}

try {
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
    $stmt->execute([$id]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Database error.");
}

if(!$blog) {
    set_flash_msg('error', 'Blog post not found.');
    redirect('blog.php');
}

// Fetch some recent blogs for sidebar
$recent_blogs = [];
try {
    $recent_blogs = $pdo->query("SELECT id, title, image, created_at FROM blogs WHERE id != $id ORDER BY created_at DESC LIMIT 4")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

// Fetch comments
$comments = [];
try {
    $comments = $pdo->query("SELECT * FROM blog_comments WHERE blog_id = $id ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

?>

<!-- Page Header -->
<section class="relative bg-slate-50 pt-24 pb-16 lg:pt-32 lg:pb-24 overflow-hidden border-b border-slate-100">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-multiply"></div>
    <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-primary rounded-full filter blur-[150px] opacity-50 translate-x-1/3 -translate-y-1/3"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center mt-8">
            <div class="flex items-center justify-center gap-2 text-slate-400 text-sm font-bold uppercase tracking-widest mb-6 animate-on-scroll">
                <a href="index.php" class="hover:text-secondary transition text-slate-500">Home</a>
                <i class="ph ph-caret-right"></i>
                <a href="blog.php" class="hover:text-secondary transition text-slate-500">Blog</a>
                <i class="ph ph-caret-right"></i>
                <span class="text-secondary tracking-widest">Article</span>
            </div>
            
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-800 mb-6 leading-tight max-w-4xl tracking-tight animate-on-scroll delay-100">
                <?php echo htmlspecialchars($blog['title']); ?>
            </h1>
            
            <div class="flex items-center justify-center gap-4 text-slate-500 text-sm font-bold uppercase tracking-widest animate-on-scroll delay-200">
                <span class="flex items-center gap-1"><i class="ph ph-calendar-blank text-secondary"></i> <?php echo date('M d, Y', strtotime($blog['created_at'])); ?></span>
                <span class="w-1.5 h-1.5 bg-slate-200 rounded-full"></span>
                <span class="flex items-center gap-1"><i class="ph ph-user text-secondary"></i> Admin</span>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-slate-50 min-h-[60vh]">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-12 max-w-6xl mx-auto">
            
            <!-- Main Content -->
            <div class="lg:w-2/3">
                <article class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-slate-100">
                    <?php if($blog['image']): ?>
                        <div class="rounded-2xl overflow-hidden mb-10 shadow-sm">
                            <img src="uploads/blogs/<?php echo htmlspecialchars($blog['image']); ?>" alt="Blog Image" class="w-full h-auto object-cover max-h-[500px]">
                        </div>
                    <?php endif; ?>
                    
                    <div class="prose prose-lg max-w-none text-slate-600 prose-headings:text-dark prose-headings:font-bold prose-a:text-secondary hover:prose-a:text-accent">
                        <!-- Output raw HTML from Quill JS editor -->
                        <?php echo $blog['content']; ?>
                    </div>
                    
                    <!-- Interactions: Like & Share -->
                    <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="flex items-center gap-4">
                            <button onclick="handleBlogAction('like', <?php echo $blog['id']; ?>)" id="likeBtn" class="flex items-center gap-2 font-bold text-slate-500 hover:text-secondary transition bg-slate-50 hover:bg-orange-50 px-4 py-2 rounded-full">
                                <i class="ph-fill ph-heart text-xl text-slate-400" id="likeIcon"></i> <span id="likeCount"><?php echo $blog['likes']; ?></span> Likes
                            </button>
                            <span class="text-slate-400">|</span>
                            <div class="flex items-center gap-2 font-bold text-slate-500 hover:text-primary transition bg-slate-50 hover:bg-blue-50 px-4 py-2 rounded-full cursor-default">
                                <i class="ph-fill ph-chat-circle text-xl text-slate-400"></i> <?php echo count($comments); ?> Comments
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-dark text-sm">Share:</span>
                            <button onclick="handleBlogAction('share', <?php echo $blog['id']; ?>)" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 hover:text-dark transition" title="Copy Link">
                                <i class="ph ph-link"></i>
                            </button>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank" onclick="handleBlogAction('share', <?php echo $blog['id']; ?>, false)" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-[#1877F2] hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($blog['title']); ?>" target="_blank" onclick="handleBlogAction('share', <?php echo $blog['id']; ?>, false)" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-[#1DA1F2] hover:text-white transition"><i class="fab fa-twitter"></i></a>
                            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($blog['title'] . ' - ' . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank" onclick="handleBlogAction('share', <?php echo $blog['id']; ?>, false)" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-[#25D366] hover:text-white transition"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </article>

                <!-- Comments Section -->
                <div class="mt-8 bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-slate-100">
                    <h3 class="text-2xl font-bold text-dark mb-8">Comments (<?php echo count($comments); ?>)</h3>
                    
                    <!-- Comment Form -->
                    <form id="commentForm" class="mb-10">
                        <div class="grid grid-cols-1 gap-4 mb-4">
                            <input type="text" id="commentName" required placeholder="Your Name *" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary outline-none transition">
                            <textarea id="commentText" required rows="3" placeholder="Write your comment here... *" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary outline-none transition resize-none"></textarea>
                        </div>
                        <button type="button" onclick="submitComment(<?php echo $blog['id']; ?>)" class="bg-dark hover:bg-secondary text-white font-bold px-8 py-3 rounded-full transition shadow-sm">
                            Post Comment <i class="ph ph-paper-plane-right"></i>
                        </button>
                        <p id="commentFeedback" class="text-sm mt-3 hidden"></p>
                    </form>

                    <!-- Comments List -->
                    <div class="space-y-6">
                        <?php if(!empty($comments)): ?>
                            <?php foreach($comments as $comment): ?>
                                <div class="flex gap-4 p-5 bg-slate-50 rounded-2xl">
                                    <div class="w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold flex-shrink-0 text-xl">
                                        <?php echo substr($comment['name'], 0, 1); ?>
                                    </div>
                                    <div>
                                        <div class="flex items-baseline gap-3 mb-1">
                                            <h4 class="font-bold text-dark"><?php echo htmlspecialchars($comment['name']); ?></h4>
                                            <span class="text-xs text-slate-400 font-semibold"><?php echo date('M d, Y', strtotime($comment['created_at'])); ?></span>
                                        </div>
                                        <p class="text-slate-600 text-sm leading-relaxed"><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-6 text-slate-400">
                                <i class="ph ph-chat-teardrop mb-2 text-4xl"></i>
                                <p>Be the first to share your thoughts!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="lg:w-1/3">
                <div class="sticky top-24 space-y-8">
                    
                    <!-- Recent Posts -->
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
                        <h3 class="text-xl font-bold text-dark mb-6 pb-4 border-b border-slate-100">Recent Articles</h3>
                        <?php if(!empty($recent_blogs)): ?>
                            <div class="space-y-6">
                                <?php foreach($recent_blogs as $rb): ?>
                                    <a href="blog-details.php?id=<?php echo $rb['id']; ?>" class="flex gap-4 group">
                                        <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0 bg-slate-100">
                                            <?php if($rb['image']): ?>
                                                <img src="uploads/blogs/<?php echo htmlspecialchars($rb['image']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h4 class="text-dark font-bold text-sm leading-snug group-hover:text-secondary transition line-clamp-2 mb-2"><?php echo htmlspecialchars($rb['title']); ?></h4>
                                            <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider"><i class="ph ph-calendar-blank"></i> <?php echo date('M d, Y', strtotime($rb['created_at'])); ?></span>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-slate-500 text-sm">No other articles available.</p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Appointment CTA -->
                    <div class="bg-dark text-white rounded-3xl p-8 shadow-sm relative overflow-hidden text-center">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-secondary rounded-full filter blur-[50px] opacity-30"></div>
                        <h3 class="text-2xl font-bold mb-4">Start Your Journey Today</h3>
                        <p class="text-slate-400 text-sm mb-6">Talk to our experts for a free assessment profile evaluation.</p>
                        <a href="appointment.php" class="block w-full bg-secondary hover:bg-accent py-3 rounded-full font-bold transition">Book a Consultation</a>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Interaction Scripts -->
<script>
    // Utility for like/share
    function handleBlogAction(action, id, copyMode = true) {
        const formData = new FormData();
        formData.append('action', action);
        formData.append('id', id);

        fetch('blog_action.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success && action === 'like') {
                document.getElementById('likeCount').innerText = data.new_count;
                document.getElementById('likeIcon').classList.add('text-secondary');
                document.getElementById('likeIcon').classList.remove('text-slate-400');
            }
        });

        // If it's a native share click event and we want to copy the link
        if(action === 'share' && copyMode) {
            navigator.clipboard.writeText(window.location.href);
            alert("Link copied to clipboard!");
        }
    }

    // Utility for commenting
    function submitComment(id) {
        const name = document.getElementById('commentName').value.trim();
        const comment = document.getElementById('commentText').value.trim();
        const fb = document.getElementById('commentFeedback');

        if(!name || !comment) {
            fb.innerText = "Check name & comment are filled.";
            fb.className = "text-sm mt-3 text-red-500 block";
            return;
        }

        const formData = new FormData();
        formData.append('action', 'comment');
        formData.append('id', id);
        formData.append('name', name);
        formData.append('comment', comment);

        fetch('blog_action.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                fb.innerText = "Comment posted successfully! Reloading...";
                fb.className = "text-sm mt-3 text-green-600 block";
                setTimeout(() => window.location.reload(), 800);
            } else {
                fb.innerText = "Failed: " + data.message;
                fb.className = "text-sm mt-3 text-red-500 block";
            }
        });
    }

    // Check localStorage or cookie if liked
    window.onload = function() {
        if(document.cookie.includes('liked_blog_<?php echo $blog['id']; ?>=')) {
            document.getElementById('likeIcon').classList.add('text-secondary');
            document.getElementById('likeIcon').classList.remove('text-slate-400');
            document.getElementById('likeBtn').disabled = true;
        }
    }
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
