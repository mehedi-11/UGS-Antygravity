<?php
// team.php
require_once __DIR__ . '/components/header.php';

$team_members = [];
try {
    $team_members = $pdo->query("SELECT * FROM team_members ORDER BY position ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}
?>

<!-- Page Header -->
<section class="relative bg-dark py-24 lg:py-32 overflow-hidden">
    <div class="absolute inset-0 opacity-20" style="background-image: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1600&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-dark to-dark/80"></div>
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-3/4 h-32 bg-secondary/20 blur-[100px]"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 animate-on-scroll">Meet Our Experts</h1>
        <div class="flex items-center justify-center gap-2 text-slate-300 text-sm font-medium animate-on-scroll delay-100">
            <a href="index.php" class="hover:text-secondary transition">Home</a>
            <i class="ph ph-caret-right"></i>
            <span class="text-secondary">Our Team</span>
        </div>
    </div>
</section>

<!-- Team Grid -->
<section class="py-24 bg-slate-50 min-h-[50vh]">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-16 animate-on-scroll">
            <h4 class="text-secondary font-bold tracking-wider uppercase text-sm mb-2">Dedicated Professionals</h4>
            <h2 class="text-3xl md:text-4xl font-bold text-dark mb-4">Guidance from <span class="text-secondary">Experience</span></h2>
            <p class="text-slate-500">Our counselors are internationally trained professionals dedicated to your academic success.</p>
        </div>

        <?php if(!empty($team_members)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach($team_members as $index => $member): ?>
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition duration-500 group animate-on-scroll" style="animation-delay: <?php echo ($index * 100); ?>ms;">
                        <div class="h-72 overflow-hidden relative">
                            <?php if($member['image']): ?>
                                <img src="uploads/team/<?php echo htmlspecialchars($member['image']); ?>" alt="<?php echo htmlspecialchars($member['name']); ?>" class="w-full h-full object-cover object-top group-hover:scale-110 transition duration-700">
                            <?php else: ?>
                                <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400 text-5xl">
                                    <i class="ph ph-user"></i>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Gradient Overlay & Socials -->
                            <div class="absolute inset-0 bg-gradient-to-t from-dark/90 via-dark/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-6">
                                <div class="flex items-center gap-3 translate-y-4 group-hover:translate-y-0 transition duration-300">
                                    <?php if($member['social_media_1']): ?>
                                        <a href="<?php echo htmlspecialchars($member['social_media_1']); ?>" target="_blank" class="w-10 h-10 rounded-full bg-secondary text-white flex items-center justify-center hover:bg-white hover:text-secondary transition"><i class="fab fa-facebook-f"></i></a>
                                    <?php endif; ?>
                                    <?php if($member['social_media_2']): ?>
                                        <a href="<?php echo htmlspecialchars($member['social_media_2']); ?>" target="_blank" class="w-10 h-10 rounded-full bg-secondary text-white flex items-center justify-center hover:bg-white hover:text-secondary transition"><i class="fab fa-linkedin-in"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 text-center border-t border-slate-50 relative z-10 bg-white">
                            <h3 class="text-xl font-bold text-dark mb-1 group-hover:text-secondary transition"><?php echo htmlspecialchars($member['name']); ?></h3>
                            <p class="text-secondary font-semibold text-sm uppercase tracking-wider mb-3"><?php echo htmlspecialchars($member['designation']); ?></p>
                            <p class="text-slate-500 text-sm line-clamp-3"><?php echo htmlspecialchars($member['details']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-20 text-slate-400">
                <i class="ph-light ph-users text-6xl mb-4"></i>
                <p>Team data is currently being updated.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/components/footer.php'; ?>
