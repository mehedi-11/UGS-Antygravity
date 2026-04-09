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
    if(!empty($uni['country_name'])) {
        $countries[$uni['country_name']] = $uni['country_name'];
    }
}
$countries = array_values($countries);
sort($countries);

// If user came from destinations page, they might have ?country=StudyTarget
$active_country = $_GET['country'] ?? 'All';

?>

<!-- Page Header -->
<section class="relative bg-slate-50 py-24 lg:py-32 overflow-hidden border-b border-slate-100">
    <!-- Background Decoration -->
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-multiply"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-primary rounded-full filter blur-[150px] opacity-70"></div>
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-secondary rounded-full filter blur-[150px] opacity-20 translate-x-1/3 -translate-y-1/3"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-800 mb-4 animate-on-scroll">World-Class Universities</h1>
        <div class="flex items-center justify-center gap-2 text-slate-400 text-sm font-medium animate-on-scroll delay-100 mt-4">
            <a href="index.php" class="hover:text-secondary transition text-slate-500 font-bold">Home</a>
            <i class="ph ph-caret-right"></i>
            <a href="destinations.php" class="hover:text-secondary transition text-slate-500 font-bold">Destinations</a>
            <i class="ph ph-caret-right"></i>
            <span class="text-secondary font-bold">Universities</span>
        </div>
    </div>
</section>

<!-- Main Area -->
<section class="py-20 bg-slate-50 min-h-[60vh]">
    <div class="container mx-auto px-4">
        
        <?php if(!empty($universities)): ?>
            <!-- Controls Group: Search & Tabs -->
            <div class="mb-12 animate-on-scroll">
                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto mb-10 relative">
                    <input type="text" id="uniSearch" placeholder="Search by university name or country..." class="w-full px-6 py-4 pl-14 rounded-full border-2 border-slate-200 focus:border-secondary focus:ring-0 outline-none text-slate-600 shadow-sm text-lg transition">
                    <i class="ph ph-magnifying-glass absolute left-6 top-1/2 -translate-y-1/2 text-2xl text-slate-400"></i>
                </div>
                
                <!-- Country Tabs -->
                <div class="flex flex-wrap justify-center gap-3" id="uniTabs">
                    <button class="tab-btn px-6 py-2.5 rounded-full font-bold text-sm transition-all shadow-sm border <?php echo $active_country === 'All' ? 'bg-secondary text-white border-secondary' : 'bg-white text-slate-500 hover:text-secondary border-slate-200'; ?>" data-target="All">
                        All Destinations
                    </button>
                    <?php foreach($countries as $c): ?>
                        <button class="tab-btn px-6 py-2.5 rounded-full font-bold text-sm transition-all shadow-sm border <?php echo $active_country === $c ? 'bg-secondary text-white border-secondary' : 'bg-white text-slate-500 hover:text-secondary border-slate-200'; ?>" data-target="<?php echo htmlspecialchars($c); ?>">
                            <?php echo htmlspecialchars($c); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Universities Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8" id="uniGrid">
                <?php foreach($universities as $index => $uni): ?>
                    <div class="uni-card bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl transition duration-300 border border-slate-100 group flex flex-col text-center" 
                         data-country="<?php echo htmlspecialchars($uni['country_name']); ?>" 
                         data-name="<?php echo strtolower(htmlspecialchars($uni['university_name'])); ?>"
                         style="display: <?php echo ($active_country === 'All' || $active_country === $uni['country_name']) ? 'flex' : 'none'; ?>;">
                        
                        <!-- Uni Badge/Logo Wrapper -->
                        <div class="h-32 mb-6 flex items-center justify-center bg-slate-50 rounded-2xl relative overflow-hidden group-hover:bg-primary/10 transition">
                            <?php if($uni['image']): ?>
                                <img src="uploads/universities/<?php echo htmlspecialchars($uni['image']); ?>" class="max-w-[80%] max-h-[80%] object-contain group-hover:scale-110 transition duration-500">
                            <?php else: ?>
                                <i class="ph ph-buildings text-6xl text-slate-300"></i>
                            <?php endif; ?>
                        </div>
                        
                        <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-secondary transition min-h-[3.5rem] flex items-center justify-center leading-snug">
                            <a href="university-view.php?id=<?php echo $uni['id']; ?>"><?php echo htmlspecialchars($uni['university_name']); ?></a>
                        </h3>
                        
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-widest mb-4 flex items-center justify-center gap-1">
                            <i class="ph ph-map-pin text-secondary"></i> <?php echo htmlspecialchars($uni['country_name']); ?>
                        </p>
                        
                        <p class="text-slate-500 text-sm leading-relaxed mb-6 flex-grow line-clamp-3">
                            <?php echo htmlspecialchars($uni['details']); ?>
                        </p>
                        
                        <div class="mt-auto pt-4 border-t border-slate-100">
                            <a href="university-view.php?id=<?php echo $uni['id']; ?>" class="text-secondary font-bold hover:text-accent flex items-center justify-center gap-2 transition">
                                University Details <i class="ph ph-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- No Results Message -->
            <div id="noResults" class="hidden text-center py-16">
                <div class="w-20 h-20 bg-slate-200 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400 text-3xl">
                    <i class="ph ph-magnifying-glass-minus"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-600 mb-2">No Universities Found</h3>
                <p class="text-slate-500">Try adjusting your search criteria or selecting a different country.</p>
            </div>
            
        <?php else: ?>
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-slate-200 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-400 text-4xl">
                    <i class="ph ph-buildings"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-600 mb-2">No Universities Listed</h2>
                <p class="text-slate-500">Our database is being compiled. Please come back later.</p>
            </div>
        <?php endif; ?>
        
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-primary border-t border-slate-100 text-center">
    <div class="container mx-auto px-4 max-w-3xl">
        <h2 class="text-3xl font-bold text-dark mb-4">Didn't find what you were looking for?</h2>
        <p class="text-slate-600 mb-8">We represent hundreds of universities globally. Contact us and we will find the perfect program that matches your profile.</p>
        <a href="appointment.php" class="bg-secondary text-white hover:bg-accent px-8 py-3 rounded-full font-bold transition shadow-md inline-flex items-center gap-2">Book a Session <i class="ph ph-calendar-check"></i></a>
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
        searchInput.addEventListener('keyup', filterUniversities);
    }

    // Tabs Listener
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Update active tab styling
            tabs.forEach(t => {
                t.classList.remove('bg-secondary', 'text-white', 'border-secondary');
                t.classList.add('bg-white', 'text-slate-500', 'border-slate-200');
            });
            this.classList.remove('bg-white', 'text-slate-500', 'border-slate-200');
            this.classList.add('bg-secondary', 'text-white', 'border-secondary');
            
            activeTab = this.getAttribute('data-target');
            filterUniversities();
        });
    });
    
    // Initial run in case of ?country parameter
    filterUniversities();
});
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
