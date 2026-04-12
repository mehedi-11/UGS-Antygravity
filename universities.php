<?php
// universities.php
require_once __DIR__ . '/components/header.php';

// Fetch all universities
$universities = [];
try {
    $universities = $pdo->query("SELECT * FROM university ORDER BY position ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

// Pre-process countries for tabs
$countries = [];
foreach($universities as $uni) {
    if(!empty($uni['country'])) {
        $countries[$uni['country']] = $uni['country'];
    }
}
$countries = array_values($countries);
sort($countries);

// If user came from destinations page, they might have ?country=StudyTarget
$active_country = $_GET['country'] ?? 'All';

?>

<!-- Page Header -->
<section class="relative bg-dark py-24 lg:py-32 overflow-hidden border-b border-slate-100">
    <!-- Background Decoration -->
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-multiply"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-primary rounded-full filter blur-[150px] opacity-70"></div>
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-secondary rounded-full filter blur-[150px] opacity-20 translate-x-1/3 -translate-y-1/3"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center flex flex-col items-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 animate-on-scroll">World-Class <span class="text-secondary">Universities</span></h1>
        <p class="text-lg text-slate-300 max-w-2xl mx-auto mb-8 animate-on-scroll delay-100">Explore our extensive network of partner institutions across the globe and find the perfect academic fit for your future.</p>
        
        <div class="flex items-center justify-center gap-2 text-slate-400 text-sm font-bold uppercase tracking-widest animate-on-scroll delay-200 mt-4">
            <a href="index" class="hover:text-secondary transition text-slate-300">Home</a>
            <i class="ph ph-caret-right"></i>
            <a href="destinations" class="hover:text-secondary transition text-slate-300">Destinations</a>
            <i class="ph ph-caret-right"></i>
            <span class="text-secondary">Universities</span>
        </div>
    </div>
</section>

<!-- Main Area -->
<section class="py-20 bg-slate-50 min-h-[60vh]">
    <div class="container mx-auto px-4">
        
        <?php if(!empty($universities)): ?>
            <!-- Controls Group: Search & Tabs -->
            <div class="mb-16 animate-on-scroll">
                <!-- Search Bar -->
                <div class="max-w-3xl mx-auto mb-10 relative">
                    <input type="text" id="uniSearch" placeholder="Search by university name or country..." class="w-full px-8 py-5 pl-16 rounded-full border border-slate-200 focus:border-secondary focus:ring-4 focus:ring-secondary/10 outline-none text-slate-700 shadow-lg text-lg transition duration-300">
                    <i class="ph ph-magnifying-glass absolute left-6 top-1/2 -translate-y-1/2 text-3xl text-slate-400"></i>
                </div>
                
                <!-- Country Tabs -->
                <div class="flex flex-wrap justify-center gap-3" id="uniTabs">
                    <button class="tab-btn px-6 py-3 rounded-full font-bold text-sm transition-all duration-300 border-2 shadow-sm <?php echo $active_country === 'All' ? 'bg-secondary text-white border-secondary shadow-lg shadow-orange-500/20 active-tab' : 'bg-transparent text-slate-500 hover:text-secondary border-slate-200 hover:border-secondary inactive-tab'; ?>" data-target="All">
                        All Destinations
                    </button>
                    <?php foreach($countries as $c): ?>
                        <button class="tab-btn px-6 py-3 rounded-full font-bold text-sm transition-all duration-300 border-2 shadow-sm <?php echo $active_country === $c ? 'bg-secondary text-white border-secondary shadow-lg shadow-orange-500/20 active-tab' : 'bg-transparent text-slate-500 hover:text-secondary border-slate-200 hover:border-secondary inactive-tab'; ?>" data-target="<?php echo htmlspecialchars($c); ?>">
                            <?php echo htmlspecialchars($c); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Universities Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="uniGrid">
                <?php foreach($universities as $index => $uni): ?>
                    <div class="uni-card bg-white rounded-[2rem] p-6 shadow-sm hover:shadow-2xl transition duration-500 border border-slate-100 group flex flex-col items-center text-center relative overflow-hidden" 
                         style="display: <?php echo ($active_country === 'All' || $active_country === ($uni['country'] ?? '')) ? 'flex' : 'none'; ?>;"
                         data-country="<?php echo htmlspecialchars($uni['country'] ?? ''); ?>" 
                         data-name="<?php echo strtolower(htmlspecialchars($uni['university_name'])); ?>">
                        
                        <!-- Uni Badge/Logo Wrapper -->
                        <div class="w-full h-40 mb-6 flex items-center justify-center bg-slate-50 rounded-2xl relative overflow-hidden border border-slate-100 group-hover:border-secondary/30 transition duration-300">
                            <?php if(!empty($uni['university_logo'])): ?>
                                <img src="uploads/universities/<?php echo htmlspecialchars($uni['university_logo']); ?>" class="max-w-[75%] max-h-[75%] object-contain grayscale group-hover:grayscale-0 group-hover:scale-110 transition duration-500">
                            <?php else: ?>
                                <i class="ph ph-graduation-cap text-6xl text-slate-300 group-hover:text-secondary transition duration-300 group-hover:scale-110"></i>
                            <?php endif; ?>
                        </div>
                        
                        <p class="text-xs font-bold text-secondary uppercase tracking-widest mb-3 flex items-center justify-center gap-1 bg-orange-50 px-3 py-1 rounded-full">
                            <i class="ph-fill ph-map-pin"></i> <?php echo htmlspecialchars($uni['country'] ?? ''); ?>
                        </p>
                        
                        <h3 class="text-xl font-bold text-slate-800 mb-6 group-hover:text-secondary transition min-h-[3.5rem] flex items-center justify-center leading-snug w-full">
                            <a href="university-<?php echo $uni['id']; ?>-<?php echo slugify($uni['university_name']); ?>" class="before:absolute before:inset-0"><?php echo htmlspecialchars($uni['university_name']); ?></a>
                        </h3>
                        
                        <div class="mt-auto pt-4 w-full border-t border-slate-100 flex items-center justify-center">
                            <span class="text-secondary font-bold group-hover:text-accent flex items-center justify-center gap-2 transition translate-y-2 opacity-80 group-hover:translate-y-0 group-hover:opacity-100">
                                Explore University <i class="ph ph-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- No Results Message -->
            <div id="noResults" class="hidden text-center py-20 w-full col-span-full">
                <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-400 text-4xl shadow-inner">
                    <i class="ph ph-magnifying-glass-minus"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-700 mb-2">No Universities Found</h3>
                <p class="text-slate-500 text-lg max-w-md mx-auto">Try adjusting your search criteria or selecting a different destination.</p>
            </div>
            
        <?php else: ?>
            <div class="text-center py-32 bg-white rounded-[3rem] shadow-sm border border-slate-100">
                <div class="w-28 h-28 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-8 text-secondary text-5xl">
                    <i class="ph ph-buildings"></i>
                </div>
                <h2 class="text-3xl font-bold text-slate-800 mb-4">No Universities Listed</h2>
                <p class="text-slate-500 text-lg">Our extensive network is currently being compiled. Please check back shortly.</p>
            </div>
        <?php endif; ?>
        
    </div>
</section>

<!-- Call to Action -->
<section class="py-24 bg-dark text-center relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-secondary/50 to-transparent"></div>
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-multiply"></div>
    <div class="container mx-auto px-4 max-w-3xl relative z-10">
        <h2 class="text-3xl md:text-5xl font-bold text-white mb-6 leading-tight">Didn't find what you were looking for?</h2>
        <p class="text-slate-400 text-lg mb-10 font-light">We represent hundreds of exclusive universities globally. Connect with an expert counselor today, and we will tailor-match a program specifically to your profile.</p>
        <a href="appointment" class="bg-secondary hover:bg-accent text-white px-10 py-4 rounded-full font-bold transition shadow-lg shadow-secondary/30 inline-flex items-center gap-2 text-lg hover:-translate-y-1 transform duration-300">
            Book a Free Session <i class="ph ph-calendar-check text-xl"></i>
        </a>
    </div>
</section>

<!-- Filter Logic -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('uniSearch');
    const tabs = document.querySelectorAll('.tab-btn');
    const cards = document.querySelectorAll('.uni-card');
    const noResults = document.getElementById('noResults');
    let activeTab = '<?php echo $active_country; ?>';
    
    function filterUniversities() {
        if(!searchInput) return;
        const query = searchInput.value.toLowerCase().trim();
        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            const country = card.getAttribute('data-country').toLowerCase();
            const rawCountry = card.getAttribute('data-country');
            
            // Tab condition
            const matchesTab = activeTab === 'All' || rawCountry === activeTab;
            
            // Search condition
            const matchesSearch = name.includes(query) || country.includes(query);
            
            if (matchesTab && matchesSearch) {
                card.style.display = 'flex';
                // slight reset to trigger animation
                card.style.animation = 'none';
                card.offsetHeight; // trigger reflow
                card.style.animation = 'fadeIn 0.5s ease forwards';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
        } else {
            noResults.classList.add('hidden');
        }
    }

    // Search Listener
    if(searchInput) {
        searchInput.addEventListener('input', filterUniversities);
    }

    // Tabs Listener
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Update active tab styling
            tabs.forEach(t => {
                t.classList.remove('bg-secondary', 'text-white', 'border-secondary', 'shadow-lg', 'shadow-orange-500/20', 'active-tab');
                t.classList.add('bg-transparent', 'text-slate-500', 'border-slate-200', 'hover:border-secondary', 'inactive-tab');
            });
            this.classList.remove('bg-transparent', 'text-slate-500', 'border-slate-200', 'hover:border-secondary', 'inactive-tab');
            this.classList.add('bg-secondary', 'text-white', 'border-secondary', 'shadow-lg', 'shadow-orange-500/20', 'active-tab');
            
            activeTab = this.getAttribute('data-target');
            filterUniversities();
        });
    });
    
    // Initial run in case of ?country parameter
    filterUniversities();
});
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
