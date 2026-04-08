<?php
// testimonials.php
require_once __DIR__ . '/components/header.php';

$testimonials = [];
try {
    $testimonials = $pdo->query("SELECT * FROM testimonial WHERE status='approved' ORDER BY position ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}
?>

<!-- Page Header -->
<section class="relative bg-dark py-24 lg:py-32 overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute inset-0 opacity-20" style="background-image: url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1600&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-dark to-dark/80"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-primary rounded-full filter blur-[120px] opacity-20"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 animate-on-scroll">Success Stories</h1>
        <div class="flex items-center justify-center gap-2 text-slate-300 text-sm font-medium animate-on-scroll delay-100">
            <a href="index.php" class="hover:text-secondary transition">Home</a>
            <i class="ph ph-caret-right"></i>
            <span class="text-secondary">Testimonials</span>
        </div>
    </div>
</section>

<!-- Google Reviews Widget -->
<section class="py-20 bg-slate-50 min-h-[40vh] border-b border-slate-200">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 animate-on-scroll">
            <h4 class="text-secondary font-bold tracking-wider uppercase text-sm mb-2">Verified Feedback</h4>
            <h2 class="text-3xl font-bold text-dark mb-4">Our <span class="text-secondary">Google Reviews</span></h2>
        </div>
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 max-w-4xl mx-auto animate-on-scroll delay-100">
            <script src="https://elfsightcdn.com/platform.js" async></script>
            <div class="elfsight-app-92d17001-1937-4886-91ed-40e3946b3991" data-elfsight-app-lazy></div>
        </div>
    </div>
</section>

<!-- System Testimonials & Form -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4 lg:flex gap-16">
        
        <!-- Local DB Testimonials List -->
        <div class="lg:w-7/12 mb-16 lg:mb-0">
            <div class="mb-12 animate-on-scroll">
                <h4 class="text-secondary font-bold tracking-wider uppercase text-sm mb-2">Student Voices</h4>
                <h2 class="text-3xl font-bold text-dark">What They Say <span class="text-secondary">About Us</span></h2>
            </div>
            
            <?php if(!empty($testimonials)): ?>
                <div class="space-y-8">
                    <?php foreach($testimonials as $index => $testi): ?>
                        <div class="bg-primary/30 p-8 rounded-3xl border border-primary relative animate-on-scroll" style="animation-delay: <?php echo ($index * 100); ?>ms;">
                            <i class="fa-solid fa-quote-right text-6xl text-white absolute top-6 right-8 opacity-50"></i>
                            <p class="text-slate-600 text-lg italic mb-6 relative z-10 leading-relaxed">"<?php echo htmlspecialchars($testi['message']); ?>"</p>
                            <div class="flex items-center gap-4 border-t border-slate-200/50 pt-6">
                                <?php if($testi['image']): ?>
                                    <img src="uploads/testimonials/<?php echo htmlspecialchars($testi['image']); ?>" class="w-14 h-14 rounded-full object-cover border-2 border-white shadow-sm">
                                <?php else: ?>
                                    <div class="w-14 h-14 rounded-full bg-secondary text-white flex items-center justify-center text-xl font-bold shadow-sm">
                                        <?php echo substr($testi['name'], 0, 1); ?>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <h4 class="font-bold text-dark text-lg"><?php echo htmlspecialchars($testi['name']); ?></h4>
                                    <p class="text-secondary font-semibold text-sm capitalize"><?php echo htmlspecialchars($testi['role']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-left text-slate-500 bg-slate-50 p-8 rounded-2xl border border-slate-100">
                    <p>No testimonials have been published yet. Be the first to share your experience!</p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Leave a Review Form -->
        <div class="lg:w-5/12">
            <div class="bg-dark text-white rounded-3xl p-8 md:p-10 shadow-2xl relative overflow-hidden animate-on-scroll">
                <div class="absolute top-0 right-0 w-64 h-64 bg-secondary rounded-full filter blur-[100px] opacity-20"></div>
                
                <h3 class="text-2xl font-bold mb-2">Share Your Journey!</h3>
                <p class="text-slate-400 text-sm mb-8">Your feedback means the world to us and helps other students make an informed decision.</p>
                
                <?php display_flash_msg(); ?>

                <form action="process_form.php" method="POST" enctype="multipart/form-data" class="space-y-5 relative z-10">
                    <input type="hidden" name="form_type" value="testimonial">
                    <!-- Honeypot -->
                    <input type="text" name="honeypot" class="hidden">
                    
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-slate-300">Your Full Name <span class="text-secondary">*</span></label>
                        <input type="text" name="name" required class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl focus:ring-2 focus:ring-secondary focus:outline-none text-white placeholder-slate-500" placeholder="e.g. John Doe">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-slate-300">You are a <span class="text-secondary">*</span></label>
                        <select name="role" required class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl focus:ring-2 focus:ring-secondary focus:outline-none text-white">
                            <option value="student">Student</option>
                            <option value="parent">Parent</option>
                            <option value="alumni">Alumni</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2 text-slate-300">Profile Photo (Optional)</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl focus:ring-2 focus:ring-secondary focus:outline-none text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-secondary file:text-white hover:file:bg-accent cursor-pointer">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2 text-slate-300">Your Review <span class="text-secondary">*</span></label>
                        <textarea name="message" rows="4" required class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl focus:ring-2 focus:ring-secondary focus:outline-none text-white placeholder-slate-500 resize-none" placeholder="Write your experience with Unilink Global..."></textarea>
                        <p class="text-xs text-slate-400 mt-2"><i class="ph ph-info"></i> Your review will be published after admin approval.</p>
                    </div>

                    <button type="submit" class="w-full bg-secondary hover:bg-accent text-white font-bold py-4 rounded-xl shadow-lg transition transform active:scale-95 flex items-center justify-center gap-2">
                        Submit Review <i class="ph ph-paper-plane-tilt"></i>
                    </button>
                </form>
            </div>
        </div>
        
    </div>
</section>

<?php require_once __DIR__ . '/components/footer.php'; ?>
