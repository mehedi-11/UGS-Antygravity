<?php
// index.php
require_once __DIR__ . '/components/header.php';

// Fetch dynamic data
$hero_slide = $pdo->query("SELECT * FROM hero ORDER BY position ASC LIMIT 1")->fetch();
$services = $pdo->query("SELECT * FROM services ORDER BY position ASC LIMIT 6")->fetchAll();
$blogs = $pdo->query("SELECT b.*, (SELECT COUNT(*) FROM blog_comments c WHERE c.blog_id = b.id) as comment_count FROM blogs b ORDER BY created_at DESC LIMIT 3")->fetchAll();
$achievements = []; // We will check if table exists below
try {
    $achievements = $pdo->query("SELECT * FROM achievements ORDER BY position ASC LIMIT 4")->fetchAll();
} catch (Exception $e) { /* table might be named achievement instead */
    try {
        $achievements = $pdo->query("SELECT * FROM achievement ORDER BY position ASC LIMIT 4")->fetchAll();
    } catch (Exception $e) {}
}

$working_process = [];
try { $working_process = $pdo->query("SELECT * FROM working_process ORDER BY position ASC LIMIT 4")->fetchAll(); } catch(Exception $e){}

$countries = [];
try { $countries = $pdo->query("SELECT * FROM country ORDER BY position ASC LIMIT 4")->fetchAll(); } catch(Exception $e){}

$events = [];
try { $events = $pdo->query("SELECT * FROM event ORDER BY position ASC LIMIT 3")->fetchAll(); } catch(Exception $e){}

$testimonials = [];
try { $testimonials = $pdo->query("SELECT * FROM testimonial WHERE status='approved' ORDER BY position ASC LIMIT 5")->fetchAll(); } catch(Exception $e){}

$db_uni = [];
try { $db_uni = $pdo->query("SELECT * FROM university ORDER BY position ASC LIMIT 4")->fetchAll(); } catch(Exception $e){}

?>

<!-- HERO SECTION -->
<section class="relative bg-white pt-24 pb-20 lg:pt-32 lg:pb-28 overflow-hidden">
    <!-- Smooth background blobs -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary rounded-full filter blur-[120px] opacity-70 translate-x-1/3 -translate-y-1/3"></div>
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-orange-50 rounded-full filter blur-[150px] opacity-60 -translate-x-1/4 translate-y-1/4"></div>

    <div class="container mx-auto px-4 relative z-10 text-center mt-8">
        <div class="max-w-4xl mx-auto">
            <?php if($hero_slide): ?>
                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold leading-tight tracking-tight text-slate-800 mb-6 animate-on-scroll">
                    <?php echo htmlspecialchars($hero_slide['title']); ?>
                </h1>
                <p class="text-lg sm:text-xl text-slate-500 mb-10 font-light max-w-2xl mx-auto leading-relaxed animate-on-scroll delay-100">
                    <?php echo htmlspecialchars($hero_slide['subtitle']); ?>
                </p>
                
                <div class="flex flex-wrap justify-center gap-4 animate-on-scroll delay-200">
                    <?php if($hero_slide['button_text']): ?>
                    <a href="<?php echo htmlspecialchars($hero_slide['button_link'] ?: 'contact.php'); ?>" class="bg-secondary hover:bg-accent px-8 py-3.5 rounded-full font-bold text-white transition transform hover:-translate-y-1 flex items-center gap-2 shadow-lg shadow-secondary/30">
                        <?php echo htmlspecialchars($hero_slide['button_text']); ?> <i class="ph ph-arrow-right"></i>
                    </a>
                    <?php endif; ?>
                    
                    <?php if(!empty($hero_slide['button2_text'])): ?>
                    <a href="<?php echo htmlspecialchars($hero_slide['button2_link'] ?: '#'); ?>" class="bg-white border border-slate-200 hover:border-secondary hover:text-secondary text-slate-600 px-8 py-3.5 rounded-full font-bold transition transform hover:-translate-y-1 flex items-center gap-2 shadow-sm">
                        <?php echo htmlspecialchars($hero_slide['button2_text']); ?> <i class="ph ph-arrow-right"></i>
                    </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <h1 class="text-5xl lg:text-7xl font-extrabold leading-tight text-slate-800 mb-6">Empower Your <span class="text-secondary">Future</span></h1>
                <p class="text-xl text-slate-500 mb-8 font-light">Set up your hero slides in the admin panel.</p>
            <?php endif; ?>
        </div>
        
        <!-- ABOUT COUNTERS STATISTICS IN HERO -->
        <div class="mt-20 pt-10 max-w-5xl mx-auto grid grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="animate-on-scroll delay-200">
                <div class="text-3xl lg:text-4xl font-extrabold text-secondary mb-1 counter" data-target="<?php echo (int)($about['country'] ?? 0); ?>">0</div>
                <div class="text-sm font-bold text-slate-400 tracking-wider">COUNTRIES</div>
            </div>
            <div class="animate-on-scroll delay-300">
                <div class="text-3xl lg:text-4xl font-extrabold text-secondary mb-1 counter" data-target="<?php echo (int)($about['university'] ?? 0); ?>">0</div>
                <div class="text-sm font-bold text-slate-400 tracking-wider">UNIVERSITIES</div>
            </div>
            <div class="animate-on-scroll delay-400">
                <div class="text-3xl lg:text-4xl font-extrabold text-secondary mb-1 counter" data-target="<?php echo (int)($about['student'] ?? 0); ?>">0</div>
                <div class="text-sm font-bold text-slate-400 tracking-wider">STUDENTS GUIDED</div>
            </div>
            <div class="animate-on-scroll delay-500">
                <div class="text-3xl lg:text-4xl font-extrabold text-secondary mb-1 counter" data-target="<?php echo (int)($about['happy_smile'] ?? 0); ?>">0</div>
                <div class="text-sm font-bold text-slate-400 tracking-wider">HAPPY SMILES</div>
            </div>
        </div>
    </div>
</section>

<!-- HOW CAN WE HELP (Services Snippet) -->
<section class="py-20 bg-primary relative">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16 animate-on-scroll">
            <h4 class="text-secondary font-bold tracking-wider uppercase text-sm mb-2">Our Expertise</h4>
            <h2 class="text-3xl md:text-4xl font-bold text-dark">Services We <span class="text-secondary">Provide</span></h2>
            <p class="text-slate-500 mt-4 leading-relaxed">
                Comprehensive support tailored to ensure your international education journey is seamless and successful.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($services as $index => $service): ?>
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition duration-300 border border-slate-100 group animate-on-scroll" style="animation-delay: <?php echo ($index * 100); ?>ms;">
                    
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm group-hover:scale-110 transition duration-300 transform 
                        <?php echo $service['icon_class'] ? 'bg-orange-50 text-secondary' : 'bg-slate-50 text-slate-400';?>">
                        <?php if($service['icon_class']): ?>
                            <i class="<?php echo htmlspecialchars($service['icon_class']); ?>"></i>
                        <?php elseif($service['image']): ?>
                            <img src="uploads/services/<?php echo htmlspecialchars($service['image']); ?>" class="w-full h-full object-cover rounded-2xl">
                        <?php else: ?>
                            <i class="ph ph-briefcase"></i>
                        <?php endif; ?>
                    </div>

                    <h3 class="text-xl font-bold text-dark mb-3 group-hover:text-secondary transition"><?php echo htmlspecialchars($service['title']); ?></h3>
                    <p class="text-slate-500 leading-relaxed text-sm mb-6 line-clamp-3">
                        <?php echo htmlspecialchars($service['details']); ?>
                    </p>
                    <a href="services.php" class="text-secondary font-semibold flex items-center gap-1 hover:gap-2 transition-all">Read More <i class="ph ph-arrow-right"></i></a>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-12 animate-on-scroll">
            <a href="services.php" class="inline-flex items-center gap-2 border-2 border-secondary text-secondary hover:bg-secondary hover:text-white px-8 py-3 rounded-full font-bold transition">
                View All Services <i class="ph ph-arrow-right"></i>
            </a>
        </div>
    </div>
</section>



<!-- WORKING PROCESS -->
<?php if(!empty($working_process)): ?>
<section class="py-20 bg-slate-50 relative overflow-hidden text-center">
    <!-- Curved Dotted Path Decoration (hidden on mobile) -->
    <div class="hidden lg:block absolute top-[60%] left-0 w-full h-[2px] border-t-2 border-dashed border-secondary/30 z-0"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-2xl mx-auto mb-16 animate-on-scroll">
            <h4 class="text-secondary font-bold tracking-wider uppercase text-sm mb-2">How It Works</h4>
            <h2 class="text-3xl md:text-4xl font-bold text-dark">Our Simple <span class="text-secondary">Process</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative">
            <?php foreach($working_process as $index => $wp): ?>
                <div class="relative group animate-on-scroll" style="animation-delay: <?php echo ($index * 100); ?>ms;">
                    <!-- Number Badge -->
                    <div class="w-16 h-16 bg-white border-4 border-slate-50 text-secondary rounded-full flex items-center justify-center font-black text-2xl shadow-lg mx-auto mb-6 relative z-10 group-hover:bg-secondary group-hover:text-white transition">
                        <?php echo $index + 1; ?>
                    </div>
                    <h3 class="text-lg font-bold text-dark mb-3"><?php echo htmlspecialchars($wp['title']); ?></h3>
                    <p class="text-slate-500 text-sm leading-relaxed px-4"><?php echo htmlspecialchars($wp['details']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- TOP DESTINATIONS -->
<?php if(!empty($countries)): ?>
<section class="py-24 bg-white relative">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 animate-on-scroll">
            <div class="max-w-xl">
                <h4 class="text-secondary font-bold tracking-wider uppercase text-sm mb-2">Global Reach</h4>
                <h2 class="text-3xl md:text-4xl font-bold text-dark">Top Study <span class="text-secondary">Destinations</span></h2>
                <p class="text-slate-500 mt-4 leading-relaxed">Choose from the finest universities in the world's most sought-after study destinations.</p>
            </div>
            <a href="destinations.php" class="hidden md:flex items-center gap-2 text-secondary font-bold hover:text-accent transition">View All <i class="ph ph-arrow-right"></i></a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach($countries as $index => $country): ?>
                <a href="universities.php?country=<?php echo urlencode($country['country_name']); ?>" class="block group relative rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition h-72 animate-on-scroll" style="animation-delay: <?php echo ($index * 100); ?>ms;">
                    <?php if($country['country_image']): ?>
                        <img src="uploads/countries/<?php echo htmlspecialchars($country['country_image']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <?php else: ?>
                        <div class="w-full h-full bg-slate-200"></div>
                    <?php endif; ?>
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-dark/90 via-dark/40 to-transparent"></div>
                    <!-- Content -->
                    <div class="absolute bottom-6 left-6 text-white">
                        <h3 class="text-2xl font-bold mb-1"><?php echo htmlspecialchars($country['country_name']); ?></h3>
                        <p class="text-sm text-slate-300 flex items-center gap-1 group-hover:text-secondary font-medium transition">Explore Universities <i class="ph ph-arrow-right"></i></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="mt-8 text-center md:hidden">
            <a href="destinations.php" class="inline-flex items-center gap-2 text-secondary font-bold hover:text-accent transition">View All <i class="ph ph-arrow-right"></i></a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- QUICK ABOUT SECTION -->
<section class="py-20 bg-slate-50">
    <div class="container mx-auto px-4 flex flex-col lg:flex-row items-center gap-16">
        <div class="lg:w-1/2 relative animate-on-scroll">
            <div class="relative z-10 rounded-3xl overflow-hidden shadow-lg border border-slate-100">
                <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800&auto=format&fit=crop" alt="Students studying" class="w-full h-[500px] object-cover">
            </div>
            <!-- Decorative Dots -->
            <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-secondary opacity-10 rounded-full blur-2xl"></div>
            <div class="absolute -top-6 -right-6 w-32 h-32 bg-secondary opacity-10 rounded-full blur-2xl"></div>
        </div>
        
        <div class="lg:w-1/2 animate-on-scroll">
            <h4 class="text-secondary font-bold tracking-wider uppercase text-sm mb-2">About Us</h4>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-6 leading-tight">Your Trusted Guide to <br><span class="text-secondary">International Education</span></h2>
            <p class="text-slate-500 mb-6 leading-relaxed">
                At Unilink Global Solution, we believe that education knows no borders. We are dedicated to helping ambitious students find the perfect university matching their academic background and future career goals.
            </p>
            <ul class="space-y-4 mb-8">
                <li class="flex items-center gap-3 text-slate-700 font-medium"><i class="ph-fill ph-check-circle text-secondary text-xl"></i> Authorized representation of top universities.</li>
                <li class="flex items-center gap-3 text-slate-700 font-medium"><i class="ph-fill ph-check-circle text-secondary text-xl"></i> Transparent and ethical counseling.</li>
                <li class="flex items-center gap-3 text-slate-700 font-medium"><i class="ph-fill ph-check-circle text-secondary text-xl"></i> High visa success rate.</li>
                <li class="flex items-center gap-3 text-slate-700 font-medium"><i class="ph-fill ph-check-circle text-secondary text-xl"></i> End-to-end guidance from admission to landing.</li>
            </ul>
            <a href="about.php" class="bg-white border text-center border-slate-200 text-slate-600 hover:border-secondary hover:text-secondary px-8 py-3.5 rounded-full font-bold shadow-sm transition flex items-center gap-2 inline-flex">
                More About Us <i class="ph ph-arrow-right font-bold"></i>
            </a>
        </div>
    </div>
</section>

<!-- TESTIMONIALS SECTION (DB + Google Reviews) -->
<section class="py-24 bg-primary relative border-y border-slate-100">
    <div class="container mx-auto px-4 text-center max-w-3xl mb-16 animate-on-scroll">
        <h4 class="text-secondary font-bold tracking-wider uppercase text-sm mb-2">Success Stories</h4>
        <h2 class="text-3xl md:text-4xl font-bold text-dark">What Our Students <span class="text-secondary">Say</span></h2>
    </div>

    <div class="container mx-auto px-4 mb-20">
        <!-- Elfsight Google Reviews Widget -->
        <div class="bg-white rounded-3xl p-6 md:p-10 shadow-lg border border-slate-100 animate-on-scroll delay-100">
            <script src="https://elfsightcdn.com/platform.js" async></script>
            <div class="elfsight-app-92d17001-1937-4886-91ed-40e3946b3991" data-elfsight-app-lazy></div>
        </div>
    </div>

    <!-- Optional: Internal DB Testimonials if any exist -->
    <?php if(!empty($testimonials)): ?>
    <div class="container mx-auto px-4 animate-on-scroll delay-200">
        <div class="swiper testimonialSwiper pb-12">
            <div class="swiper-wrapper">
                <?php foreach($testimonials as $testi): ?>
                <div class="swiper-slide h-auto">
                    <div class="bg-white p-8 rounded-2xl border border-slate-100 h-full flex flex-col items-center text-center shadow-sm relative">
                        <i class="fa-solid fa-quote-left text-4xl text-slate-100 absolute top-6 left-6"></i>
                        <p class="text-slate-600 italic mb-8 relative z-10">"<?php echo htmlspecialchars($testi['message']); ?>"</p>
                        <div class="mt-auto">
                            <?php if($testi['image']): ?>
                                <img src="uploads/testimonials/<?php echo htmlspecialchars($testi['image']); ?>" class="w-16 h-16 rounded-full object-cover mx-auto mb-3 border-2 border-primary">
                            <?php else: ?>
                                <div class="w-16 h-16 rounded-full bg-secondary text-white flex items-center justify-center text-2xl mx-auto mb-3 font-bold"><?php echo substr($testi['name'], 0, 1); ?></div>
                            <?php endif; ?>
                            <h4 class="font-bold text-dark text-lg"><?php echo htmlspecialchars($testi['name']); ?></h4>
                            <p class="text-secondary text-sm font-semibold capitalize"><?php echo htmlspecialchars($testi['role']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <?php endif; ?>
</section>

<!-- UPCOMING EVENTS -->
<?php if(!empty($events)): ?>
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 animate-on-scroll">
            <div class="max-w-2xl">
                <h4 class="text-secondary font-bold tracking-wider uppercase text-sm mb-2">Upcoming Activities</h4>
                <h2 class="text-3xl md:text-4xl font-bold text-dark">Meet Us at <span class="text-secondary">Events</span></h2>
            </div>
            <a href="events.php" class="hidden md:flex items-center gap-2 text-secondary font-bold hover:text-accent transition">All Events <i class="ph ph-arrow-right"></i></a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <?php foreach($events as $index => $event): ?>
                <div class="flex flex-col bg-primary rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition group animate-on-scroll" style="animation-delay: <?php echo ($index * 100); ?>ms;">
                    <div class="h-48 overflow-hidden relative">
                        <?php if($event['event_image']): ?>
                            <img src="uploads/events/<?php echo htmlspecialchars($event['event_image']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <?php else: ?>
                            <div class="w-full h-full bg-slate-200"></div>
                        <?php endif; ?>
                        <!-- Event Date Badge -->
                        <div class="absolute top-4 left-4 bg-secondary text-white font-bold py-2 px-4 rounded-xl shadow-md text-center">
                            <span class="block text-2xl"><?php echo date('d', strtotime($event['date_time'])); ?></span>
                            <span class="block text-xs uppercase tracking-wider"><?php echo date('M', strtotime($event['date_time'])); ?></span>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-dark mb-3 leading-snug group-hover:text-secondary transition line-clamp-2"><?php echo htmlspecialchars($event['title']); ?></h3>
                        <div class="flex items-center gap-2 text-slate-500 text-sm mb-2">
                            <i class="ph ph-map-pin text-secondary"></i> <?php echo htmlspecialchars($event['location'] ?? 'Virtual'); ?>
                        </div>
                        <div class="flex items-center gap-2 text-slate-500 text-sm mb-6">
                            <i class="ph ph-clock text-secondary"></i> <?php echo date('h:i A', strtotime($event['date_time'])); ?>
                        </div>
                        <a href="events.php?id=<?php echo $event['id']; ?>" class="mt-auto border-t border-slate-200 pt-4 text-secondary font-bold hover:text-accent transition flex items-center gap-1"><i class="ph ph-info"></i> Event Details</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- LATEST BLOGS / NEWS -->
<section class="py-20 bg-primary border-t border-slate-100">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 animate-on-scroll">
            <div class="max-w-2xl">
                <h4 class="text-secondary font-bold tracking-wider uppercase text-sm mb-2">News & Resources</h4>
                <h2 class="text-3xl md:text-4xl font-bold text-dark">Latest Insights & <span class="text-secondary">Stories</span></h2>
            </div>
            <a href="blog.php" class="hidden md:flex items-center gap-2 text-secondary font-bold hover:text-accent transition">
                Read All Articles <i class="ph ph-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($blogs as $index => $blog): ?>
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-slate-100 group animate-on-scroll" style="animation-delay: <?php echo ($index * 100); ?>ms;">
                    <div class="h-56 overflow-hidden relative">
                        <?php if($blog['image']): ?>
                            <img src="uploads/blogs/<?php echo htmlspecialchars($blog['image']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <?php else: ?>
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300"><i class="ph ph-image text-4xl"></i></div>
                        <?php endif; ?>
                        <!-- Date Badge -->
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur text-secondary font-bold py-1 px-3 rounded-lg shadow-sm text-sm text-center">
                            <span class="block text-lg"><?php echo date('d', strtotime($blog['created_at'])); ?></span>
                            <span class="block text-xs uppercase"><?php echo date('M', strtotime($blog['created_at'])); ?></span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex gap-4 mb-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                            <span><i class="ph ph-user text-secondary"></i> Admin</span>
                            <span><i class="ph ph-folder text-secondary"></i> Study Guides</span>
                        </div>
                        <h3 class="text-xl font-bold text-dark mb-3 leading-snug group-hover:text-secondary transition line-clamp-2">
                            <a href="blog-details.php?id=<?php echo $blog['id']; ?>"><?php echo htmlspecialchars($blog['title']); ?></a>
                        </h3>
                        <!-- Strip HTML tags to show plain text preview -->
                        <p class="text-slate-500 text-sm mb-6 line-clamp-3">
                            <?php echo htmlspecialchars(strip_tags($blog['content'])); ?>
                        </p>
                        <div class="mt-4 border-t border-slate-100 pt-4 flex items-center justify-between">
                            <div class="flex items-center gap-3 text-slate-500 text-xs font-semibold">
                                <span class="flex items-center gap-1" title="Likes"><i class="ph-fill ph-heart text-secondary"></i> <?php echo $blog['likes']; ?></span>
                                <span class="flex items-center gap-1" title="Comments"><i class="ph-fill ph-chat-circle text-primary"></i> <?php echo $blog['comment_count']; ?></span>
                                <span class="flex items-center gap-1" title="Shares"><i class="ph-fill ph-share-network text-slate-400"></i> <?php echo $blog['shares']; ?></span>
                            </div>
                            <a href="blog-details.php?id=<?php echo $blog['id']; ?>" class="inline-block border border-slate-200 text-slate-600 hover:border-secondary hover:text-white hover:bg-secondary px-4 py-1.5 rounded-full text-xs font-semibold transition">Read Article</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="mt-8 text-center md:hidden">
            <a href="blog.php" class="inline-flex items-center gap-2 text-secondary font-bold hover:text-accent transition">
                Read All Articles <i class="ph ph-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 relative overflow-hidden bg-secondary">
    <!-- Decoration -->
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-white opacity-10 rounded-full blur-3xl"></div>
    
    <div class="container mx-auto px-4 text-center relative z-10 animate-on-scroll">
        <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Ready to Start Your Journey?</h2>
        <p class="text-white/80 text-lg max-w-2xl mx-auto mb-10">Get in touch with our expert counselors today and take the first step towards securing your admission at a top global university.</p>
        <a href="contact.php" class="bg-white text-secondary hover:bg-slate-50 px-10 py-4 rounded-full font-bold text-lg shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1 inline-flex items-center gap-2">
            Book a Free Consultation <i class="ph ph-calendar-check"></i>
        </a>
    </div>
</section>

<!-- Initialize Swiper -->
<script>
    document.addEventListener("DOMContentLoaded", () => {

        // Testimonial Swiper
        new Swiper(".testimonialSwiper", {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 30,
            autoplay: {
                delay: 5000,
            },
            breakpoints: {
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 }
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    });
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
