-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2026 at 12:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `antygravity_ugs`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`id`, `company_name`, `about_company`, `mission`, `vision`, `email`, `phone`, `address`, `whatsapp`, `country`, `university`, `student`, `happy_smile`, `logo`, `favicon`, `partner_names`, `partner_logos`) VALUES
(1, 'Unilink Global Solution LTD', 'I am delighted to recommend DANNY LUCKY ABAYISENGA (Registration Number: 18300/2021), a graduate of the University of Lay Adventists of Kigali (UNILAK), who completed his Bachelor’s degree in Finance in 2025. Beyond his academic work, he has shown strong involvement in practical and co-curricular activities. His participation in internship programs and coursework-related projects demonstrates his ability to apply theoretical knowledge in real-world situations. He has shown excellent organizational skills and a strong sense of responsibility while working on assignments and collaborative tasks. He is a cooperative individual who works well with peers and contributes positively to group activities. His disciplined approach and consistent effort reflect his determination to achieve personal and professional growth. Additionally, he maintains a positive attitude and demonstrates reliability in all assigned responsibilities. His ability to manage time effectively and remain focused under pressure is commendable. I am confident that he will continue to perform successfully in future endeavors.', 'I am delighted to recommend DANNY LUCKY ABAYISENGA (Registration Number: 18300/2021), a graduate of the University of Lay Adventists of Kigali (UNILAK), who completed his Bachelor’s degree in Finance in 2025. Beyond his academic work, he has shown strong involvement in practical and co-curricular activities. His participation in internship programs and coursework-related projects ', 'I am delighted to recommend DANNY LUCKY ABAYISENGA (Registration Number: 18300/2021), a graduate of the University of Lay Adventists of Kigali (UNILAK), who completed his Bachelor’s degree in Finance in 2025. Beyond his academic work, he has shown strong involvement in practical and co-curricular activities. His participation in internship programs and coursework-related projects ', 'support@unilinkgs.com', '01776323859', '6th Floor, House, 404 Rd 29, Banani, Dhaka', '01776323859', 7, 156, 25698, 25621, '69d62214ce70c1775641108.webp', '69d62214cec141775641108.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `achievement`
--

CREATE TABLE `achievement` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `position` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `permissions` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `phone`, `username`, `password`, `permissions`, `created_at`) VALUES
(1, 'Mehedi Hasan (Superadmin)', 'mehedimridul1919@gmail.com', '01776323859', 'Mehedi19', '$2y$10$UZk0iPSxAk14hl/Xv01hf.cE/MbitOlMYMznQVr.J65EL187o3zou', '[\"all\"]', '2026-04-08 04:58:35');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `name`, `email`, `phone`, `address`, `last_academic_education`, `passing_year`, `department`, `institution_name`, `english_test`, `test_name`, `test_results`, `planned_exam_date`, `degree`, `interest_country`, `interested_course`, `created_at`) VALUES
(1, 'MD Mehedi Hasan', 'mehedihasan19191313@gmail.com', '01776323859', 'Mohakhali DOHS', 'Bachelor', '2027', 'CSE', 'Primeasia University', 'Yes', 'IELTS', '8.00', NULL, 'Masters', 'Australia', 'AI', '2026-04-08 09:07:10');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `likes` int(11) DEFAULT 0,
  `shares` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `image`, `title`, `content`, `seo_title`, `seo_description`, `likes`, `shares`, `created_at`) VALUES
(2, '69d5fdfbd1bdc1775631867.png', 'how to get admission in oxfo!rd university from bangladesh', '<h2>Overview of how to get admission in oxford university from bangladesh</h2><p>In today\'s fast-paced world, <strong>how to get admission in oxford university from bangladesh</strong> has become a cornerstone of success. This article explores how it impacts the industry and why it matters to you.</p><ul><li>Reason 1: Innovation and growth</li><li>Reason 2: Academic excellence</li><li>Reason 3: Global opportunities</li></ul><p>By focusing on These key areas, Unilink Global Solution helps you achieve your goals with <em>professionalism</em> and <em>integrity</em>.</p>', 'how to get admission in oxford university from bangladesh', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &amp;amp;amp;quot;de Finibus Bonorum et Malorum&amp;amp;amp;quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &amp;amp;amp;quot;Lorem ipsum dolor sit amet..&amp;amp;amp;quot;, comes from a line in section 1.10.32.', 1, 0, '2026-04-08 06:27:33');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_comments`
--

INSERT INTO `blog_comments` (`id`, `blog_id`, `name`, `comment`, `created_at`) VALUES
(1, 2, 'rakib hasan', 'nice blogs. really helpful and good', '2026-04-08 09:49:51');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_leads`
--

CREATE TABLE `chatbot_leads` (
  `id` int(11) NOT NULL,
  `topic` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `country` varchar(100) NOT NULL,
  `course` varchar(200) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chatbot_leads`
--

INSERT INTO `chatbot_leads` (`id`, `topic`, `name`, `email`, `phone`, `address`, `country`, `course`, `created_at`) VALUES
(1, 'Admission', 'Md. Rahim Uddin', 'Not Provided', '01776323859', 'hi', '', '', '2026-04-08 14:59:19'),
(2, 'Admission', 'Test User', 'Not Provided', '1234567890', 'Test message from Jetski.', '', '', '2026-04-09 16:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `country_image` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `country_name` varchar(255) DEFAULT NULL,
  `about_country` text DEFAULT NULL,
  `study_opportunity` text DEFAULT NULL,
  `admission_requirements` text DEFAULT NULL,
  `lifestyle_culture` text DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `country_image`, `banner_image`, `country_name`, `about_country`, `study_opportunity`, `admission_requirements`, `lifestyle_culture`, `position`) VALUES
(1, '69d76a2f309dc1775725103.webp', '69d76a2f30e0f1775725103.webp', 'Malaysia', 'Malaysia is an affordable and growing study destination for international students. It offers a high-quality education system with partnerships from UK, Australia, and other global universities. The country is known for its multicultural environment, modern cities, and friendly people. Kuala Lumpur is a popular student city with advanced infrastructure and a comfortable lifestyle. Malaysia provides internationally recognized degrees at lower tuition costs compared to many Western countries. English is widely used in education, making it easier for international students to study and communicate. The country also offers a safe and welcoming environment with a mix of modern and traditional culture. It is an ideal choice for students looking for quality education at a reasonable cost.', 'Malaysia offers a wide range of programs in business, IT, engineering, hospitality, and health sciences. Many universities have international branch campuses, allowing students to earn global degrees at a lower cost. Students can transfer credits and complete part of their studies abroad. The education system focuses on practical learning and industry skills. Some programs include internships to gain real-world experience. Malaysia also provides flexible study options and affordable living expenses. Scholarships and financial support are available for international students. The country’s strong academic partnerships increase global exposure and career opportunities.', 'Students need academic certificates and transcripts from previous studies. English proficiency tests like IELTS or TOEFL are usually required, though some institutions may waive this if prior education was in English. A Statement of Purpose (SOP) and passport copy are needed. Some courses may require additional documents like portfolios. Financial proof is required to show the ability to cover tuition and living expenses. After receiving an offer letter, students must apply for a student visa. Medical check-ups and documentation verification are part of the process. The admission process is generally simple and student-friendly.', 'Malaysia offers a comfortable and affordable lifestyle for students. It is a multicultural country with Malay, Chinese, and Indian influences. Food is diverse, delicious, and budget-friendly. Students can enjoy modern shopping malls, public transport, and entertainment options. The weather is warm throughout the year. People are friendly and welcoming, making it easy to adjust. Students can explore beaches, islands, and cultural landmarks. The lifestyle is relaxed and safe, allowing students to focus on their studies while enjoying their time abroad.', 1),
(2, '69d76988aed641775724936.webp', '69d76988af57f1775724936.webp', 'Australia', 'Australia is one of the most popular study destinations for international students. It is known for its high-quality education system, modern lifestyle, and multicultural environment. The country has world-ranked universities, advanced research facilities, and globally recognized degrees. Cities like Sydney, Melbourne, and Brisbane offer a safe and student-friendly atmosphere. Australia also provides strong support services for international students, making it easier to adapt to a new environment. The education system focuses on practical learning, critical thinking, and career development. Students can also work part-time during their studies, which helps manage expenses. With beautiful landscapes, beaches, and a welcoming society, Australia offers a balanced academic and personal life experience.', 'Australia offers a wide range of courses including business, engineering, IT, health sciences, and creative arts. Universities provide flexible study options and modern teaching methods. Many programs include internships and industry placements, helping students gain real-world experience. International students can work up to a certain number of hours per week, which supports living costs. After graduation, students may apply for post-study work opportunities depending on their qualification. Scholarships are also available based on merit and academic performance. The country has strong links with global industries, which improves job opportunities after graduation. English is the main language, so students can easily communicate and build global networks.', 'To study in Australia, students must meet academic and English language requirements. A valid academic certificate from previous studies is required. English proficiency tests like IELTS, TOEFL, or PTE are commonly accepted. Students must provide a Statement of Purpose (SOP) explaining their study goals. Some courses may require additional documents like portfolios or work experience. Financial proof is necessary to show the ability to cover tuition and living expenses. A valid passport and health insurance are also required. After receiving an offer letter, students must apply for a student visa and complete biometric and medical checks. Meeting all requirements ensures a smooth admission process.', 'Australia offers a relaxed and friendly lifestyle. People are open, supportive, and culturally diverse. Students can enjoy a balanced life with study, part-time work, and social activities. The country has a strong outdoor culture, including beaches, parks, and sports. Public transport is well developed, making travel easy. Food options are diverse due to the multicultural population. Students feel safe due to low crime rates and strong laws. Festivals, events, and student communities help build connections. The lifestyle promotes independence and personal growth. Overall, Australia provides a welcoming and enjoyable environment for international students.', 2),
(3, '69d76b1a82eeb1775725338.webp', '69d76b1a830c01775725338.webp', 'New Zealand', 'New Zealand is known for its peaceful environment, high-quality education, and natural beauty. It offers globally recognized degrees and a supportive academic system. Cities like Auckland and Wellington provide a safe and student-friendly atmosphere. The country focuses on research, innovation, and practical learning. New Zealand is less crowded, which creates a calm and focused study environment. It is also known for its welcoming people and strong student support services. The education system encourages critical thinking and independent learning. With mountains, lakes, and green landscapes, students enjoy both academic and personal growth.', 'New Zealand offers programs in engineering, IT, agriculture, business, and environmental studies. Universities provide modern teaching methods and research opportunities. Students can work part-time during studies to support their expenses. Many programs include internships and practical training. After graduation, students may apply for post-study work opportunities. Scholarships are available based on academic performance. The country has strong links with industries, which helps students gain job opportunities. English is the main language, making communication easy for international students.', 'Students must provide academic transcripts and certificates from previous education. English language tests like IELTS or TOEFL are required. A Statement of Purpose (SOP) is needed to explain study goals. Some courses may require additional documents such as portfolios or work experience. Financial proof is required to cover tuition and living costs. A valid passport and health insurance are also necessary. After receiving an offer letter, students must apply for a student visa and complete medical checks. Proper documentation ensures a smooth process.', 'New Zealand offers a relaxed and peaceful lifestyle. People are friendly, respectful, and welcoming. The country has a strong outdoor culture, including hiking, sports, and nature activities. Students enjoy clean cities and a safe environment. Public transport is available, though many people prefer personal travel. The culture values balance between work and life. Students can participate in community events and cultural activities. Overall, New Zealand provides a calm and supportive environment for studying and living.', 3),
(4, '69d76eca69f3c1775726282.webp', '69d76eca6a4ab1775726282.webp', 'Canada', 'Canada is a top destination for international students due to its high-quality education and welcoming environment. It is known for safety, diversity, and strong academic standards. Universities and colleges offer globally recognized degrees with modern facilities. Cities like Toronto, Vancouver, and Montreal are student-friendly and culturally rich. Canada focuses on research, innovation, and practical learning. The country has a strong economy and provides excellent career opportunities after graduation. Students can work part-time while studying, which helps manage expenses. The natural beauty of Canada, including mountains and lakes, adds to its appeal. It is considered one of the safest countries in the world.', 'Canada offers a wide range of programs in business, engineering, IT, healthcare, and more. Institutions provide co-op programs and internships, allowing students to gain real-world experience. Students can work part-time during studies and full-time during scheduled breaks. After graduation, many students apply for post-graduation work permits. Scholarships and financial aid options are available for international students. Canada’s education system is flexible and focuses on skill development. English and French are widely used, giving students a chance to learn in a bilingual environment. Strong industry connections help students find jobs after completing their studies.', 'Students need academic certificates, transcripts, and English proficiency test results like IELTS or TOEFL. Some institutions may require additional tests or portfolios depending on the course. A Statement of Purpose (SOP) and recommendation letters are often required. Financial proof is necessary to show the ability to cover tuition and living costs. Students must also provide a valid passport and medical documents. After receiving an offer letter, students apply for a study permit. Biometric data and visa processing steps must be completed. Meeting all requirements ensures a smooth admission process.', 'Canada offers a high quality of life with a safe and peaceful environment. It is a multicultural country where people from different backgrounds live together. Students enjoy modern facilities, clean cities, and excellent healthcare services. The lifestyle is balanced, with opportunities for study, work, and leisure. Winter can be cold, but students adapt easily with proper preparation. Public transport is reliable, and cities are well organized. Festivals, cultural events, and student communities help students feel at home. Canada provides a welcoming and supportive environment for international students.', 4),
(5, '69d76f07164611775726343.webp', '69d76f07166921775726343.webp', 'United State of America', 'The United States is one of the most popular study destinations in the world. It has top-ranked universities, advanced research facilities, and diverse academic programs. The country offers a flexible education system that allows students to choose their subjects and majors. Cities like New York, Los Angeles, and Chicago provide global exposure and career opportunities. The USA is known for innovation, technology, and academic excellence. Students from all over the world come here for higher education. The degrees are globally recognized, and the country offers strong professional growth opportunities.', 'The USA offers a wide range of programs in almost every field, including business, IT, engineering, medicine, and arts. Universities provide modern teaching methods, research opportunities, and internships. Students can work part-time on campus during their studies. Many programs include practical training like OPT (Optional Practical Training). Scholarships and financial aid are available for international students. The education system focuses on creativity, innovation, and skill development. Strong industry connections help students build successful careers after graduation.', 'Students need academic transcripts, certificates, and English proficiency test scores like IELTS or TOEFL. Some universities require standardized tests like SAT, GRE, or GMAT. A Statement of Purpose (SOP) and recommendation letters are essential. Financial proof is required to show the ability to cover expenses. Students must also provide a valid passport. After receiving an offer letter, students apply for a student visa and attend a visa interview. Proper preparation is important for a successful application.', 'The USA offers a diverse and dynamic lifestyle. It is a multicultural country with people from different backgrounds. Students can experience modern cities, entertainment, and global culture. The lifestyle is fast-paced but full of opportunities. Public transport is available in major cities. Students can join clubs, events, and networking programs. Food, culture, and traditions vary across regions. The country encourages independence and personal growth. Overall, students gain valuable life and career experience.', 5);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `event_image` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_registration`
--

CREATE TABLE `event_registration` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `caption` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `position` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hero`
--

CREATE TABLE `hero` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` text DEFAULT NULL,
  `button_text` varchar(50) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `button2_text` varchar(255) DEFAULT NULL,
  `button2_link` varchar(255) DEFAULT NULL,
  `position` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hero`
--

INSERT INTO `hero` (`id`, `title`, `subtitle`, `button_text`, `button_link`, `button2_text`, `button2_link`, `position`) VALUES
(2, 'Start Your Study Abroad Journey Today', 'Get expert guidance for university admission, visa processing, and career planning. We make your dream simple and achievable.', 'Get Free Consultation', 'appointment.php', 'Explore Universities', 'universities.php', 0),
(3, 'Your Future Begins With the Right Guidance', 'We help students choose the best country, university, and program based on their goals and budget.', 'Book Appointment', 'appointment.php', 'View Services', 'index.php', 1),
(4, 'Study Abroad Made Easy', 'From application to visa approval, our team supports you at every step with accuracy and care.', 'Apply Now', 'appointment.php', 'Contact Us', 'contact.php', 2),
(5, 'Turn Your Dream Into Reality', 'Join thousands of successful students who trusted us for their international education journey.', 'Start Your Journey', 'destinations.php', 'Success Stories', 'about.php', 3),
(6, 'Expert Support for Global Education', 'We provide complete solutions for admission, scholarships, SOP, and visa processing.', 'Get Started', 'contact.php', 'Learn More', 'universities.php', 4);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_location` varchar(255) DEFAULT NULL,
  `logo` varchar(255) NOT NULL,
  `partnered_from` date DEFAULT NULL,
  `details` text DEFAULT NULL,
  `position` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `icon_class` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `position` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `image`, `title`, `icon_class`, `details`, `position`, `created_at`) VALUES
(6, '', 'University Admission Support', 'fa-solid fa-graduation-cap', 'We help you choose the right university and program. Our team handles your application process with accuracy and care.', 0, '2026-04-09 06:36:40'),
(7, '', 'Student Visa Processing', 'fa-solid fa-passport', 'Get complete support for visa application, documentation, and interview preparation to increase your success rate.', 1, '2026-04-09 06:37:05'),
(8, '', 'SOP &amp; Documentation', 'fa-solid fa-file-lines', 'We create professional SOP, LOR, and other documents that meet university requirements and improve acceptance chances.', 2, '2026-04-09 06:37:25'),
(9, '', 'Scholarship Guidance', 'fa-solid fa-award', 'Find the best scholarship opportunities based on your profile and reduce your study costs significantly.', 3, '2026-04-09 06:37:40'),
(10, '', 'Career &amp; Course Counseling', 'fa-solid fa-user-graduate', 'Get personalized advice to choose the best course and career path according to your future goals.', 4, '2026-04-09 06:37:55');

-- --------------------------------------------------------

--
-- Table structure for table `social_media`
--

CREATE TABLE `social_media` (
  `id` int(11) NOT NULL,
  `social_media_name` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriber`
--

CREATE TABLE `subscriber` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscriber`
--

INSERT INTO `subscriber` (`id`, `email`, `created_at`) VALUES
(1, 'mehedihasan19191313@gmail.com', '2026-04-08 09:00:12');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `team_name` varchar(100) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `say` text DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `certified_by` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `profile_image`, `name`, `team_name`, `designation`, `say`, `joining_date`, `blood_group`, `certified_by`, `position`) VALUES
(1, '69d737be32ddb1775712190.png', 'MD Mehedi Hasan', 'IT', 'Developer', '', '2026-02-01', 'O+', 'Unilink Global Solution', 1);

-- --------------------------------------------------------

--
-- Table structure for table `testimonial`
--

CREATE TABLE `testimonial` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `role` enum('teacher','student','parents') DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `university`
--

CREATE TABLE `university` (
  `id` int(10) UNSIGNED NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `working_process`
--

CREATE TABLE `working_process` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `position` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `working_process`
--

INSERT INTO `working_process` (`id`, `title`, `details`, `position`) VALUES
(1, 'File Assessment', 'We review your academic background and supporting documents to match the best countries and universities for you. Profile evaluation and eligibility check, university and course recommendations, and free consultation and feedback are included.', 1),
(2, 'Apply for Offer', 'We help you prepare and submit a perfect application for your chosen institutions. This includes application form completion, document verification and submission, and priority handling for quick response.', 2),
(3, 'GS/GT Clearance', 'Our experts guide you through Genuine Student and Genuine Temporary Entrant assessments with full preparation. We provide mock interviews and review sessions, Statement of Purpose (SOP) guidance, and ensure compliance with visa criteria.', 3),
(4, 'Visa Application', 'We handle your entire visa process with precision and care for maximum approval chances. This includes visa document preparation, financial and medical guidance, and interview scheduling and support.', 4),
(5, 'Take Off to University', 'Get ready for your dream journey. We assist you from ticket booking to pre-departure orientation, including flight booking assistance, pre-departure briefing, and travel checklist with safety tips.', 5),
(6, 'Airport Pickup', 'Our international partners ensure a smooth welcome upon your arrival abroad. This includes on-arrival pickup service, assistance with luggage and transfer, and friendly guidance to your accommodation.', 6),
(7, 'Accommodation', 'We arrange secure, comfortable, and affordable housing options for you near campus. This includes on-campus and off-campus options, host family or shared apartment setup, and advance booking with rent support.', 7),
(8, 'Stand for Solving Any Problem', 'Even after your departure, our support never ends. We provide 24/7 student support hotline, emergency assistance and guidance, and continuous follow-up and care.', 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `achievement`
--
ALTER TABLE `achievement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chatbot_leads`
--
ALTER TABLE `chatbot_leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_registration`
--
ALTER TABLE `event_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hero`
--
ALTER TABLE `hero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_media`
--
ALTER TABLE `social_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriber`
--
ALTER TABLE `subscriber`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `university`
--
ALTER TABLE `university`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `working_process`
--
ALTER TABLE `working_process`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `achievement`
--
ALTER TABLE `achievement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chatbot_leads`
--
ALTER TABLE `chatbot_leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_registration`
--
ALTER TABLE `event_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hero`
--
ALTER TABLE `hero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `social_media`
--
ALTER TABLE `social_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriber`
--
ALTER TABLE `subscriber`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonial`
--
ALTER TABLE `testimonial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `university`
--
ALTER TABLE `university`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `working_process`
--
ALTER TABLE `working_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
