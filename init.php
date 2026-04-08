<?php
$host = "localhost";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create DB
    $pdo->exec("CREATE DATABASE IF NOT EXISTS antygravity_UGS CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database created or exists.\n";

    // Select DB
    $pdo->exec("USE antygravity_UGS");

    $sqls = [
        // Admin
        "CREATE TABLE IF NOT EXISTS `admin` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `name` varchar(255) NOT NULL,
          `email` varchar(255) NOT NULL,
          `phone` varchar(20) NOT NULL,
          `username` varchar(50) NOT NULL,
          `password` varchar(255) NOT NULL,
          `permissions` longtext DEFAULT NULL,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // About
        "CREATE TABLE IF NOT EXISTS `about` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `company_name` varchar(255) DEFAULT NULL,
          `about_company` text DEFAULT NULL,
          `mission` text DEFAULT NULL,
          `vision` text DEFAULT NULL,
          `email` varchar(255) DEFAULT NULL,
          `phone` varchar(100) DEFAULT NULL,
          `address` text DEFAULT NULL,
          `whatsapp` varchar(100) DEFAULT NULL,
          `country` int(11) DEFAULT NULL,
          `university` int(11) DEFAULT NULL,
          `student` int(11) DEFAULT NULL,
          `happy_smile` int(11) DEFAULT NULL,
          `logo` varchar(255) DEFAULT NULL,
          `favicon` varchar(255) DEFAULT NULL,
          `partner_names` longtext DEFAULT NULL,
          `partner_logos` longtext DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // Achievement
        "CREATE TABLE IF NOT EXISTS `achievement` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `image` varchar(255) NOT NULL,
          `name` varchar(255) NOT NULL,
          `details` text DEFAULT NULL,
          `position` int(11) DEFAULT 0,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // Appointment
        "CREATE TABLE IF NOT EXISTS `appointment` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `name` varchar(255) DEFAULT NULL,
          `email` varchar(255) DEFAULT NULL,
          `phone` varchar(20) DEFAULT NULL,
          `address` text DEFAULT NULL,
          `last_academic_education` varchar(255) DEFAULT NULL,
          `passing_year` varchar(10) DEFAULT NULL,
          `department` varchar(255) DEFAULT NULL,
          `institution_name` varchar(255) DEFAULT NULL,
          `english_test` varchar(10) DEFAULT NULL,
          `test_name` varchar(100) DEFAULT NULL,
          `test_results` varchar(100) DEFAULT NULL,
          `planned_exam_date` date DEFAULT NULL,
          `degree` varchar(100) DEFAULT NULL,
          `interest_country` varchar(100) DEFAULT NULL,
          `interested_course` varchar(255) DEFAULT NULL,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // Chatbot Leads
        "CREATE TABLE IF NOT EXISTS `chatbot_leads` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `topic` varchar(50) NOT NULL,
          `name` varchar(100) NOT NULL,
          `email` varchar(100) NOT NULL,
          `phone` varchar(50) NOT NULL,
          `address` text NOT NULL,
          `country` varchar(100) NOT NULL,
          `course` varchar(200) NOT NULL,
          `created_at` datetime DEFAULT current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // Country
        "CREATE TABLE IF NOT EXISTS `country` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `country_image` varchar(255) DEFAULT NULL,
          `banner_image` varchar(255) DEFAULT NULL,
          `country_name` varchar(255) DEFAULT NULL,
          `about_country` text DEFAULT NULL,
          `study_opportunity` text DEFAULT NULL,
          `admission_requirements` text DEFAULT NULL,
          `lifestyle_culture` text DEFAULT NULL,
          `position` int(11) NOT NULL DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // Event
        "CREATE TABLE IF NOT EXISTS `event` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `event_image` varchar(255) DEFAULT NULL,
          `title` varchar(255) DEFAULT NULL,
          `date_time` datetime DEFAULT NULL,
          `location` varchar(255) DEFAULT NULL,
          `description` text DEFAULT NULL,
          `position` int(11) NOT NULL DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // Event Registration
        "CREATE TABLE IF NOT EXISTS `event_registration` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `event_id` int(11) DEFAULT NULL,
          `name` varchar(255) DEFAULT NULL,
          `email` varchar(255) DEFAULT NULL,
          `phone` varchar(20) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // Gallery
        "CREATE TABLE IF NOT EXISTS `gallery` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `image` varchar(255) NOT NULL,
          `caption` text DEFAULT NULL,
          `location` varchar(255) DEFAULT NULL,
          `position` int(11) DEFAULT 0,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // Partners
        "CREATE TABLE IF NOT EXISTS `partners` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `company_name` varchar(255) NOT NULL,
          `company_location` varchar(255) DEFAULT NULL,
          `logo` varchar(255) NOT NULL,
          `partnered_from` date DEFAULT NULL,
          `details` text DEFAULT NULL,
          `position` int(11) DEFAULT 0,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // Social Media
        "CREATE TABLE IF NOT EXISTS `social_media` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `social_media_name` varchar(255) DEFAULT NULL,
          `link` varchar(255) DEFAULT NULL,
          `icon` varchar(100) DEFAULT NULL,
          `position` int(11) NOT NULL DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // Subscriber
        "CREATE TABLE IF NOT EXISTS `subscriber` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `email` varchar(255) NOT NULL,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // Team
        "CREATE TABLE IF NOT EXISTS `team` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `profile_image` varchar(255) DEFAULT NULL,
          `name` varchar(255) DEFAULT NULL,
          `team_name` varchar(100) DEFAULT NULL,
          `designation` varchar(255) DEFAULT NULL,
          `say` text DEFAULT NULL,
          `joining_date` date DEFAULT NULL,
          `blood_group` varchar(10) DEFAULT NULL,
          `certified_by` varchar(255) DEFAULT NULL,
          `position` int(11) NOT NULL DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // Testimonial
        "CREATE TABLE IF NOT EXISTS `testimonial` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `name` varchar(255) DEFAULT NULL,
          `role` enum('teacher','student','parents') DEFAULT NULL,
          `image` varchar(255) DEFAULT NULL,
          `message` text DEFAULT NULL,
          `position` int(11) NOT NULL DEFAULT 0,
          `status` enum('pending','approved','rejected') DEFAULT 'pending'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // University
        "CREATE TABLE IF NOT EXISTS `university` (
          `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `university_logo` varchar(255) DEFAULT NULL,
          `university_banner` varchar(255) DEFAULT NULL,
          `university_name` varchar(255) NOT NULL,
          `location` varchar(255) DEFAULT NULL,
          `country` varchar(100) NOT NULL,
          `about_university` text DEFAULT NULL,
          `student_facility` text DEFAULT NULL,
          `free_sections` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`free_sections`)),
          `position` int(10) UNSIGNED NOT NULL DEFAULT 0,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
          `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

        // Services (custom table user requested)
        "CREATE TABLE IF NOT EXISTS `services` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `image` varchar(255) DEFAULT NULL,
          `title` varchar(255) NOT NULL,
          `details` text DEFAULT NULL,
          `position` int(11) DEFAULT 0,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // Working Process (custom table user requested)
        "CREATE TABLE IF NOT EXISTS `working_process` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `title` varchar(255) NOT NULL,
          `details` text DEFAULT NULL,
          `position` int(11) DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // Blogs (custom table user requested)
        "CREATE TABLE IF NOT EXISTS `blogs` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `image` varchar(255) DEFAULT NULL,
          `title` varchar(255) NOT NULL,
          `content` longtext DEFAULT NULL,
          `seo_title` varchar(255) DEFAULT NULL,
          `seo_description` text DEFAULT NULL,
          `likes` int(11) DEFAULT 0,
          `shares` int(11) DEFAULT 0,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // Blog Comments
        "CREATE TABLE IF NOT EXISTS `blog_comments` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `blog_id` int(11) NOT NULL,
          `name` varchar(255) NOT NULL,
          `comment` text NOT NULL,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

        // Hero
        "CREATE TABLE IF NOT EXISTS `hero` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `image` varchar(255) DEFAULT NULL,
          `title` varchar(255) NOT NULL,
          `subtitle` text DEFAULT NULL,
          `button_text` varchar(50) DEFAULT NULL,
          `button_link` varchar(255) DEFAULT NULL,
          `position` int(11) DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;"
    ];

    foreach($sqls as $sql) {
        $pdo->exec($sql);
    }
    echo "Tables created successfully.\n";

    // Insert default super admin if nobody exists
    $stmt = $pdo->query("SELECT COUNT(*) FROM `admin`");
    if($stmt->fetchColumn() == 0) {
        $pass = password_hash('password123', PASSWORD_DEFAULT);
        // All permissions as simple JSON array
        $permissions = json_encode(['all']);
        $pdo->exec("INSERT INTO `admin` (`name`, `email`, `phone`, `username`, `password`, `permissions`) VALUES ('Super Admin', 'admin@unilink.com', '1234567890', 'admin', '$pass', '$permissions')");
        echo "Default admin created: admin / password123\n";
    }

} catch(PDOException $e) {
    die("DB Error: " . $e->getMessage());
}

$directories = [
    'admin/assets/css',
    'admin/assets/js',
    'admin/components',
    'admin/pages',
    'assets/css',
    'assets/js',
    'assets/images',
    'assets/plugins',
    'uploads/about',
    'uploads/gallery',
    'uploads/events',
    'uploads/countries',
    'uploads/team',
    'uploads/universities',
    'uploads/hero',
    'uploads/services',
    'uploads/blogs',
    'uploads/achievement',
    'uploads/partners',
    'config',
    'pages',
    'components'
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}
echo "Directories created successfully.\n";
?>
