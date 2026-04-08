<?php
// appointment.php
require_once __DIR__ . '/components/header.php';
?>

<!-- Page Header -->
<section class="relative bg-dark py-24 lg:py-32 overflow-hidden">
    <div class="absolute inset-0 opacity-20" style="background-image: url('https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=1600&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-dark to-dark/80"></div>
    <div class="absolute top-0 right-1/4 w-96 h-96 bg-secondary rounded-full filter blur-[150px] opacity-30"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 animate-on-scroll">Book an Appointment</h1>
        <div class="flex items-center justify-center gap-2 text-slate-300 text-sm font-medium animate-on-scroll delay-100">
            <a href="index.php" class="hover:text-secondary transition">Home</a>
            <i class="ph ph-caret-right"></i>
            <span class="text-secondary">Appointment</span>
        </div>
    </div>
</section>

<!-- Appointment Form Section -->
<section class="py-20 bg-slate-50 relative">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            <div class="text-center mb-12 animate-on-scroll">
                <h4 class="text-secondary font-bold tracking-wider uppercase text-sm mb-2">Free Consultation</h4>
                <h2 class="text-3xl md:text-4xl font-bold text-dark mb-4">Start Your <span class="text-secondary">Process</span></h2>
                <p class="text-slate-500">Provide us with your academic details so our expert counselors can tailor the best options for your study abroad journey.</p>
            </div>

            <?php display_flash_msg(); ?>

            <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-slate-100 animate-on-scroll delay-100 relative overflow-hidden">
                <!-- Decorative top bar border -->
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-primary via-secondary to-accent"></div>
                
                <form action="process_form.php" method="POST" class="space-y-10 mt-4">
                    <input type="hidden" name="form_type" value="appointment">
                    <input type="text" name="honeypot" class="hidden">

                    <!-- 1. Personal Information -->
                    <div>
                        <div class="flex items-center gap-3 mb-6 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">1</div>
                            <h3 class="text-xl font-bold text-dark">Personal details</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Full Name *</label>
                                <input type="text" name="name" required class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary focus:border-secondary transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Email Address *</label>
                                <input type="email" name="email" required class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary focus:border-secondary transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Phone / WhatsApp *</label>
                                <input type="text" name="phone" required class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary focus:border-secondary transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Full Address</label>
                                <input type="text" name="address" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary focus:border-secondary transition">
                            </div>
                        </div>
                    </div>

                    <!-- 2. Academic Background -->
                    <div>
                        <div class="flex items-center gap-3 mb-6 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-full bg-secondary/10 text-secondary flex items-center justify-center font-bold text-sm">2</div>
                            <h3 class="text-xl font-bold text-dark">Academic Background</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Last Academic Education *</label>
                                <input type="text" name="last_academic_education" required placeholder="e.g. HSC, A-Level, Bachelor" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Passing Year *</label>
                                <input type="number" name="passing_year" min="2000" max="<?php echo date('Y')+5; ?>" required class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Subject / Department</label>
                                <input type="text" name="department" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Institution Name</label>
                                <input type="text" name="institution_name" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary outline-none transition">
                            </div>
                        </div>
                    </div>

                    <!-- 3. Test Proficiency -->
                    <div>
                        <div class="flex items-center gap-3 mb-6 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-full bg-accent/10 text-accent flex items-center justify-center font-bold text-sm">3</div>
                            <h3 class="text-xl font-bold text-dark">Language Proficiency</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Have you taken any English Test?</label>
                                <select name="english_test" id="english_test_select" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary outline-none transition">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>
                            
                            <!-- Fields shown conditionally -->
                            <div class="hidden test-field">
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Test Name</label>
                                <select name="test_name" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary outline-none transition">
                                    <option value="">Select Test...</option>
                                    <option value="IELTS">IELTS</option>
                                    <option value="PTE">PTE</option>
                                    <option value="TOEFL">TOEFL</option>
                                    <option value="Duolingo">Duolingo</option>
                                    <option value="MOI">MOI</option>
                                </select>
                            </div>
                            <div class="hidden test-field">
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Overall Score / Result</label>
                                <input type="text" name="test_results" placeholder="e.g. 6.5" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary outline-none transition">
                            </div>
                            
                            <!-- Field if No -->
                            <div class="no-test-field">
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Planned Exam Date (Optional)</label>
                                <input type="date" name="planned_exam_date" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary outline-none transition">
                            </div>
                        </div>
                    </div>

                    <!-- 4. Study Preferences -->
                    <div>
                        <div class="flex items-center gap-3 mb-6 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-full bg-secondary/20 text-secondary flex items-center justify-center font-bold text-sm">4</div>
                            <h3 class="text-xl font-bold text-dark">Study Preferences</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Degree Seeking *</label>
                                <select name="degree" required class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary outline-none transition">
                                    <option value="">Select Level...</option>
                                    <option value="Bachelor">Bachelor's Degree</option>
                                    <option value="Masters">Master's Degree</option>
                                    <option value="PhD">PhD / Doctorate</option>
                                    <option value="Diploma">Diploma / Foundation</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Interested Target Country *</label>
                                <input type="text" name="interest_country" required placeholder="e.g. Australia, UK, Canada" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Interested Course/Major *</label>
                                <input type="text" name="interested_course" required placeholder="e.g. Computer Science, MBA" class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-secondary outline-none transition">
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="pt-6 text-center">
                        <button type="submit" class="bg-secondary hover:bg-accent text-white px-12 py-4 rounded-full font-bold text-lg shadow-xl hover:shadow-secondary/30 transition transform hover:-translate-y-1 inline-flex items-center gap-2">
                            Submit Request <i class="ph ph-calendar-plus text-2xl"></i>
                        </button>
                        <p class="text-xs text-slate-400 mt-4"><i class="ph ph-lock"></i> Your information is absolutely secure and never shared with a third party.</p>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const testSelect = document.getElementById('english_test_select');
    const testFields = document.querySelectorAll('.test-field');
    const noTestField = document.querySelector('.no-test-field');

    function toggleFields() {
        if (testSelect.value === 'Yes') {
            testFields.forEach(f => {
                f.classList.remove('hidden');
            });
            noTestField.classList.add('hidden');
        } else {
            testFields.forEach(f => {
                f.classList.add('hidden');
                // clear values
                f.querySelector('select, input').value = '';
            });
            noTestField.classList.remove('hidden');
        }
    }

    testSelect.addEventListener('change', toggleFields);
    toggleFields(); // trigger on load
});
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
