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
                    <form action="process_form" method="POST" class="flex gap-2">
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
                    <a href="index" class="flex items-center gap-2 group">
                        <?php if(isset($site_logo) && $site_logo): ?>
                            <img src="<?php echo htmlspecialchars($site_logo); ?>" alt="Logo" class="max-h-12 w-auto object-contain">
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
                    
                    <!-- Partners Row (requested) -->
                    <?php 
                    try {
                        $f_partners = $pdo->query("SELECT logo, company_name FROM partners ORDER BY position ASC LIMIT 4")->fetchAll(PDO::FETCH_ASSOC);
                        if (!empty($f_partners)):
                    ?>
                    <div class="pt-4">
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-3">Our Partners</p>
                        <div class="flex flex-wrap gap-4 items-center">
                            <?php foreach($f_partners as $fp): ?>
                                <?php if($fp['logo']): ?>
                                    <img src="uploads/partners/<?php echo $fp['logo']; ?>" alt="<?php echo htmlspecialchars($fp['company_name']); ?>" class="h-6 w-auto grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition duration-300" title="<?php echo htmlspecialchars($fp['company_name']); ?>">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; } catch(Exception $e) {} ?>

                    <div class="flex gap-3 pt-2">
                        <?php if(isset($social_links) && !empty($social_links)): ?>
                            <?php foreach($social_links as $link): ?>
                                <a href="<?php echo htmlspecialchars($link['link']); ?>" target="_blank" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-secondary text-white transition" title="<?php echo htmlspecialchars($link['social_media_name']); ?>">
                                    <i class="ph <?php echo htmlspecialchars($link['icon']); ?>"></i>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Fallback if no links found -->
                            <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-secondary text-white transition"><i class="ph ph-facebook-logo"></i></a>
                            <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-secondary text-white transition"><i class="ph ph-twitter-logo"></i></a>
                            <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-secondary text-white transition"><i class="ph ph-instagram-logo"></i></a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="relative z-10">
                    <h4 class="text-white font-bold text-lg mb-6">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="about" class="hover:text-secondary transition flex items-center gap-2"><i class="ph ph-caret-right text-xs"></i> About Us</a></li>
                        <li><a href="services" class="hover:text-secondary transition flex items-center gap-2"><i class="ph ph-caret-right text-xs"></i> Our Services</a></li>
                        <li><a href="destinations" class="hover:text-secondary transition flex items-center gap-2"><i class="ph ph-caret-right text-xs"></i> Study Destinations</a></li>
                        <li><a href="blog" class="hover:text-secondary transition flex items-center gap-2"><i class="ph ph-caret-right text-xs"></i> Success Stories</a></li>
                        <li><a href="contact" class="hover:text-secondary transition flex items-center gap-2"><i class="ph ph-caret-right text-xs"></i> Contact Us</a></li>
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
                            <a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode(strip_tags($about['address'])); ?>" target="_blank" class="hover:text-secondary transition">
                                <?php echo isset($about['address']) && !empty($about['address']) ? nl2br(htmlspecialchars($about['address'])) : '123 Education Street, Suite 404<br>Dhaka, Bangladesh 1212'; ?>
                            </a>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="ph ph-phone text-xl text-secondary"></i>
                            <a href="tel:<?php echo htmlspecialchars($site_phone); ?>" class="hover:text-secondary transition">
                                <?php echo isset($site_phone) ? htmlspecialchars($site_phone) : '+880 1234-567890'; ?>
                            </a>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="ph ph-envelope text-xl text-secondary"></i>
                            <a href="mailto:<?php echo htmlspecialchars($site_email); ?>" class="hover:text-secondary transition">
                                <?php echo isset($site_email) ? htmlspecialchars($site_email) : 'info@unilinkglobal.com'; ?>
                            </a>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="ph ph-clock text-xl text-secondary"></i>
                            <span>Mon - Fri: 9:00 AM - 6:00 PM</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-700/50 pt-8 mt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-500 relative z-10">
                <div class="flex flex-col md:flex-row items-center gap-2">
                    <p>&copy; <?php echo date('Y'); ?> <?php echo isset($site_title) ? htmlspecialchars($site_title) : 'Unilink Global Solution'; ?>. All rights reserved.</p>
                    <span class="hidden md:inline text-slate-700">|</span>
                    <p class="text-slate-400">Developed by <span class="text-secondary font-bold">MR CaT ❤️</span></p>
                </div>
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
        <div id="chatbot-chat-container" class="p-4 bg-slate-50 border-b border-slate-100 h-64 overflow-y-auto flex flex-col gap-4">
            <div class="flex gap-3 text-sm">
                <div class="w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center flex-shrink-0 mt-1"><i class="fa-solid fa-robot text-xs"></i></div>
                <div class="bg-white p-3 rounded-tr-lg rounded-br-lg rounded-bl-lg shadow-sm text-slate-600 border border-slate-100 chat-msg">
                    Hello! I'm here to guide you. What can I help you with today?
                </div>
            </div>
            <!-- Dynamic steps will appear here -->
        </div>

        <form id="chatbot-form" action="process_form" method="POST" class="p-4 flex flex-col gap-3 bg-white">
            <input type="hidden" name="form_type" value="chatbot">
            
            <!-- Step 1: Topic -->
            <div class="chat-step" id="step-1">
                <select name="topic" id="cb-topic" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-secondary focus:outline-none bg-slate-50">
                    <option value="">Select Topic...</option>
                    <option value="Admission">University Admission</option>
                    <option value="Visa">Visa Processing</option>
                    <option value="Scholarship">Scholarship Query</option>
                    <option value="Other">Other Information</option>
                </select>
            </div>

            <!-- Step 2: Name -->
            <div class="chat-step hidden" id="step-2">
                <input type="text" name="name" id="cb-name" placeholder="Your Name *" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-secondary focus:outline-none placeholder:text-slate-400">
            </div>

            <!-- Step 3: Email -->
            <div class="chat-step hidden" id="step-3">
                <input type="email" name="email" id="cb-email" placeholder="Your Email *" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-secondary focus:outline-none placeholder:text-slate-400">
            </div>

            <!-- Step 4: Phone -->
            <div class="chat-step hidden" id="step-4">
                <input type="text" name="phone" id="cb-phone" placeholder="Your Phone/WhatsApp *" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-secondary focus:outline-none placeholder:text-slate-400">
            </div>

            <!-- Step 5: Country -->
            <div class="chat-step hidden" id="step-5">
                <input type="text" name="country" id="cb-country" placeholder="Target Country *" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-secondary focus:outline-none placeholder:text-slate-400">
            </div>
            
            <!-- Step 6: Course -->
            <div class="chat-step hidden" id="step-6">
                <input type="text" name="course" id="cb-course" placeholder="Interested Program/Course *" required class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-secondary focus:outline-none placeholder:text-slate-400">
            </div>

            <!-- Step 7: Message -->
            <div class="chat-step hidden" id="step-7">
                <textarea name="message" id="cb-message" placeholder="Your Message..." rows="2" class="w-full px-3 py-2 text-sm border rounded-lg focus:ring-secondary focus:outline-none placeholder:text-slate-400"></textarea>
            </div>

            <button type="button" id="nextStepBtn" class="w-full py-2 bg-secondary text-white font-bold rounded-lg shadow hover:bg-accent text-sm transition flex items-center justify-center gap-2">
                Continue <i class="ph ph-arrow-right"></i>
            </button>
            
            <!-- Celebration Check (Hidden) -->
            <div id="cb-celebration" class="hidden absolute inset-0 bg-white/90 backdrop-blur z-20 flex flex-col items-center justify-center text-secondary">
                <div class="w-16 h-16 bg-secondary text-white rounded-full flex items-center justify-center text-3xl animate-bounce">
                    <i class="ph ph-check-bold"></i>
                </div>
                <p class="font-bold mt-2">Awesome!</p>
            </div>
        </form>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
    <!-- Optional: Initialize common components like intersection observers for animations -->
    <script>
        // Chatbot Toggle
        function toggleChatbot() {
            const cb = document.getElementById('chatbot-window');
            cb.classList.toggle('hidden');
            cb.classList.toggle('flex');
        }

        document.addEventListener("DOMContentLoaded", () => {
            // Sequential Chatbot Logic
            const form = document.getElementById('chatbot-form');
            const chatContainer = document.getElementById('chatbot-chat-container');
            const nextBtn = document.getElementById('nextStepBtn');
            const celebration = document.getElementById('cb-celebration');
            let currentStep = 1;

            const questions = [
                "", // Step 0
                "Great! Now, could you tell me your name?", // Ask for name after topic
                "Nice to meet you! What's your email address?", // Ask for email after name
                "Thanks! And what's your Phone or WhatsApp number?", // Ask for phone after email
                "Which country are you targeting for your studies?", // Ask for country after phone
                "What program or course are you interested in?", // Ask for course after country
                "Almost there! Do you have any specific message or question for us?", // Ask for message after course
                "Thank you! We've received your inquiry. Our counselors will contact you soon." // Final
            ];

            function addMessage(text, isUser = false) {
                const msgDiv = document.createElement('div');
                msgDiv.className = `flex gap-3 text-sm ${isUser ? 'justify-end' : ''}`;
                
                const html = isUser ? 
                    `<div class="bg-secondary text-white p-3 rounded-tl-lg rounded-bl-lg rounded-br-lg shadow-sm border border-secondary/20 max-w-[80%]">${text}</div>` :
                    `<div class="w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center flex-shrink-0 mt-1"><i class="fa-solid fa-robot text-xs"></i></div>
                     <div class="bg-white p-3 rounded-tr-lg rounded-br-lg rounded-bl-lg shadow-sm text-slate-600 border border-slate-100 max-w-[80%]">${text}</div>`;
                
                msgDiv.innerHTML = html;
                chatContainer.appendChild(msgDiv);
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }

            function celebrate(callback) {
                celebration.classList.remove('hidden');
                setTimeout(() => {
                    celebration.classList.add('hidden');
                    callback();
                }, 1000);
            }

            nextBtn.addEventListener('click', () => {
                const currentInput = document.querySelector(`#step-${currentStep} input, #step-${currentStep} select, #step-${currentStep} textarea`);
                
                if(!currentInput.value.trim()) {
                    currentInput.classList.add('border-red-500');
                    return;
                }
                currentInput.classList.remove('border-red-500');

                // Custom validation for Email (Step 3)
                if(currentStep === 3) {
                    if(!currentInput.value.includes('@')) {
                        currentInput.classList.add('border-red-500');
                        addMessage(currentInput.value, true); // Show what they typed visually
                        addMessage("Please enter a valid email address with an '@' symbol."); // Bot replies with error!
                        currentInput.value = ''; // clear input so they can type again
                        return; // Halt progression
                    }
                }

                // Add user response to chat
                addMessage(currentInput.value, true);

                if(currentStep < 7) {
                    celebrate(() => {
                        // Hide current step, show next
                        document.getElementById(`step-${currentStep}`).classList.add('hidden');
                        currentStep++;
                        document.getElementById(`step-${currentStep}`).classList.remove('hidden');
                        
                        // Add next bot question
                        addMessage(questions[currentStep - 1]);
                        
                        // Update button text on last step
                        if(currentStep === 7) {
                            nextBtn.innerHTML = 'Submit Inquiry <i class="ph ph-paper-plane-right"></i>';
                        }
                    });
                } else {
                    // Final Submission via AJAX
                    const formData = new FormData(form);
                    nextBtn.disabled = true;
                    nextBtn.innerHTML = '<i class="ph ph-spinner animate-spin"></i> Submitting...';

                    fetch('process_form', {
                        method: 'POST',
                        body: formData
                    })
                    .then(r => r.text())
                    .then(() => {
                        celebrate(() => {
                            addMessage(questions[7]);
                            form.innerHTML = '<div class="p-4 text-center text-green-600 font-bold">Message Sent Successfully!</div>';
                            
                            // Success Modal for Chatbot
                            setTimeout(() => {
                                Swal.fire({
                                    title: 'Inquiry Sent!',
                                    text: 'Thank you for contacting us. We will get back to you soon.',
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#ff6b00', // secondary color
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'index';
                                    }
                                });
                            }, 1500);
                        });
                    });
                }
            });

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

            // Global Form Success Modal (for page reloads)
            <?php if(isset($_SESSION['submission_success'])): ?>
                Swal.fire({
                    title: '<?php echo $_SESSION['submission_success_title'] ?? "Success!"; ?>',
                    text: '<?php echo $_SESSION['submission_success_text'] ?? "Your request has been submitted successfully."; ?>',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ff6b00',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index';
                    }
                });
                <?php 
                    unset($_SESSION['submission_success']); 
                    unset($_SESSION['submission_success_title']);
                    unset($_SESSION['submission_success_text']);
                ?>
            <?php endif; ?>

            // Global Loading States for Forms
            const allForms = document.querySelectorAll('form:not(#chatbot-form)');
            allForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        const originalHtml = submitBtn.innerHTML;
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="ph ph-spinner animate-spin"></i> Processing...';
                    }

                    Swal.fire({
                        title: 'Processing your request...',
                        text: 'Please wait while we connect to our secure server.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
