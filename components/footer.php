    </main>

    <!-- Footer -->
    <footer class="bg-dark text-slate-300 pt-16 pb-8 border-t-[8px] border-secondary relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-secondary rounded-full filter blur-[100px] opacity-10 blur-3xl translate-x-1/2 -translate-y-1/2"></div>
        
        <div class="container mx-auto px-4">
            <!-- Newsletter -->
            <div class="bg-primary/5 rounded-3xl p-8 md:p-12 mb-16 border border-white/10 relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="md:w-1/2">
                    <h3 class="text-2xl font-bold text-white mb-2">Subscribe to our Newsletter</h3>
                    <p class="text-slate-400 text-sm">Stay updated with the latest university admissions, scholarships, and study abroad news.</p>
                </div>
                <div class="md:w-1/2 w-full">
                    <form action="process_form.php" method="POST" class="flex gap-2">
                        <input type="hidden" name="form_type" value="subscriber">
                        <input type="email" name="email" placeholder="Your Email Address" required class="w-full px-4 py-3 rounded-full bg-slate-800/50 border border-slate-700 text-white focus:outline-none focus:border-secondary transition placeholder:text-slate-500">
                        <button type="submit" class="bg-secondary hover:bg-accent text-white px-6 md:px-8 py-3 rounded-full font-bold transition flex items-center justify-center flex-shrink-0">
                            Subscribe <i class="ph ph-paper-plane-right ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                <!-- Brand -->
                <div class="space-y-4 relative z-10">
                    <a href="index.php" class="flex items-center gap-2 group">
                        <?php if(isset($site_logo) && $site_logo): ?>
                            <img src="<?php echo htmlspecialchars($site_logo); ?>" alt="Logo" class="max-h-12 w-auto object-contain brightness-0 invert">
                        <?php else: ?>
                            <div class="w-10 h-10 bg-secondary rounded-xl flex items-center justify-center text-white font-bold text-xl group-hover:bg-primary group-hover:text-secondary transition transform">
                                U
                            </div>
                            <span class="text-xl font-bold text-white tracking-tight">Unilink <span class="text-secondary">Global</span></span>
                        <?php endif; ?>
                    </a>
                    <p class="text-sm text-slate-400 mt-4 leading-relaxed">
                        <?php echo isset($about['about_company']) && !empty($about['about_company']) ? htmlspecialchars(substr(strip_tags($about['about_company']), 0, 150)) . '...' : 'Your trusted partner for international education. We guide students to achieve their academic and professional goals in top universities worldwide.'; ?>
                    </p>
                    <div class="flex gap-3 pt-2">
                        <!-- We would ideally loop over the social_media table here -->
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-secondary text-white transition"><i class="ph ph-facebook-logo"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-secondary text-white transition"><i class="ph ph-twitter-logo"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-secondary text-white transition"><i class="ph ph-instagram-logo"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-secondary text-white transition"><i class="ph ph-linkedin-logo"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="relative z-10">
                    <h4 class="text-white font-bold text-lg mb-6">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="about.php" class="hover:text-secondary transition flex items-center gap-2"><i class="ph ph-caret-right text-xs"></i> About Us</a></li>
                        <li><a href="services.php" class="hover:text-secondary transition flex items-center gap-2"><i class="ph ph-caret-right text-xs"></i> Our Services</a></li>
                        <li><a href="destinations.php" class="hover:text-secondary transition flex items-center gap-2"><i class="ph ph-caret-right text-xs"></i> Study Destinations</a></li>
                        <li><a href="blog.php" class="hover:text-secondary transition flex items-center gap-2"><i class="ph ph-caret-right text-xs"></i> Success Stories</a></li>
                        <li><a href="contact.php" class="hover:text-secondary transition flex items-center gap-2"><i class="ph ph-caret-right text-xs"></i> Contact Us</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="relative z-10">
                    <h4 class="text-white font-bold text-lg mb-6">Our Services</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="ph ph-caret-right text-xs"></i> Study Abroad Counseling</a></li>
                        <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="ph ph-caret-right text-xs"></i> University Admission</a></li>
                        <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="ph ph-caret-right text-xs"></i> Visa Processing</a></li>
                        <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="ph ph-caret-right text-xs"></i> Scholarship Assistance</a></li>
                        <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="ph ph-caret-right text-xs"></i> Pre-Departure Briefing</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="relative z-10">
                    <h4 class="text-white font-bold text-lg mb-6">Contact Us</h4>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start gap-3">
                            <i class="ph ph-map-pin text-xl text-secondary mt-0.5"></i>
                            <span><?php echo isset($about['address']) && !empty($about['address']) ? nl2br(htmlspecialchars($about['address'])) : '123 Education Street, Suite 404<br>Dhaka, Bangladesh 1212'; ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="ph ph-phone text-xl text-secondary"></i>
                            <span><?php echo isset($site_phone) ? htmlspecialchars($site_phone) : '+880 1234-567890'; ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="ph ph-envelope text-xl text-secondary"></i>
                            <span><?php echo isset($site_email) ? htmlspecialchars($site_email) : 'info@unilinkglobal.com'; ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="ph ph-clock text-xl text-secondary"></i>
                            <span>Mon - Fri: 9:00 AM - 6:00 PM</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-700/50 pt-8 mt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-500 relative z-10">
                <p>&copy; <?php echo date('Y'); ?> <?php echo isset($site_title) ? htmlspecialchars($site_title) : 'Unilink Global Solution'; ?>. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <span class="w-1 h-1 rounded-full bg-slate-600"></span>
                    <a href="#" class="hover:text-white transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Fixed Floating Widgets -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col gap-4">
        <!-- WhatsApp -->
        <?php if(!empty($site_whatsapp)): ?>
        <a href="https://wa.me/<?php echo htmlspecialchars($site_whatsapp); ?>" target="_blank" class="w-14 h-14 bg-[#25D366] text-white rounded-full flex items-center justify-center text-3xl shadow-lg hover:-translate-y-1 hover:shadow-xl transition transform animate-bounce z-50">
            <i class="fa-brands fa-whatsapp"></i>
        </a>
        <?php endif; ?>
        
        <!-- Chatbot Blob -->
        <button onclick="toggleChatbot()" class="w-14 h-14 bg-secondary text-white rounded-full flex items-center justify-center text-2xl shadow-lg hover:scale-110 transition transform z-50 overflow-hidden relative">
            <i class="fa-solid fa-robot relative z-10"></i>
            <div class="absolute inset-0 bg-accent animate-pulse opacity-50 z-0"></div>
        </button>
    </div>

    <!-- Chatbot Window -->
    <div id="chatbot-window" class="fixed bottom-24 right-6 w-80 bg-white rounded-2xl shadow-2xl border border-slate-100 z-50 hidden flex-col overflow-hidden transform transition-all duration-300 origin-bottom-right">
        <div class="bg-dark text-white p-4 flex justify-between items-center rounded-t-2xl">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-secondary rounded-full flex items-center justify-center"><i class="fa-solid fa-robot"></i></div>
                <h4 class="font-bold">Virtual Assistant</h4>
            </div>
            <button onclick="toggleChatbot()" class="text-slate-300 hover:text-white"><i class="ph ph-x text-lg"></i></button>
        </div>
        <div class="p-4 bg-slate-50 border-b border-slate-100 max-h-40 overflow-y-auto">
            <div class="flex gap-3 text-sm">
                <div class="w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center flex-shrink-0 mt-1"><i class="fa-solid fa-robot text-xs"></i></div>
                <div class="bg-white p-3 rounded-tr-lg rounded-br-lg rounded-bl-lg shadow-sm text-slate-600 border border-slate-100">
                    Hello! I'm here to guide you. Please leave your details and what you need help with, and our counselors will get back to you immediately!
                </div>
            </div>
        </div>
        <form action="process_form.php" method="POST" class="p-4 flex flex-col gap-3">
            <input type="hidden" name="form_type" value="chatbot">
            <select name="topic" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-secondary focus:outline-none bg-slate-50">
                <option value="">Select Topic...</option>
                <option value="Admission">University Admission</option>
                <option value="Visa">Visa Processing</option>
                <option value="Scholarship">Scholarship Query</option>
                <option value="Other">Other Information</option>
            </select>
            <input type="text" name="name" placeholder="Your Name *" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-secondary focus:outline-none placeholder:text-slate-400">
            <input type="text" name="phone" placeholder="Your Phone/WhatsApp *" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-secondary focus:outline-none placeholder:text-slate-400">
            <textarea name="message" placeholder="Your Message..." rows="2" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-secondary focus:outline-none placeholder:text-slate-400"></textarea>
            <button type="submit" class="w-full py-2 bg-secondary text-white font-bold rounded-lg shadow hover:bg-accent text-sm mt-1 transition">Send Message</button>
        </form>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
    <!-- Optional: Initialize common components like intersection observers for animations -->
    <script>
        // Chatbot Toggle
        function toggleChatbot() {
            const cb = document.getElementById('chatbot-window');
            if(cb.classList.contains('hidden')) {
                cb.classList.remove('hidden');
                cb.classList.add('flex');
            } else {
                cb.classList.add('hidden');
                cb.classList.remove('flex');
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            // Intersection Observer for scroll animations
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in-up');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.animate-on-scroll').forEach((el) => {
                observer.observe(el);
            });
        });
    </script>
</body>
</html>
