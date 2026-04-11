-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2026 at 11:49 AM
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
(1, '69d9cd39c12cd1775881529.png', '69d76a2f30e0f1775725103.webp', 'Malaysia', 'Malaysia is an affordable and growing study destination for international students. It offers a high-quality education system with partnerships from UK, Australia, and other global universities. The country is known for its multicultural environment, modern cities, and friendly people. Kuala Lumpur is a popular student city with advanced infrastructure and a comfortable lifestyle. Malaysia provides internationally recognized degrees at lower tuition costs compared to many Western countries. English is widely used in education, making it easier for international students to study and communicate. The country also offers a safe and welcoming environment with a mix of modern and traditional culture. It is an ideal choice for students looking for quality education at a reasonable cost.', 'Malaysia offers a wide range of programs in business, IT, engineering, hospitality, and health sciences. Many universities have international branch campuses, allowing students to earn global degrees at a lower cost. Students can transfer credits and complete part of their studies abroad. The education system focuses on practical learning and industry skills. Some programs include internships to gain real-world experience. Malaysia also provides flexible study options and affordable living expenses. Scholarships and financial support are available for international students. The country’s strong academic partnerships increase global exposure and career opportunities.', 'Students need academic certificates and transcripts from previous studies. English proficiency tests like IELTS or TOEFL are usually required, though some institutions may waive this if prior education was in English. A Statement of Purpose (SOP) and passport copy are needed. Some courses may require additional documents like portfolios. Financial proof is required to show the ability to cover tuition and living expenses. After receiving an offer letter, students must apply for a student visa. Medical check-ups and documentation verification are part of the process. The admission process is generally simple and student-friendly.', 'Malaysia offers a comfortable and affordable lifestyle for students. It is a multicultural country with Malay, Chinese, and Indian influences. Food is diverse, delicious, and budget-friendly. Students can enjoy modern shopping malls, public transport, and entertainment options. The weather is warm throughout the year. People are friendly and welcoming, making it easy to adjust. Students can explore beaches, islands, and cultural landmarks. The lifestyle is relaxed and safe, allowing students to focus on their studies while enjoying their time abroad.', 1),
(2, '69d76988aed641775724936.webp', '69d76988af57f1775724936.webp', 'Australia', 'Australia is one of the most popular study destinations for international students. It is known for its high-quality education system, modern lifestyle, and multicultural environment. The country has world-ranked universities, advanced research facilities, and globally recognized degrees. Cities like Sydney, Melbourne, and Brisbane offer a safe and student-friendly atmosphere. Australia also provides strong support services for international students, making it easier to adapt to a new environment. The education system focuses on practical learning, critical thinking, and career development. Students can also work part-time during their studies, which helps manage expenses. With beautiful landscapes, beaches, and a welcoming society, Australia offers a balanced academic and personal life experience.', 'Australia offers a wide range of courses including business, engineering, IT, health sciences, and creative arts. Universities provide flexible study options and modern teaching methods. Many programs include internships and industry placements, helping students gain real-world experience. International students can work up to a certain number of hours per week, which supports living costs. After graduation, students may apply for post-study work opportunities depending on their qualification. Scholarships are also available based on merit and academic performance. The country has strong links with global industries, which improves job opportunities after graduation. English is the main language, so students can easily communicate and build global networks.', 'To study in Australia, students must meet academic and English language requirements. A valid academic certificate from previous studies is required. English proficiency tests like IELTS, TOEFL, or PTE are commonly accepted. Students must provide a Statement of Purpose (SOP) explaining their study goals. Some courses may require additional documents like portfolios or work experience. Financial proof is necessary to show the ability to cover tuition and living expenses. A valid passport and health insurance are also required. After receiving an offer letter, students must apply for a student visa and complete biometric and medical checks. Meeting all requirements ensures a smooth admission process.', 'Australia offers a relaxed and friendly lifestyle. People are open, supportive, and culturally diverse. Students can enjoy a balanced life with study, part-time work, and social activities. The country has a strong outdoor culture, including beaches, parks, and sports. Public transport is well developed, making travel easy. Food options are diverse due to the multicultural population. Students feel safe due to low crime rates and strong laws. Festivals, events, and student communities help build connections. The lifestyle promotes independence and personal growth. Overall, Australia provides a welcoming and enjoyable environment for international students.', 0),
(3, '69d76b1a82eeb1775725338.webp', '69d76b1a830c01775725338.webp', 'New Zealand', 'New Zealand is known for its peaceful environment, high-quality education, and natural beauty. It offers globally recognized degrees and a supportive academic system. Cities like Auckland and Wellington provide a safe and student-friendly atmosphere. The country focuses on research, innovation, and practical learning. New Zealand is less crowded, which creates a calm and focused study environment. It is also known for its welcoming people and strong student support services. The education system encourages critical thinking and independent learning. With mountains, lakes, and green landscapes, students enjoy both academic and personal growth.', 'New Zealand offers programs in engineering, IT, agriculture, business, and environmental studies. Universities provide modern teaching methods and research opportunities. Students can work part-time during studies to support their expenses. Many programs include internships and practical training. After graduation, students may apply for post-study work opportunities. Scholarships are available based on academic performance. The country has strong links with industries, which helps students gain job opportunities. English is the main language, making communication easy for international students.', 'Students must provide academic transcripts and certificates from previous education. English language tests like IELTS or TOEFL are required. A Statement of Purpose (SOP) is needed to explain study goals. Some courses may require additional documents such as portfolios or work experience. Financial proof is required to cover tuition and living costs. A valid passport and health insurance are also necessary. After receiving an offer letter, students must apply for a student visa and complete medical checks. Proper documentation ensures a smooth process.', 'New Zealand offers a relaxed and peaceful lifestyle. People are friendly, respectful, and welcoming. The country has a strong outdoor culture, including hiking, sports, and nature activities. Students enjoy clean cities and a safe environment. Public transport is available, though many people prefer personal travel. The culture values balance between work and life. Students can participate in community events and cultural activities. Overall, New Zealand provides a calm and supportive environment for studying and living.', 2),
(4, '69d76eca69f3c1775726282.webp', '69d76eca6a4ab1775726282.webp', 'Canada', 'Canada is a top destination for international students due to its high-quality education and welcoming environment. It is known for safety, diversity, and strong academic standards. Universities and colleges offer globally recognized degrees with modern facilities. Cities like Toronto, Vancouver, and Montreal are student-friendly and culturally rich. Canada focuses on research, innovation, and practical learning. The country has a strong economy and provides excellent career opportunities after graduation. Students can work part-time while studying, which helps manage expenses. The natural beauty of Canada, including mountains and lakes, adds to its appeal. It is considered one of the safest countries in the world.', 'Canada offers a wide range of programs in business, engineering, IT, healthcare, and more. Institutions provide co-op programs and internships, allowing students to gain real-world experience. Students can work part-time during studies and full-time during scheduled breaks. After graduation, many students apply for post-graduation work permits. Scholarships and financial aid options are available for international students. Canada’s education system is flexible and focuses on skill development. English and French are widely used, giving students a chance to learn in a bilingual environment. Strong industry connections help students find jobs after completing their studies.', 'Students need academic certificates, transcripts, and English proficiency test results like IELTS or TOEFL. Some institutions may require additional tests or portfolios depending on the course. A Statement of Purpose (SOP) and recommendation letters are often required. Financial proof is necessary to show the ability to cover tuition and living costs. Students must also provide a valid passport and medical documents. After receiving an offer letter, students apply for a study permit. Biometric data and visa processing steps must be completed. Meeting all requirements ensures a smooth admission process.', 'Canada offers a high quality of life with a safe and peaceful environment. It is a multicultural country where people from different backgrounds live together. Students enjoy modern facilities, clean cities, and excellent healthcare services. The lifestyle is balanced, with opportunities for study, work, and leisure. Winter can be cold, but students adapt easily with proper preparation. Public transport is reliable, and cities are well organized. Festivals, cultural events, and student communities help students feel at home. Canada provides a welcoming and supportive environment for international students.', 3),
(5, '69d76f07164611775726343.webp', '69d76f07166921775726343.webp', 'United State of America', 'The United States is one of the most popular study destinations in the world. It has top-ranked universities, advanced research facilities, and diverse academic programs. The country offers a flexible education system that allows students to choose their subjects and majors. Cities like New York, Los Angeles, and Chicago provide global exposure and career opportunities. The USA is known for innovation, technology, and academic excellence. Students from all over the world come here for higher education. The degrees are globally recognized, and the country offers strong professional growth opportunities.', 'The USA offers a wide range of programs in almost every field, including business, IT, engineering, medicine, and arts. Universities provide modern teaching methods, research opportunities, and internships. Students can work part-time on campus during their studies. Many programs include practical training like OPT (Optional Practical Training). Scholarships and financial aid are available for international students. The education system focuses on creativity, innovation, and skill development. Strong industry connections help students build successful careers after graduation.', 'Students need academic transcripts, certificates, and English proficiency test scores like IELTS or TOEFL. Some universities require standardized tests like SAT, GRE, or GMAT. A Statement of Purpose (SOP) and recommendation letters are essential. Financial proof is required to show the ability to cover expenses. Students must also provide a valid passport. After receiving an offer letter, students apply for a student visa and attend a visa interview. Proper preparation is important for a successful application.', 'The USA offers a diverse and dynamic lifestyle. It is a multicultural country with people from different backgrounds. Students can experience modern cities, entertainment, and global culture. The lifestyle is fast-paced but full of opportunities. Public transport is available in major cities. Students can join clubs, events, and networking programs. Food, culture, and traditions vary across regions. The country encourages independence and personal growth. Overall, students gain valuable life and career experience.', 4);

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

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `event_image`, `title`, `date_time`, `location`, `description`, `position`) VALUES
(1, '', 'Global Education Expo 2026', '2026-04-30 16:37:00', 'Dhaka, Bangladesh', 'The Global Education Expo 2026 is one of the largest international education events designed for students who are planning to study abroad. This event brings together representatives from top universities and colleges from countries such as Australia, Canada, the USA, the UK, Malaysia, and more. It provides a unique opportunity for students to interact directly with university delegates, ask questions, and receive accurate information about admission requirements, courses, tuition fees, and scholarship opportunities.\r\n\r\nAt this event, students will receive personalized counseling from experienced education consultants who will guide them in selecting the best course and destination based on their academic background and career goals. There will also be sessions focused on visa application processes, SOP writing, and interview preparation. Students can learn about the latest immigration policies and post-study work opportunities in different countries.\r\n\r\nIn addition, the expo will feature on-spot application opportunities where students can submit their documents and receive instant feedback. Special seminars and workshops will be conducted throughout the day to help students understand the entire study abroad journey. This event is ideal for students who want clear guidance, expert advice, and direct access to global education opportunities in one place.', 1),
(2, '', 'Study Abroad Seminar &amp; Career Counseling', '2026-04-25 18:40:00', 'Chattogram, Bangladesh', 'The Study Abroad Seminar & Career Counseling event is designed to help students make informed decisions about their higher education and future careers. This seminar focuses on providing detailed guidance on selecting the right country, university, and course based on individual goals and financial capacity. Experienced counselors will explain different study pathways and help students understand the admission process step by step.\r\n\r\nDuring the seminar, students will learn about popular study destinations such as Canada, Australia, the USA, Germany, and Malaysia. Experts will discuss eligibility criteria, required documents, English proficiency tests, and visa application procedures. The event will also include sessions on writing effective Statements of Purpose (SOP) and preparing strong academic profiles.\r\n\r\nStudents will have the opportunity to ask questions and receive personalized advice from professionals. The event also highlights scholarship opportunities and ways to manage study expenses abroad. By attending this seminar, students can gain a clear understanding of their options and build confidence in planning their international education journey. It is a valuable event for anyone looking to take the next step toward studying abroad.', 2),
(3, '', 'Visa Success Workshop &amp; Interview Preparation', '2026-04-30 07:38:00', 'Sylhet, Bangladesh', 'The Visa Success Workshop & Interview Preparation event is specially organized for students who are preparing for their student visa applications. This workshop provides in-depth guidance on how to complete visa documentation accurately and increase the chances of approval. Experts will explain common reasons for visa rejection and how to avoid them.\r\n\r\nThe event includes practical training sessions where students can learn how to answer interview questions confidently and professionally. Mock interview sessions will be conducted to help students understand real interview scenarios and improve their communication skills. Special attention will be given to GS/GT requirements, financial documentation, and SOP alignment with visa expectations.\r\n\r\nStudents will also receive guidance on preparing necessary documents such as bank statements, affidavits, and medical reports. The workshop ensures that students understand every step of the visa process clearly. By the end of the session, participants will feel more confident and prepared for their visa interviews. This event is highly beneficial for students who want expert support and a higher success rate in their visa applications.', 3);

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
(2, 'Start Your Study Abroad Journey Today', 'Get expert guidance for university admission, visa processing, and career planning. We make your dream simple and achievable.', 'Get Free Consultation', 'appointment.php', 'Explore Universities', 'universities.php', 1),
(3, 'Your Future Begins With the Right Guidance', 'We help students choose the best country, university, and program based on their goals and budget.', 'Book Appointment', 'appointment.php', 'View Services', 'index.php', 0),
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

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `company_name`, `company_location`, `logo`, `partnered_from`, `details`, `position`, `created_at`) VALUES
(1, 'Global Edu Connect', 'Sydney, Australia', '69d9bc158cd9a1775877141.jpg', '2026-04-01', 'Global Edu Connect is a trusted education partner based in Sydney, Australia, specializing in international student recruitment and academic support services. The company works closely with leading universities and colleges across Australia to provide students with accurate information, smooth admission processing, and personalized guidance. Their experienced team assists students in selecting suitable courses based on academic background, career goals, and financial capacity. They also provide support in application submission, document verification, and communication with institutions.\r\n\r\nGlobal Edu Connect is known for its transparent process and student-focused approach. They ensure that every student receives proper guidance at each stage of the journey, from initial consultation to final enrollment. The company also helps students understand visa requirements and compliance, reducing the chances of rejection. Their strong network with educational institutions allows them to offer updated information about programs, scholarships, and intakes. With a commitment to quality service, Global Edu Connect plays an important role in helping students successfully start their education journey in Australia.', 1, '2026-04-11 03:12:21'),
(2, 'Maple Leaf Education Services', 'Toronto, Canada', '69d9bc46c798f1775877190.png', '2026-04-02', 'Maple Leaf Education Services is a well-established consultancy firm located in Toronto, Canada. The company focuses on supporting international students in gaining admission to top Canadian universities and colleges. With years of experience in the education sector, they provide reliable and up-to-date guidance on academic programs, visa policies, and immigration procedures.\r\n\r\nTheir team offers complete support, including course selection, application processing, document preparation, and interview guidance. They maintain strong partnerships with multiple institutions, which helps students find suitable opportunities based on their profiles. Maple Leaf Education Services also provides assistance with post-arrival services such as accommodation guidance and settlement support.\r\n\r\nThe company is recognized for its professional service, honesty, and commitment to student success. They work closely with students to ensure that all requirements are met properly and on time. Their goal is to make the entire process simple and stress-free. By offering continuous support and expert advice, Maple Leaf Education Services helps students achieve their academic and career goals in Canada.', 2, '2026-04-11 03:13:10'),
(3, 'EduBridge Malaysia', 'Kuala Lumpur, Malaysia', '69d9bc5ed246d1775877214.jpg', '2026-04-01', 'EduBridge Malaysia is a leading education consultancy based in Kuala Lumpur, providing support to international students who wish to study in Malaysia and other partner countries. The company has built strong relationships with universities and colleges, allowing them to offer a wide range of study options at affordable costs.\r\n\r\nTheir services include student counseling, university selection, application submission, and visa assistance. EduBridge Malaysia focuses on providing accurate information and ensuring that students choose the right program according to their interests and future plans. They also assist with documentation and communication with institutions to ensure a smooth process.\r\n\r\nThe company is known for its friendly approach and efficient service. They guide students from the initial stage until final enrollment and even provide post-arrival support when needed. With a strong understanding of the education system and student needs, EduBridge Malaysia ensures a hassle-free experience for every student.', 3, '2026-04-11 03:13:34'),
(4, 'Kiwi Pathways', 'Auckland, New Zealand', '69d9bc74089371775877236.png', '0000-00-00', 'Kiwi Pathways is a reputable education consultancy located in Auckland, New Zealand. The company specializes in helping international students gain access to high-quality education opportunities in New Zealand. They have strong partnerships with universities, institutes, and training providers across the country.\r\n\r\nKiwi Pathways offers personalized counseling to help students choose the right course and institution. Their team provides complete support in application processing, documentation, and visa guidance. They also prepare students for interviews and ensure all requirements are properly met.\r\n\r\nThe company is known for its professional service and commitment to student success. They focus on providing clear and honest guidance to help students make informed decisions. Kiwi Pathways also offers post-arrival assistance, including accommodation and orientation support. Their goal is to create a smooth and successful transition for students studying in New Zealand.', 4, '2026-04-11 03:13:56'),
(5, 'USA Academic Partners', 'New York, USA', '69d9bc8d546eb1775877261.jpg', '2026-04-01', 'USA Academic Partners is a professional education consultancy based in New York, dedicated to helping international students pursue higher education in the United States. The company collaborates with a wide network of universities and colleges, providing students with diverse academic opportunities.\r\n\r\nTheir services include course selection, application assistance, SOP guidance, and visa support. They also help students prepare for standardized tests and interviews required for admission. USA Academic Partners ensures that each application is completed accurately and submitted on time.\r\n\r\nThe company is recognized for its expertise and strong industry connections. They provide students with updated information about programs, scholarships, and career opportunities. Their team works closely with students to ensure a smooth admission process and successful transition. With a focus on quality service, USA Academic Partners helps students achieve their educational goals in the USA.', 5, '2026-04-11 03:14:21'),
(6, 'German Study Alliance', 'Berlin, Germany', '69d9bc9f87a161775877279.png', '2026-04-01', 'German Study Alliance is a well-known education consultancy based in Berlin, Germany. The company focuses on supporting international students who wish to study in Germany’s top universities. They provide expert guidance on course selection, admission procedures, and visa requirements.\r\n\r\nTheir team assists students with application preparation, document verification, and communication with universities. They also guide students on language requirements and help them prepare for German or English proficiency tests. German Study Alliance ensures that all applications meet university standards and are submitted correctly.\r\n\r\nThe company is known for its reliable service and strong understanding of the German education system. They also provide support for accommodation, travel planning, and post-arrival services. Their goal is to make the entire process simple and efficient. With their guidance, students can confidently pursue their education in Germany and build a successful future.', 6, '2026-04-11 03:14:39');

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

--
-- Dumping data for table `testimonial`
--

INSERT INTO `testimonial` (`id`, `name`, `role`, `image`, `message`, `position`, `status`) VALUES
(1, 'AL Mamun Vai', 'student', '', 'In conclusion, this research aims to develop an intelligent multi-modal sensor fusion system that enhances the accuracy, efficiency, and reliability of medical diagnostics. By integrating advanced sensor technologies with deep learning algorithms, the proposed system addresses the limitations of traditional diagnostic approaches and contributes to the advancement of intelligent instrumentation.', 0, 'approved'),
(2, 'MD Mehedi Hasan', '', '', 'In conclusion, this research aims to develop an intelligent multi-modal sensor fusion system that enhances the accuracy, efficiency, and reliability of medical diagnostics. By integrating advanced sensor technologies with deep learning algorithms, the proposed system addresses the limitations of traditional diagnostic approaches and contributes to the advancement of intelligent instrumentation.', 0, 'approved'),
(3, 'Md. Rahim Uddin', '', '', 'In conclusion, this research aims to develop an intelligent multi-modal sensor fusion system that enhances the accuracy, efficiency, and reliability of medical diagnostics. By integrating advanced sensor technologies with deep learning algorithms, the proposed system addresses the limitations of traditional diagnostic approaches and contributes to the advancement of intelligent instrumentation.', 0, 'approved'),
(4, 'Choity Baroi', '', '', 'In conclusion, this research aims to develop an intelligent multi-modal sensor fusion system that enhances the accuracy, efficiency, and reliability of medical diagnostics. By integrating advanced sensor technologies with deep learning algorithms, the proposed system addresses the limitations of traditional diagnostic approaches and contributes to the advancement of intelligent instrumentation.', 0, 'approved'),
(5, 'Nehal Uddin', '', '', 'In conclusion, this research aims to develop an intelligent multi-modal sensor fusion system that enhances the accuracy, efficiency, and reliability of medical diagnostics. By integrating advanced sensor technologies with deep learning algorithms, the proposed system addresses the limitations of traditional diagnostic approaches and contributes to the advancement of intelligent instrumentation.', 0, 'approved');

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

--
-- Dumping data for table `university`
--

INSERT INTO `university` (`id`, `university_logo`, `university_banner`, `university_name`, `location`, `country`, `about_university`, `student_facility`, `free_sections`, `position`, `created_at`, `updated_at`) VALUES
(2, '69d9df95a04591775886229.jpg', NULL, 'MAHSA University', 'Kuala Lumpur', 'Malaysia', 'MAHSA University is a leading private university in Malaysia known for healthcare and professional programs. It offers globally recognized degrees with modern facilities and experienced faculty. The university focuses on practical learning and career development, helping students build strong professional skills. It also maintains international partnerships for global exposure.\r\n\r\nMAHSA University is a leading private university in Malaysia known for healthcare and professional programs. It offers globally recognized degrees with modern facilities and experienced faculty. The university focuses on practical learning and career development, helping students build strong professional skills. It also maintains international partnerships for global exposure.\r\n\r\nMAHSA University is a leading private university in Malaysia known for healthcare and professional programs. It offers globally recognized degrees with modern facilities and experienced faculty. The university focuses on practical learning and career development, helping students build strong professional skills. It also maintains international partnerships for global exposure.\r\nMAHSA University is a leading private university in Malaysia known for healthcare and professional programs. It offers globally recognized degrees with modern facilities and experienced faculty. The university focuses on practical learning and career development, helping students build strong professional skills. It also maintains international partnerships for global exposure.\r\n\r\nMAHSA University is a leading private university in Malaysia known for healthcare and professional programs. It offers globally recognized degrees with modern facilities and experienced faculty. The university focuses on practical learning and career development, helping students build strong professional skills. It also maintains international partnerships for global exposure.', 'The university provides modern classrooms, labs, libraries, and digital resources. Students enjoy accommodation, dining, and recreational facilities. Support services include counseling, career guidance, and academic help. A safe and friendly environment ensures a comfortable student life.\r\n\r\nMAHSA University is a leading private university in Malaysia known for healthcare and professional programs. It offers globally recognized degrees with modern facilities and experienced faculty. The university focuses on practical learning and career development, helping students build strong professional skills. It also maintains international partnerships for global exposure.\r\n\r\nMAHSA University is a leading private university in Malaysia known for healthcare and professional programs. It offers globally recognized degrees with modern facilities and experienced faculty. The university focuses on practical learning and career development, helping students build strong professional skills. It also maintains international partnerships for global exposure.\r\n\r\nMAHSA University is a leading private university in Malaysia known for healthcare and professional programs. It offers globally recognized degrees with modern facilities and experienced faculty. The university focuses on practical learning and career development, helping students build strong professional skills. It also maintains international partnerships for global exposure.', NULL, 0, '2026-04-11 05:42:51', '2026-04-11 06:11:29'),
(3, NULL, NULL, 'University of Malaya', 'Kuala Lumpur', 'Malaysia', 'University of Malaya is the oldest and top-ranked public university in Malaysia. It offers diverse programs and strong research opportunities with global recognition.', 'Students have access to advanced labs, libraries, hostels, sports facilities, and student support services for academic and personal growth.', NULL, 1, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(4, NULL, NULL, 'Taylor\'s University', 'Subang Jaya', 'Malaysia', 'Taylor’s University is a top private university known for business, hospitality, and design programs with strong industry links.', 'Modern campus with labs, innovation hubs, accommodation, career services, and student clubs for skill development.', NULL, 2, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(5, NULL, NULL, 'UCSI University', 'Kuala Lumpur', 'Malaysia', 'UCSI University is recognized for its strong academic programs and international collaborations, especially in business and engineering.', 'Facilities include smart classrooms, labs, hostel, counseling services, and extracurricular activities.', NULL, 3, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(6, NULL, NULL, 'Sunway University', 'Selangor', 'Malaysia', 'Sunway University offers high-quality education with partnerships from global institutions and focuses on innovation and research.', 'Students enjoy modern campus, library, accommodation, and active student life with clubs and events.', NULL, 4, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(7, NULL, NULL, 'Asia Pacific University', 'Kuala Lumpur', 'Malaysia', 'APU is known for IT and technology-focused education with international exposure and industry-driven curriculum.', 'Facilities include tech labs, innovation centers, housing, and career support services.', NULL, 5, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(8, NULL, NULL, 'University of Melbourne', 'Melbourne', 'Australia', 'The University of Melbourne is a top-ranked institution known for research excellence and academic quality across various disciplines.', 'Students benefit from libraries, labs, housing, counseling, and strong career services.', NULL, 6, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(9, NULL, NULL, 'University of Sydney', 'Sydney', 'Australia', 'The University of Sydney offers world-class education with a strong focus on innovation and global impact.', 'Facilities include modern campus, sports, accommodation, and student support programs.', NULL, 7, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(10, NULL, NULL, 'Monash University', 'Melbourne', 'Australia', 'Monash University is known for its global campuses and strong programs in engineering, business, and health.', 'Students have access to labs, libraries, career services, and international exchange opportunities.', NULL, 8, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(11, NULL, NULL, 'University of Queensland', 'Brisbane', 'Australia', 'UQ is a leading research university offering diverse programs and global career opportunities.', 'Facilities include advanced research labs, accommodation, and student wellbeing services.', NULL, 9, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(12, NULL, NULL, 'Deakin University', 'Melbourne', 'Australia', 'Deakin University focuses on practical education and industry experience for career success.', 'Students enjoy digital learning tools, campus housing, and career development support.', NULL, 10, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(13, NULL, NULL, 'RMIT University', 'Melbourne', 'Australia', 'RMIT is known for technology, design, and business programs with strong industry connections.', 'Facilities include innovation labs, studios, housing, and student support services.', NULL, 11, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(14, NULL, NULL, 'University of Toronto', 'Toronto', 'Canada', 'The University of Toronto is one of the top universities globally, known for research and academic excellence.', 'Students have access to libraries, labs, housing, and strong support services.', NULL, 12, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(15, NULL, NULL, 'University of British Columbia', 'Vancouver', 'Canada', 'UBC offers world-class education with strong research programs and global recognition.', 'Facilities include modern campus, sports centers, housing, and counseling services.', NULL, 13, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(16, NULL, NULL, 'McGill University', 'Montreal', 'Canada', 'McGill is known for academic excellence and diverse programs with international reputation.', 'Students enjoy libraries, labs, housing, and cultural activities.', NULL, 14, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(17, NULL, NULL, 'University of Alberta', 'Edmonton', 'Canada', 'The University of Alberta is a leading research university with strong industry links.', 'Facilities include labs, accommodation, and career services.', NULL, 15, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(18, NULL, NULL, 'York University', 'Toronto', 'Canada', 'York University offers diverse programs and focuses on innovation and research.', 'Students have access to modern facilities, housing, and student services.', NULL, 16, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(19, NULL, NULL, 'Seneca College', 'Toronto', 'Canada', 'Seneca College provides career-focused programs with practical training.', 'Facilities include labs, workshops, housing, and career support.', NULL, 17, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(20, NULL, NULL, 'University of Auckland', 'Auckland', 'New Zealand', 'The University of Auckland is the top-ranked university in New Zealand with strong research and global recognition.', 'Students enjoy modern facilities, libraries, housing, and support services.', NULL, 18, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(21, NULL, NULL, 'University of Otago', 'Dunedin', 'New Zealand', 'Otago is known for health sciences and research excellence.', 'Facilities include labs, accommodation, and student wellness services.', NULL, 19, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(22, NULL, NULL, 'Victoria University of Wellington', 'Wellington', 'New Zealand', 'This university offers strong programs in humanities, science, and business.', 'Students have access to modern campus, housing, and career services.', NULL, 20, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(23, NULL, NULL, 'AUT University', 'Auckland', 'New Zealand', 'AUT focuses on practical education and industry connections.', 'Facilities include labs, studios, housing, and student support.', NULL, 21, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(24, NULL, NULL, 'Harvard University', 'Cambridge', 'United State of America', 'Harvard is one of the most prestigious universities in the world, known for excellence in education and research.', 'Students benefit from world-class libraries, labs, housing, and support services.', NULL, 22, '2026-04-11 05:42:51', '2026-04-11 05:44:35'),
(25, NULL, NULL, 'Stanford University', 'California', 'United State of America', 'Stanford is known for innovation, technology, and entrepreneurship.', 'Facilities include labs, research centers, housing, and career services.', NULL, 23, '2026-04-11 05:42:51', '2026-04-11 05:44:45'),
(26, NULL, NULL, 'MIT', 'Massachusetts', 'United State of America', 'MIT is a global leader in science, engineering, and technology education.', 'Students have access to advanced labs, research facilities, and housing.', NULL, 24, '2026-04-11 05:42:51', '2026-04-11 05:44:53'),
(27, NULL, NULL, 'University of California, Berkeley', 'California', 'USA', 'UC Berkeley is known for strong academic programs and research excellence.', 'Facilities include libraries, labs, and student support services.', NULL, 25, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(28, NULL, NULL, 'UCLA', 'Los Angeles', 'USA', 'UCLA offers diverse programs and strong research opportunities.', 'Students enjoy modern campus, housing, and recreational facilities.', NULL, 26, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(29, NULL, NULL, 'New York University', 'New York', 'USA', 'NYU is known for global exposure and strong programs in arts and business.', 'Facilities include urban campus resources, housing, and career services.', NULL, 27, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(30, NULL, NULL, 'University of Chicago', 'Chicago', 'USA', 'This university is known for academic rigor and research excellence.', 'Students have access to libraries, labs, and support services.', NULL, 28, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(31, NULL, NULL, 'Columbia University', 'New York', 'USA', 'Columbia is an Ivy League university with strong global reputation.', 'Facilities include research centers, libraries, housing, and student services.', NULL, 29, '2026-04-11 05:42:51', '2026-04-11 05:43:52'),
(32, NULL, NULL, 'INTI International University', 'Nilai', 'Malaysia', 'INTI International University is known for its strong academic programs and global partnerships with universities from the USA and UK. It focuses on practical learning and career development.', 'Students enjoy modern classrooms, labs, hostel facilities, and strong career services with internship opportunities.', NULL, 31, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(33, NULL, NULL, 'Multimedia University', 'Cyberjaya', 'Malaysia', 'Multimedia University specializes in IT, engineering, and digital technology programs with strong industry connections.', 'Facilities include advanced IT labs, studios, libraries, and student accommodation with support services.', NULL, 32, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(34, NULL, NULL, 'HELP University', 'Kuala Lumpur', 'Malaysia', 'HELP University is recognized for psychology, business, and law programs with international standards.', 'Students have access to libraries, counseling services, accommodation, and student development programs.', NULL, 33, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(35, NULL, NULL, 'SEGi University', 'Kota Damansara', 'Malaysia', 'SEGi University offers affordable education with globally recognized programs and practical learning focus.', 'Facilities include labs, hostels, sports, and career support services for students.', NULL, 34, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(36, NULL, NULL, 'Limkokwing University', 'Cyberjaya', 'Malaysia', 'Limkokwing University is famous for creative programs such as design, media, and communication.', 'Students enjoy creative studios, labs, accommodation, and international exposure.', NULL, 35, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(37, NULL, NULL, 'Universiti Teknologi Malaysia', 'Johor Bahru', 'Malaysia', 'UTM is a leading public university focusing on engineering, science, and technology education.', 'Facilities include research labs, libraries, housing, and student support services.', NULL, 36, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(38, NULL, NULL, 'Macquarie University', 'Sydney', 'Australia', 'Macquarie University is known for research, business, and science programs with strong industry links.', 'Students have access to labs, libraries, housing, and career support services.', NULL, 37, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(39, NULL, NULL, 'Griffith University', 'Brisbane', 'Australia', 'Griffith University offers innovative programs in health, business, and arts.', 'Facilities include modern campus, accommodation, labs, and student support.', NULL, 38, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(40, NULL, NULL, 'La Trobe University', 'Melbourne', 'Australia', 'La Trobe University focuses on research and career-ready education in multiple disciplines.', 'Students enjoy libraries, labs, housing, and career services.', NULL, 39, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(41, NULL, NULL, 'Curtin University', 'Perth', 'Australia', 'Curtin University is known for strong industry connections and practical education.', 'Facilities include labs, innovation hubs, accommodation, and student services.', NULL, 40, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(42, NULL, NULL, 'University of Adelaide', 'Adelaide', 'Australia', 'The University of Adelaide is a prestigious institution known for research and academic excellence.', 'Students benefit from libraries, labs, housing, and academic support.', NULL, 41, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(43, NULL, NULL, 'Western Sydney University', 'Sydney', 'Australia', 'Western Sydney University offers diverse programs with a focus on innovation and community impact.', 'Facilities include modern campuses, labs, housing, and student services.', NULL, 42, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(44, NULL, NULL, 'University of Calgary', 'Calgary', 'Canada', 'The University of Calgary is known for research and innovation in science and engineering.', 'Students enjoy labs, libraries, housing, and career services.', NULL, 43, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(45, NULL, NULL, 'Simon Fraser University', 'Vancouver', 'Canada', 'SFU offers strong programs in business, science, and technology with global recognition.', 'Facilities include labs, accommodation, and student support services.', NULL, 44, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(46, NULL, NULL, 'Carleton University', 'Ottawa', 'Canada', 'Carleton University is known for engineering, public affairs, and journalism programs.', 'Students have access to labs, libraries, housing, and career guidance.', NULL, 45, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(47, NULL, NULL, 'Conestoga College', 'Ontario', 'Canada', 'Conestoga College provides career-focused programs with practical training and internships.', 'Facilities include labs, workshops, housing, and career support.', NULL, 46, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(48, NULL, NULL, 'Humber College', 'Toronto', 'Canada', 'Humber College offers industry-focused education with strong job placement support.', 'Students enjoy modern labs, studios, housing, and career services.', NULL, 47, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(49, NULL, NULL, 'George Brown College', 'Toronto', 'Canada', 'George Brown College focuses on practical skills and career-ready programs.', 'Facilities include labs, workshops, housing, and student services.', NULL, 48, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(50, NULL, NULL, 'Massey University', 'Palmerston North', 'New Zealand', 'Massey University is known for flexible learning and strong programs in agriculture and business.', 'Students enjoy modern facilities, housing, and support services.', NULL, 49, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(51, NULL, NULL, 'University of Waikato', 'Hamilton', 'New Zealand', 'Waikato University offers strong programs in business, IT, and education.', 'Facilities include labs, libraries, housing, and student support.', NULL, 50, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(52, NULL, NULL, 'Lincoln University', 'Christchurch', 'New Zealand', 'Lincoln University specializes in agriculture, environment, and land-based studies.', 'Students have access to labs, housing, and research facilities.', NULL, 51, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(53, NULL, NULL, 'Eastern Institute of Technology', 'Napier', 'New Zealand', 'EIT offers practical education with strong industry connections.', 'Facilities include labs, workshops, housing, and student services.', NULL, 52, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(54, NULL, NULL, 'University of Washington', 'Seattle', 'USA', 'The University of Washington is known for research excellence and diverse academic programs.', 'Students enjoy labs, libraries, housing, and strong support services.', NULL, 53, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(55, NULL, NULL, 'University of Texas at Austin', 'Texas', 'USA', 'UT Austin offers top programs in business, engineering, and sciences.', 'Facilities include modern campus, labs, housing, and career services.', NULL, 54, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(56, NULL, NULL, 'University of Florida', 'Florida', 'USA', 'The University of Florida provides strong academic programs and research opportunities.', 'Students have access to labs, libraries, housing, and student services.', NULL, 55, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(57, NULL, NULL, 'Arizona State University', 'Arizona', 'USA', 'ASU is known for innovation and modern teaching approaches.', 'Facilities include labs, housing, and career development services.', NULL, 56, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(58, NULL, NULL, 'Boston University', 'Boston', 'USA', 'Boston University offers diverse programs with strong global recognition.', 'Students enjoy modern campus, housing, and academic support.', NULL, 57, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(59, NULL, NULL, 'University of Southern California', 'California', 'USA', 'USC is known for business, film, and engineering programs.', 'Facilities include labs, studios, housing, and career services.', NULL, 58, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(60, NULL, NULL, 'Purdue University', 'Indiana', 'USA', 'Purdue is famous for engineering and technology programs with strong research.', 'Students have access to labs, housing, and student support services.', NULL, 59, '2026-04-11 05:46:05', '2026-04-11 05:46:05'),
(61, NULL, NULL, 'Pennsylvania State University', 'Pennsylvania', 'USA', 'Penn State offers strong academic programs and research opportunities.', 'Facilities include libraries, labs, housing, and student services.', NULL, 60, '2026-04-11 05:46:05', '2026-04-11 05:46:05');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `university`
--
ALTER TABLE `university`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `working_process`
--
ALTER TABLE `working_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
