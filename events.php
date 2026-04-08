<?php
// events.php
require_once __DIR__ . '/components/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // ---------------------------------------------------------
    // RENDER EVENT DETAILS
    // ---------------------------------------------------------
    try {
        $stmt = $pdo->prepare("SELECT * FROM event WHERE id = ?");
        $stmt->execute([$id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) { $event = false; }

    if(!$event) {
        set_flash_msg('error', 'Event not found.');
        redirect('events.php');
    }
    ?>
    <!-- Page Header -->
    <section class="relative bg-dark py-24 overflow-hidden">
        <div class="absolute inset-0 opacity-30" style="background-image: url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1600&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-dark to-dark/40"></div>
        <div class="container mx-auto px-4 relative z-10 text-center mt-12">
            <span class="inline-block bg-secondary text-white px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-4">Event Details</span>
            <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-6 leading-tight max-w-4xl mx-auto"><?php echo htmlspecialchars($event['title']); ?></h1>
        </div>
    </section>

    <section class="py-20 bg-slate-50 min-h-[60vh]">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="bg-white rounded-3xl p-6 sm:p-12 shadow-sm border border-slate-100 relative overflow-hidden">
                <!-- Date Badge -->
                <div class="absolute top-0 right-10 bg-secondary text-white text-center py-3 px-6 rounded-b-2xl shadow-lg">
                    <span class="block text-3xl font-bold"><?php echo date('d', strtotime($event['date_time'])); ?></span>
                    <span class="block text-sm uppercase tracking-widest"><?php echo date('M', strtotime($event['date_time'])); ?></span>
                </div>
                
                <?php if($event['event_image']): ?>
                    <img src="uploads/events/<?php echo htmlspecialchars($event['event_image']); ?>" class="w-full h-80 object-cover rounded-2xl mb-10 shadow-sm mt-8">
                <?php endif; ?>
                
                <div class="flex flex-col sm:flex-row gap-6 mb-10 pb-8 border-b border-slate-100 text-slate-600">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xl"><i class="ph ph-clock"></i></div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Time</p>
                            <p class="font-semibold"><?php echo date('h:i A - l', strtotime($event['date_time'])); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-secondary/10 text-secondary flex items-center justify-center text-xl"><i class="ph ph-map-pin"></i></div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Location</p>
                            <p class="font-semibold"><?php echo htmlspecialchars($event['location'] ?? 'Virtual / Online'); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="prose prose-lg max-w-none text-slate-600 leading-relaxed mb-12">
                    <?php echo nl2br(htmlspecialchars($event['details'])); ?>
                </div>
                
                <div class="bg-dark text-white rounded-2xl p-8 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-secondary rounded-full filter blur-[50px] opacity-20"></div>
                    <div>
                        <h3 class="text-2xl font-bold mb-2">Book Your Spot Now</h3>
                        <p class="text-slate-400 text-sm">Don't miss this opportunity to connect with our experts.</p>
                    </div>
                    <a href="appointment.php" class="bg-secondary hover:bg-accent px-8 py-3 rounded-full font-bold transition flex-shrink-0 relative z-10 flex items-center gap-2">Register <i class="ph ph-arrow-right"></i></a>
                </div>
            </div>
            <div class="text-center mt-10">
                <a href="events.php" class="inline-flex items-center gap-2 text-slate-500 hover:text-dark font-bold transition"><i class="ph ph-arrow-left"></i> Back to all events</a>
            </div>
        </div>
    </section>

    <?php
} else {
    // ---------------------------------------------------------
    // RENDER EVENTS LIST
    // ---------------------------------------------------------
    $events = [];
    try {
        $events = $pdo->query("SELECT * FROM event ORDER BY date_time ASC")->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {}
    ?>
    <!-- Page Header -->
    <section class="relative bg-dark py-24 lg:py-32 overflow-hidden">
        <div class="absolute inset-0 opacity-30" style="background-image: url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1600&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-dark to-dark/50"></div>
        <div class="absolute top-1/2 left-0 w-96 h-96 bg-primary rounded-full filter blur-[150px] opacity-20"></div>
        
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 animate-on-scroll">Upcoming Events</h1>
            <p class="text-lg text-slate-300 max-w-2xl mx-auto mb-6 animate-on-scroll delay-100">Join our upcoming seminars, virtual webinars, and partner university visits.</p>
            <div class="flex items-center justify-center gap-2 text-slate-400 text-sm font-medium animate-on-scroll delay-200">
                <a href="index.php" class="hover:text-secondary transition">Home</a>
                <i class="ph ph-caret-right"></i>
                <span class="text-secondary">Events</span>
            </div>
        </div>
    </section>

    <!-- Events Grid -->
    <section class="py-24 bg-slate-50 min-h-[60vh]">
        <div class="container mx-auto px-4">
            <?php if(!empty($events)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach($events as $index => $event): ?>
                        <div class="flex flex-col bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition duration-500 border border-slate-100 group animate-on-scroll" style="animation-delay: <?php echo ($index * 100); ?>ms;">
                            <div class="h-56 overflow-hidden relative">
                                <?php if($event['event_image']): ?>
                                    <img src="uploads/events/<?php echo htmlspecialchars($event['event_image']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-700 ease-in-out">
                                <?php else: ?>
                                    <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400 text-5xl"><i class="ph ph-calendar"></i></div>
                                <?php endif; ?>
                                
                                <div class="absolute top-4 right-4 bg-white/95 backdrop-blur font-bold py-2 px-4 rounded-xl shadow-md text-center">
                                    <span class="block text-2xl text-dark"><?php echo date('d', strtotime($event['date_time'])); ?></span>
                                    <span class="block text-xs uppercase text-secondary tracking-widest"><?php echo date('M', strtotime($event['date_time'])); ?></span>
                                </div>
                            </div>
                            
                            <div class="p-8 flex flex-col flex-grow">
                                <h3 class="text-2xl font-bold text-dark mb-4 leading-snug group-hover:text-secondary transition line-clamp-2">
                                    <a href="events.php?id=<?php echo $event['id']; ?>"><?php echo htmlspecialchars($event['title']); ?></a>
                                </h3>
                                
                                <div class="space-y-2 mb-6">
                                    <div class="flex items-center gap-2 text-slate-500 text-sm">
                                        <div class="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center text-primary"><i class="ph ph-map-pin"></i></div> 
                                        <?php echo htmlspecialchars($event['location'] ?? 'Virtual'); ?>
                                    </div>
                                    <div class="flex items-center gap-2 text-slate-500 text-sm">
                                        <div class="w-6 h-6 rounded-full bg-secondary/10 flex items-center justify-center text-secondary"><i class="ph ph-clock"></i></div> 
                                        <?php echo date('h:i A - l', strtotime($event['date_time'])); ?>
                                    </div>
                                </div>
                                
                                <div class="mt-auto border-t border-slate-100 pt-6">
                                    <a href="events.php?id=<?php echo $event['id']; ?>" class="inline-flex items-center gap-2 text-secondary font-bold hover:text-accent transition uppercase tracking-wider text-sm">
                                        Event Details <i class="ph ph-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-20">
                    <div class="w-24 h-24 bg-slate-200 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-400 text-4xl">
                        <i class="ph ph-calendar-x"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-600 mb-2">No Upcoming Events</h2>
                    <p class="text-slate-500">Stay tuned. We will announce new events shortly.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php
}

require_once __DIR__ . '/components/footer.php';
?>
