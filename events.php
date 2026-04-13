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
        redirect('events');
    }
    ?>
    <!-- Event Hero Header -->
    <section class="relative bg-slate-50 pt-24 pb-16 lg:pt-32 lg:pb-24 overflow-hidden border-b border-slate-100">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-multiply"></div>
        <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-primary rounded-full filter blur-[150px] opacity-50 translate-x-1/3 -translate-y-1/3"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="flex flex-col lg:flex-row gap-12 items-center">
                
                <div class="lg:w-2/3">
                    <div class="flex items-center gap-2 text-slate-400 text-sm font-bold uppercase tracking-widest mb-6 animate-on-scroll">
                        <a href="/" class="hover:text-secondary transition text-slate-500">Home</a>
                        <i class="ph ph-caret-right"></i>
                        <a href="events" class="hover:text-secondary transition text-slate-500">Events</a>
                        <i class="ph ph-caret-right"></i>
                        <span class="text-secondary">Event Details</span>
                    </div>
                    
                    <h1 class="text-3xl md:text-5xl font-extrabold text-slate-800 mb-6 leading-tight max-w-4xl tracking-tight animate-on-scroll delay-100">
                        <?php echo htmlspecialchars($event['title']); ?>
                    </h1>
                    
                    <div class="flex flex-col sm:flex-row gap-6 mb-8 text-slate-600 animate-on-scroll delay-200">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-white shadow-sm text-secondary border border-slate-100 flex items-center justify-center text-xl"><i class="ph ph-clock"></i></div>
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Time</p>
                                <p class="font-bold text-slate-700"><?php echo date('h:i A - l', strtotime($event['date_time'])); ?></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-white shadow-sm text-secondary border border-slate-100 flex items-center justify-center text-xl"><i class="ph ph-map-pin"></i></div>
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Location</p>
                                <p class="font-bold text-slate-700"><?php echo htmlspecialchars($event['location'] ?? 'Virtual / Online'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/3 w-full animate-on-scroll delay-200">
                    <div class="relative rounded-[2rem] overflow-hidden shadow-xl border-4 border-white aspect-[4/3] group text-center bg-white flex items-center justify-center">
                        <div class="p-8">
                            <span class="block text-6xl font-black text-secondary mb-2"><?php echo date('d', strtotime($event['date_time'])); ?></span>
                            <span class="block text-xl uppercase tracking-widest text-slate-500 font-bold"><?php echo date('F Y', strtotime($event['date_time'])); ?></span>
                        </div>
                        <div class="absolute inset-0 bg-secondary/5 mix-blend-multiply transition duration-500 group-hover:bg-transparent"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Details Section -->
    <section class="py-20 bg-white min-h-[50vh]">
        <div class="container mx-auto px-4 max-w-4xl border-slate-100 border bg-slate-50 rounded-3xl p-8 sm:p-12 shadow-sm animate-on-scroll">
            
            <?php if($event['event_image']): ?>
                <img src="uploads/events/<?php echo htmlspecialchars($event['event_image']); ?>" class="w-full h-80 object-cover rounded-2xl mb-10 shadow-sm border border-slate-100/50 hover:shadow-md transition">
            <?php endif; ?>
            
            <h2 class="text-2xl font-bold text-slate-800 mb-6 border-b border-slate-200 pb-4">Event Description</h2>

            <div class="prose prose-lg prose-slate max-w-none text-slate-600 leading-relaxed mb-12">
                <?php echo nl2br(htmlspecialchars($event['description'] ?? '')); ?>
            </div>
            
            <div class="bg-white border border-slate-100 rounded-3xl p-8 sm:p-12 shadow-md overflow-hidden mt-12 animate-on-scroll">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-10 border-b border-slate-100 pb-8">
                    <div class="text-center md:text-left">
                        <h3 class="text-2xl font-bold text-slate-800 mb-2">Book Your Spot Now</h3>
                        <p class="text-slate-500 text-sm">Fill in your details below to secure your seat for this event.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="px-4 py-2 bg-secondary/10 text-secondary rounded-full text-xs font-bold uppercase tracking-widest">Limited Seats</div>
                    </div>
                </div>

                <form action="process_form" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <input type="hidden" name="form_type" value="event_registration">
                    <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                    <input type="hidden" name="event_title" value="<?php echo htmlspecialchars($event['title']); ?>">
                    
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Full Name *</label>
                        <div class="relative">
                            <i class="ph ph-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="name" placeholder="Enter your full name" required 
                                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition outline-none text-slate-600">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Email Address *</label>
                        <div class="relative">
                            <i class="ph ph-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="email" name="email" placeholder="example@mail.com" required 
                                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition outline-none text-slate-600">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Phone / WhatsApp *</label>
                        <div class="relative">
                            <i class="ph ph-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="phone" placeholder="+880 1XXX-XXXXXX" required 
                                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition outline-none text-slate-600">
                        </div>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-secondary hover:bg-accent text-white font-bold py-4 rounded-2xl shadow-lg shadow-secondary/20 transition transform hover:-translate-y-1 flex items-center justify-center gap-2 group">
                            Confirm Registration 
                            <i class="ph ph-paper-plane-right group-hover:translate-x-1 transition"></i>
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="text-center mt-12 border-t border-slate-200 pt-8">
                <a href="events" class="inline-flex items-center gap-2 text-slate-500 hover:text-secondary font-bold transition"><i class="ph ph-arrow-left"></i> Back to all events</a>
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
        $events = $pdo->query("SELECT * FROM event ORDER BY position ASC")->fetchAll(PDO::FETCH_ASSOC);
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
                <a href="index" class="hover:text-secondary transition">Home</a>
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
                                    <a href="event-<?php echo $event['id']; ?>-<?php echo slugify($event['title']); ?>"><?php echo htmlspecialchars($event['title']); ?></a>
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
                                    <a href="event-<?php echo $event['id']; ?>-<?php echo slugify($event['title']); ?>" class="inline-flex items-center gap-2 text-secondary font-bold hover:text-accent transition uppercase tracking-wider text-sm">
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
