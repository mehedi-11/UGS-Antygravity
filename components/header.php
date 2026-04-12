<?php
// components/header.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

// Fetch global state from about table
$about = null;
try {
    $about = $pdo->query("SELECT * FROM about LIMIT 1")->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
}

$site_title = !empty($about['company_name']) ? $about['company_name'] : "Unilink Global Solution";
$site_email = !empty($about['email']) ? $about['email'] : "info@unilinkglobal.com";
$site_phone = !empty($about['phone']) ? $about['phone'] : "+880 1234-567890";
// Add fallback logo if DB doesn't have one
$site_logo = !empty($about['logo']) ? 'uploads/about/' . $about['logo'] : null;
$site_favicon = !empty($about['favicon']) ? 'uploads/about/' . $about['favicon'] : null;
$site_whatsapp = !empty($about['whatsapp']) ? preg_replace('/[^0-9]/', '', $about['whatsapp']) : null;

// Fetch Social Media Links
$social_links = [];
try {
    $social_links = $pdo->query("SELECT * FROM social_media ORDER BY position ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - <?php echo htmlspecialchars($site_title); ?></title>
    <?php if ($site_favicon): ?>
        <link rel="icon" type="image/x-icon" href="<?php echo htmlspecialchars($site_favicon); ?>">
    <?php endif; ?>

    <!-- Meta Tags -->
    <meta name="description" content="Unilink Global Solution - Your Partner for Higher Education Abroad.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#f8fafc',
                        secondary: '#f97316', /* Orange */
                        accent: '#ea580c',
                        dark: '#1e293b'    /* Slate 800 */
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Swiper CSS (For Sliders) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <!-- Custom Style -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-primary text-slate-700 min-h-screen flex flex-col font-sans">

    <!-- Top Bar -->
    <div class="bg-dark text-slate-300 py-2 text-xs sm:text-sm">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="mailto:<?php echo htmlspecialchars($site_email); ?>" class="flex items-center gap-1 hover:text-secondary transition">
                    <i class="ph ph-envelope"></i> <?php echo htmlspecialchars($site_email); ?>
                </a>
                <a href="tel:<?php echo htmlspecialchars($site_phone); ?>" class="hidden sm:flex items-center gap-1 hover:text-secondary transition">
                    <i class="ph ph-phone"></i> <?php echo htmlspecialchars($site_phone); ?>
                </a>
                <?php if(!empty($about['address'])): ?>
                <a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode(strip_tags($about['address'])); ?>" target="_blank" class="hidden lg:flex items-center gap-1 hover:text-secondary transition">
                    <i class="ph ph-map-pin"></i> <?php echo htmlspecialchars(substr(strip_tags($about['address']), 0, 30)) . '...'; ?>
                </a>
                <?php endif; ?>
            </div>
            <div class="flex items-center gap-3">
                <?php foreach($social_links as $link): ?>
                    <a href="<?php echo htmlspecialchars($link['link']); ?>" target="_blank" class="hover:text-secondary transition" title="<?php echo htmlspecialchars($link['social_media_name']); ?>">
                        <i class="ph <?php echo htmlspecialchars($link['icon']); ?>"></i>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <header id="main-header" class="sticky top-0 z-50 transition-all duration-300 bg-white shadow-sm">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Logo -->
            <a href="index" class="flex items-center gap-2 group max-h-12">
                <?php if ($site_logo): ?>
                    <img src="<?php echo htmlspecialchars($site_logo); ?>" alt="Logo"
                        class="max-h-12 w-auto object-contain">
                <?php else: ?>
                    <div
                        class="w-10 h-10 bg-secondary rounded-xl flex items-center justify-center text-white font-bold text-xl group-hover:bg-accent transition transform shadow-lg">
                        U
                    </div>
                    <span class="text-xl font-bold text-dark tracking-tight">Unilink <span
                            class="text-secondary">Global</span></span>
                <?php endif; ?>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden lg:flex items-center gap-8 font-medium text-sm xl:text-base">
                <?php $current_page = basename($_SERVER['PHP_SELF'], ".php"); ?>
                <a href="index" class="hover:text-secondary transition <?php echo ($current_page == 'index' || $current_page == '') ? 'text-secondary font-bold' : ''; ?>">Home</a>
                
                <!-- About Dropdown -->
                <div class="relative group">
                    <button class="flex items-center gap-1 hover:text-secondary transition outline-none py-2 <?php echo in_array($current_page, ['about', 'team', 'testimonials', 'gallery', 'partners', 'services']) ? 'text-secondary font-bold' : ''; ?>">
                        About <i class="ph ph-caret-down text-sm transition-transform duration-300 group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute top-full left-0 mt-1 w-48 bg-white rounded-xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform -translate-y-2 group-hover:translate-y-0 flex flex-col py-2 z-50">
                        <a href="about" class="px-4 py-2 text-sm <?php echo $current_page == 'about' ? 'text-secondary font-bold' : 'text-slate-600'; ?> hover:text-secondary hover:bg-slate-50 transition">About Us</a>
                        <a href="team" class="px-4 py-2 text-sm <?php echo $current_page == 'team' ? 'text-secondary font-bold' : 'text-slate-600'; ?> hover:text-secondary hover:bg-slate-50 transition">Our Team</a>
                        <a href="testimonials" class="px-4 py-2 text-sm <?php echo $current_page == 'testimonials' ? 'text-secondary font-bold' : 'text-slate-600'; ?> hover:text-secondary hover:bg-slate-50 transition">Testimonials</a>
                        <a href="gallery" class="px-4 py-2 text-sm <?php echo $current_page == 'gallery' ? 'text-secondary font-bold' : 'text-slate-600'; ?> hover:text-secondary hover:bg-slate-50 transition">Gallery</a>
                        <a href="partners" class="px-4 py-2 text-sm <?php echo $current_page == 'partners' ? 'text-secondary font-bold' : 'text-slate-600'; ?> hover:text-secondary hover:bg-slate-50 transition">Partner</a>
                        <a href="services" class="px-4 py-2 text-sm <?php echo $current_page == 'services' ? 'text-secondary font-bold' : 'text-slate-600'; ?> hover:text-secondary hover:bg-slate-50 transition">Service</a>
                    </div>
                </div>

                <a href="destinations" class="hover:text-secondary transition <?php echo $current_page == 'destinations' ? 'text-secondary font-bold' : ''; ?>">Destination</a>
                <a href="universities" class="hover:text-secondary transition <?php echo $current_page == 'universities' ? 'text-secondary font-bold' : ''; ?>">University</a>
                <a href="events" class="hover:text-secondary transition <?php echo $current_page == 'events' ? 'text-secondary font-bold' : ''; ?>">Event</a>
                <a href="blog" class="hover:text-secondary transition <?php echo $current_page == 'blog' ? 'text-secondary font-bold' : ''; ?>">Blog</a>
                <a href="contact" class="hover:text-secondary transition <?php echo $current_page == 'contact' ? 'text-secondary font-bold' : ''; ?>">Contact</a>
            </nav>

            <!-- Book Appointment CTA -->
            <div class="hidden lg:block">
                <a href="appointment"
                    class="bg-secondary hover:bg-accent text-white px-6 py-2.5 rounded-full font-semibold transition shadow-md hover:shadow-lg transform active:scale-95 flex items-center gap-2 <?php echo $current_page == 'appointment' ? 'ring-2 ring-secondary ring-offset-2' : ''; ?>">
                    Book Now <i class="ph ph-calendar-check font-bold"></i>
                </a>
            </div>

            <!-- Mobile Menu Toggle -->
            <button id="mobile-menu-btn" class="lg:hidden text-2xl text-dark">
                <i class="ph ph-list"></i>
            </button>
        </div>

        <!-- Mobile Nav (Hidden by default) -->
        <div id="mobile-nav"
            class="hidden absolute top-full left-0 w-full bg-white shadow-lg border-t border-slate-100 flex-col items-center py-6 gap-4 font-medium lg:hidden max-h-[80vh] overflow-y-auto z-50">
            <a href="index" class="hover:text-secondary <?php echo ($current_page == 'index' || $current_page == '') ? 'text-secondary font-bold' : ''; ?>">Home</a>
            
            <div class="w-full text-center bg-slate-50 py-4 flex flex-col gap-3 border-y border-slate-100">
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">About & Services</p>
                <a href="about" class="text-sm <?php echo $current_page == 'about' ? 'text-secondary font-bold' : 'text-slate-600'; ?> hover:text-secondary">About Us</a>
                <a href="team" class="text-sm <?php echo $current_page == 'team' ? 'text-secondary font-bold' : 'text-slate-600'; ?> hover:text-secondary">Our Team</a>
                <a href="testimonials" class="text-sm <?php echo $current_page == 'testimonials' ? 'text-secondary font-bold' : 'text-slate-600'; ?> hover:text-secondary">Testimonials</a>
                <a href="gallery" class="text-sm <?php echo $current_page == 'gallery' ? 'text-secondary font-bold' : 'text-slate-600'; ?> hover:text-secondary">Gallery</a>
                <a href="partners" class="text-sm <?php echo $current_page == 'partners' ? 'text-secondary font-bold' : 'text-slate-600'; ?> hover:text-secondary">Partner</a>
                <a href="services" class="text-sm <?php echo $current_page == 'services' ? 'text-secondary font-bold' : 'text-slate-600'; ?> hover:text-secondary">Service</a>
            </div>

            <a href="destinations" class="hover:text-secondary <?php echo $current_page == 'destinations' ? 'text-secondary font-bold' : ''; ?>">Destination</a>
            <a href="universities" class="hover:text-secondary <?php echo $current_page == 'universities' ? 'text-secondary font-bold' : ''; ?>">University</a>
            <a href="events" class="hover:text-secondary <?php echo $current_page == 'events' ? 'text-secondary font-bold' : ''; ?>">Event</a>
            <a href="blog" class="hover:text-secondary <?php echo $current_page == 'blog' ? 'text-secondary font-bold' : ''; ?>">Blog</a>
            <a href="contact" class="hover:text-secondary <?php echo $current_page == 'contact' ? 'text-secondary font-bold' : ''; ?>">Contact</a>

            <a href="appointment"
                class="bg-secondary text-white px-8 py-3 rounded-full font-bold mt-4 shadow-lg shadow-secondary/20 active:scale-95 transition <?php echo $current_page == 'appointment' ? 'ring-2 ring-secondary ring-offset-2' : ''; ?>">Book Now</a>
        </div>
    </header>

    <script>
        // Mobile Menu Toggle Logic
        document.getElementById('mobile-menu-btn').addEventListener('click', function () {
            const nav = document.getElementById('mobile-nav');
            const icon = this.querySelector('i');
            nav.classList.toggle('hidden');
            nav.classList.toggle('flex');

            if (nav.classList.contains('hidden')) {
                icon.classList.replace('ph-x', 'ph-list');
            } else {
                icon.classList.replace('ph-list', 'ph-x');
            }
        });

        // Sticky Header effect on Scroll
        window.addEventListener('scroll', function () {
            const header = document.getElementById('main-header');
            if (window.scrollY > 20) {
                header.classList.add('glass', 'shadow-md');
                header.classList.remove('bg-white', 'shadow-sm');
            } else {
                header.classList.remove('glass', 'shadow-md');
                header.classList.add('bg-white', 'shadow-sm');
            }
        });
    </script>

    <main class="flex-grow">