<?php
// components/header.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

// Fetch global state from about table
$about = null;
try {
    $about = $pdo->query("SELECT * FROM about LIMIT 1")->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {}

$site_title = !empty($about['company_name']) ? $about['company_name'] : "Unilink Global Solution";
$site_email = !empty($about['email']) ? $about['email'] : "info@unilinkglobal.com";
$site_phone = !empty($about['phone']) ? $about['phone'] : "+880 1234-567890";
// Add fallback logo if DB doesn't have one
$site_logo = !empty($about['logo']) ? 'uploads/about/' . $about['logo'] : null;
$site_favicon = !empty($about['favicon']) ? 'uploads/about/' . $about['favicon'] : null;
$site_whatsapp = !empty($about['whatsapp']) ? preg_replace('/[^0-9]/', '', $about['whatsapp']) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - <?php echo htmlspecialchars($site_title); ?></title>
    <?php if($site_favicon): ?>
    <link rel="icon" type="image/x-icon" href="<?php echo htmlspecialchars($site_favicon); ?>">
    <?php endif; ?>
    
    <!-- Meta Tags -->
    <meta name="description" content="Unilink Global Solution - Your Partner for Higher Education Abroad.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
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

    <!-- Top Bar (Optional, like Email/Phone) -->
    <div class="bg-dark text-slate-300 py-2 text-xs sm:text-sm">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1"><i class="ph ph-envelope"></i> <?php echo htmlspecialchars($site_email); ?></span>
                <span class="hidden sm:flex items-center gap-1"><i class="ph ph-phone"></i> <?php echo htmlspecialchars($site_phone); ?></span>
            </div>
            <div class="flex items-center gap-3">
                <a href="#" class="hover:text-secondary transition"><i class="ph ph-facebook-logo"></i></a>
                <a href="#" class="hover:text-secondary transition"><i class="ph ph-twitter-logo"></i></a>
                <a href="#" class="hover:text-secondary transition"><i class="ph ph-instagram-logo"></i></a>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <header id="main-header" class="sticky top-0 z-50 transition-all duration-300 bg-white shadow-sm">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Logo -->
            <a href="index.php" class="flex items-center gap-2 group max-h-12">
                <?php if($site_logo): ?>
                    <img src="<?php echo htmlspecialchars($site_logo); ?>" alt="Logo" class="max-h-12 w-auto object-contain">
                <?php else: ?>
                    <div class="w-10 h-10 bg-secondary rounded-xl flex items-center justify-center text-white font-bold text-xl group-hover:bg-accent transition transform shadow-lg">
                        U
                    </div>
                    <span class="text-xl font-bold text-dark tracking-tight">Unilink <span class="text-secondary">Global</span></span>
                <?php endif; ?>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-8 font-medium">
                <a href="index.php" class="text-secondary transition">Home</a>
                <a href="about.php" class="hover:text-secondary transition">About</a>
                <a href="services.php" class="hover:text-secondary transition">Services</a>
                <a href="destinations.php" class="hover:text-secondary transition">Destinations</a>
                <a href="blog.php" class="hover:text-secondary transition">Blog</a>
            </nav>

            <!-- Book Appointment CTA -->
            <div class="hidden md:block">
                <a href="appointment.php" class="bg-secondary hover:bg-accent text-white px-6 py-2.5 rounded-full font-semibold transition shadow-md hover:shadow-lg transform active:scale-95 flex items-center gap-2">
                    Book Now <i class="ph ph-calendar-check font-bold"></i>
                </a>
            </div>

            <!-- Mobile Menu Toggle -->
            <button id="mobile-menu-btn" class="md:hidden text-2xl text-dark">
                <i class="ph ph-list"></i>
            </button>
        </div>

        <!-- Mobile Nav (Hidden by default) -->
        <div id="mobile-nav" class="hidden absolute top-full left-0 w-full bg-white shadow-lg border-t border-slate-100 flex-col items-center py-4 gap-4 font-medium md:hidden">
            <a href="index.php" class="text-secondary">Home</a>
            <a href="about.php" class="hover:text-secondary">About</a>
            <a href="services.php" class="hover:text-secondary">Services</a>
            <a href="destinations.php" class="hover:text-secondary">Destinations</a>
            <a href="blog.php" class="hover:text-secondary">Blog</a>
            <a href="appointment.php" class="bg-secondary text-white px-6 py-2 rounded-full font-semibold mt-2">Book Now</a>
        </div>
    </header>

    <script>
        // Mobile Menu Toggle Logic
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
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
        window.addEventListener('scroll', function() {
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
