<?php
// contact.php
require_once __DIR__ . '/components/header.php';

?>

<!-- Page Header -->
<section class="relative bg-dark py-24 lg:py-32 overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute inset-0 opacity-20" style="background-image: url('https://images.unsplash.com/photo-1596524430615-b46475ddff6e?q=80&w=1600&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-dark to-dark/80"></div>
    <div class="absolute top-1/2 left-0 w-64 h-64 bg-secondary rounded-full filter blur-[150px] opacity-30"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 animate-on-scroll">Get In Touch</h1>
        <div class="flex items-center justify-center gap-2 text-slate-300 text-sm font-medium animate-on-scroll delay-100">
            <a href="index" class="hover:text-secondary transition">Home</a>
            <i class="ph ph-caret-right"></i>
            <span class="text-secondary">Contact Us</span>
        </div>
    </div>
</section>

<!-- Contact Info & Form -->
<section class="py-24 bg-white relative">
    <div class="absolute top-0 right-0 w-1/3 h-full bg-slate-50 rounded-l-3xl -z-10 hidden lg:block"></div>
    <div class="container mx-auto px-4">
        
        <?php display_flash_msg(); ?>

        <div class="flex flex-col lg:flex-row gap-16">
            
            <!-- Contact Information -->
            <div class="lg:w-5/12 animate-on-scroll">
                <h4 class="text-secondary font-bold tracking-wider uppercase text-sm mb-2">Contact Details</h4>
                <h2 class="text-3xl md:text-4xl font-bold text-dark mb-6 leading-tight">We're Here to <span class="text-secondary">Help You</span></h2>
                <p class="text-slate-500 mb-10 leading-relaxed">Reach out to us for any queries regarding admissions, scholarships, visa processing, or our premium consultancy services.</p>
                
                <div class="space-y-8">
                    <!-- Address -->
                    <div class="flex items-start gap-6 group">
                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-3xl text-secondary group-hover:bg-secondary group-hover:text-white transition duration-300 shadow-sm flex-shrink-0">
                            <i class="ph ph-map-pin-line"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-dark mb-1">Office Location</h3>
                            <p class="text-slate-500 leading-relaxed"><?php echo isset($about['address']) && !empty($about['address']) ? nl2br(htmlspecialchars($about['address'])) : '123 Education Street, Suite 404<br>Dhaka, Bangladesh 1212'; ?></p>
                        </div>
                    </div>
                    
                    <!-- Phone -->
                    <div class="flex items-start gap-6 group">
                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-3xl text-secondary group-hover:bg-secondary group-hover:text-white transition duration-300 shadow-sm flex-shrink-0">
                            <i class="ph ph-phone-call"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-dark mb-1">Phone Number</h3>
                            <a href="tel:<?php echo htmlspecialchars($site_phone); ?>" class="text-slate-500 hover:text-secondary transition text-lg block"><?php echo htmlspecialchars($site_phone); ?></a>
                            <p class="text-sm text-slate-400 mt-1">Mon - Fri: 9:00 AM - 6:00 PM</p>
                        </div>
                    </div>
                    
                    <!-- Email -->
                    <div class="flex items-start gap-6 group">
                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-3xl text-secondary group-hover:bg-secondary group-hover:text-white transition duration-300 shadow-sm flex-shrink-0">
                            <i class="ph ph-envelope-simple-open"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-dark mb-1">Email Address</h3>
                            <a href="mailto:<?php echo htmlspecialchars($site_email); ?>" class="text-slate-500 hover:text-secondary transition text-lg block"><?php echo htmlspecialchars($site_email); ?></a>
                            <p class="text-sm text-slate-400 mt-1">We'll respond within 24 hours.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:w-7/12 animate-on-scroll delay-100">
                <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-slate-100 lg:mr-8 relative">
                    <!-- Deco dot -->
                    <div class="absolute -top-4 -right-4 w-20 h-20 bg-[radial-gradient(#f97316_1px,transparent_1px)] [background-size:10px_10px] opacity-30"></div>
                    
                    <h3 class="text-2xl font-bold text-dark mb-8">Send Us a Message</h3>
                    
                    <form action="process_form" method="POST" class="space-y-6 relative z-10">
                        <input type="hidden" name="form_type" value="contact">
                        <input type="text" name="honeypot" class="hidden">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Full Name *</label>
                                <input type="text" name="name" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition" placeholder="John Doe">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Email Address *</label>
                                <input type="email" name="email" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition" placeholder="john@example.com">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-2">Subject *</label>
                            <input type="text" name="subject" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition" placeholder="How can we help you?">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-2">Message *</label>
                            <textarea name="message" rows="5" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition resize-none" placeholder="Write your message here..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-secondary hover:bg-accent text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-secondary/30 transition transform active:scale-95 flex items-center justify-center gap-2">
                            Send Message <i class="ph ph-paper-plane-right text-xl"></i>
                        </button>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Google Map (Placeholder or dynamic map link if available) -->
<section class="h-96 w-full bg-slate-200 relative grayscale hover:grayscale-0 transition duration-700">
    <!-- Embed a standard iframe map, replace src with dynamic if you want -->
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.9024424301397!2d90.3910801154316!3d23.750858094676662!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8bd5421c97f%3A0xe7a50153922cc5ee!2sDhaka%2C%20Bangladesh!5e0!3m2!1sen!2sus!4v1690000000000!5m2!1sen!2sus" class="absolute inset-0 w-full h-full border-0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>

<?php require_once __DIR__ . '/components/footer.php'; ?>
