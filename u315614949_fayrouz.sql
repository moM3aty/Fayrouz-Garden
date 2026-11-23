-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 23, 2026 at 08:37 PM
-- Server version: 11.8.9-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u315614949_fayrouz`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_content`
--

CREATE TABLE `about_content` (
  `id` int(11) NOT NULL,
  `badge` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `paragraph_1` text DEFAULT NULL,
  `paragraph_2` text DEFAULT NULL,
  `image` varchar(255) DEFAULT 'css/1.jpg',
  `feature_1_title` varchar(100) DEFAULT NULL,
  `feature_1_text` text DEFAULT NULL,
  `feature_1_icon` varchar(50) DEFAULT 'fa-shield-halved',
  `feature_2_title` varchar(100) DEFAULT NULL,
  `feature_2_text` text DEFAULT NULL,
  `feature_2_icon` varchar(50) DEFAULT 'fa-clock',
  `cta_text` varchar(100) DEFAULT NULL,
  `cta_link` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_content`
--

INSERT INTO `about_content` (`id`, `badge`, `title`, `paragraph_1`, `paragraph_2`, `image`, `feature_1_title`, `feature_1_text`, `feature_1_icon`, `feature_2_title`, `feature_2_text`, `feature_2_icon`, `cta_text`, `cta_link`, `updated_at`) VALUES
(1, 'رؤيتنا وفلسفتنا', 'مشتل الفيروز.. حين تعانق الطبيعة ذوقك المعماري الرفيع', 'تأسس <strong>مشتل الفيروز لتنسيق الحدائق المنزلية</strong> ليصنع فارقاً حقيقياً في مفهوم المساحات الخضراء المنزلية. نؤمن أن حديقة البيت ليست مجرد رقعة عشبية، بل هي الملاذ الهادئ الذي تلتقي فيه العائلة، ومصدر الطاقة الإيجابية والسكينة بعد عناء اليوم.', 'يقود مشتلنا طاقم متخصص من المهندسين الزراعيين وفنيي تنسيق اللاندسكيب المحترفين، حيث نجمع بين المعرفة العميقة بمتطلبات البيئة والمناخ المحلي، وبين أحدث خطوط التصميم الديكوري العصري. نحرص على اختيار أفضل أنواع التربة الخصبة، وتمديد أحدث أنظمة الري المتطورة التي توفر استهلاك المياه، وزراعة شتلات الزهور النضرة كالفل والياسمين والريحان والورود الجورية التي تملأ الأرجاء عبقاً وألقاً.', 'css/1.jpg', 'ضمان الجودة الفائقة', 'نضمن لك نمو النباتات وسلامة التمديدات والشلالات.', 'fa-shield-halved', 'سرعة والتزام زمني', 'تسليم المشاريع في الوقت المتفق عليه بأعلى دقة.', 'fa-clock', 'تواصل مع مهندس المشتل: 0505527615', 'tel:0505527615', '2026-11-23 19:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` enum('admin','editor') NOT NULL DEFAULT 'admin',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password_hash`, `email`, `full_name`, `role`, `last_login`, `created_at`) VALUES
(1, 'admin', '$2y$10$5sWsj0qNGfQ2vylhgolb4O6YYfm9X4ZGJyd7udpiOWCruM6SU1ChW', 'admin@fayrouz.com', 'admin', 'admin', '2026-11-23 20:34:16', '2026-11-23 16:23:38');

-- --------------------------------------------------------

--
-- Table structure for table `botanical_varieties`
--

CREATE TABLE `botanical_varieties` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(80) DEFAULT 'fa-leaf',
  `badge_class` varchar(50) DEFAULT 'bg-success',
  `card_style` varchar(50) DEFAULT 'hover-jasmine-shift',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `botanical_varieties`
--

INSERT INTO `botanical_varieties` (`id`, `title`, `description`, `icon`, `badge_class`, `card_style`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'زهور الفل البلدي والعراقي', 'شجيرات الفل البيضاء ذات العبير الأخّاذ في المساء، زهور ناصعة البياض تدوم فترات طويلة وتناسب الأحواض القريبة من مجالس الجلوس.', 'fa-certificate', 'bg-warning text-dark', 'hover-jasmine-shift', 1, 1, '2026-11-23 19:03:43'),
(2, 'الياسمين الهندي والمتسلق', 'نباتات متسلقة بديعة لتغطية الأسوار والمظلات بالخضرة والزهور العطرية الفواحة، مع نمو سريع وكثافة ورقية تمنح خصوصية تامة.', 'fa-spa', 'bg-danger text-white', 'hover-rose-shift', 2, 1, '2026-11-23 19:03:43'),
(3, 'الريحان الإيطالي والبلدي الفواح', 'نباتات عشبية عطرية لا غنى عنها في باحة كل منزل، تعبق بأجمل الروائح المنعشة وتطرد الحشرات طبيعياً وتصلح للزراعة في أحواض ديكورية.', 'fa-leaf', 'bg-success text-white', 'hover-rayhan-shift', 3, 1, '2026-11-23 19:03:43'),
(4, 'نخيل واشنطونيا ونخيل عربي', 'أشجار النخيل الباسقة التي تعكس الهوية والفخامة، يتم توريدها بأطوال مختلفة مع الضمان الكامل لنجاح الغرس وتناسق المسافات.', 'fa-tree', 'bg-success text-white', 'hover-mint-shift', 4, 1, '2026-11-23 19:03:43'),
(5, 'أشجار الفواكه والحمضيات', 'شتلات الليمون الشهري، البرتقال، الرمان، والتين المزروعة في أكياس زراعية قوية وجاهزة للإنتاج السريع في حدائق المنازل.', 'fa-lemon', 'bg-info text-white', 'hover-sky-shift', 5, 1, '2026-11-23 19:03:43'),
(6, 'شجيرات الجهنمية (البوجنفيل)', 'ألوان زاهية لا تقاوم من الوردي والبنفسجي والأبيض والبرتقالي، تتميز بقدرتها الفائقة على تحمل الشمس وتزهر طوال العام بغزارة.', 'fa-sun', 'bg-primary text-white', 'hover-purple-shift', 6, 1, '2026-11-23 19:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `sort_order`, `is_active`) VALUES
(1, 'الملقا', 1, 1),
(2, 'النرجس', 2, 1),
(3, 'الياسمين', 3, 1),
(4, 'القيروان', 4, 1),
(5, 'العارض', 5, 1),
(6, 'الصحافة', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` varchar(500) NOT NULL,
  `answer` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'ما هو الفرق الجوهري بين الثيل الطبيعي والعشب الصناعي وأيهما أفضل لمنزلي؟', 'الثيل الطبيعي يمنحك برودة طبيعية حقيقية، أكسجين منعش، وملمساً حياً رائعاً، وهو مثالي للحدائق التي يتوفر بها مصدر ماء مناسب ورغبة في العناية الطبيعية. أما العشب الصناعي فيتميز بأنه دائم الخضرة طوال العام، لا يتطلب رياً أو قصاً أو تسميداً، ومناسب جداً للأسطح، وممرات المشي، ومناطق ألعاب الأطفال. مهندسنا يساعدك خلال المعاينة في اختيار الأنسب لطبيعة استخدامك وموقع فنائك.', 1, 1, '2026-11-23 19:59:25'),
(2, 'كم مرة تحتاج الحديقة إلى الري خلال فترات الصيف الحارة؟', 'في أشهر الصيف، يُفضل ري المسطحات الخضراء والأشجار مرتين يومياً: الأولى في الصباح الباكر قبل اشتداد حرارة الشمس لتجنب تبخر المياه، والثانية بعد غروب الشمس في المساء. وجود شبكة ري أوتوماتيكية بتايمر مبرمج يضمن ضبط الكميات بالملليمتر وتفادي جفاف الجذور تماماً.', 2, 1, '2026-11-23 19:59:25'),
(3, 'كيف يتم الحفاظ على شجيرات الفل والياسمين لتبقى مزهرة وذات عبير فواح؟', 'الفل والياسمين يعشقان أشعة الشمس المباشرة لعدة ساعات يومياً مع تربة جيدة الصرف غنية بالمادة العضوية. نقوم بوضع سماد الفوسفور والبوتاسيوم في بداية الربيع لتشجيع الأزهار، مع تقليم الأطراف الجافة بانتظام وري معتدل لا يغرق الجذور، مما يحفز التزهير المستمر طوال الموسم.', 3, 1, '2026-11-23 19:59:25'),
(4, 'كيف تضمنون عدم حدوث أي تسريب للمياه من الشلالات الجدارية؟', 'نطبق نظام عزل مائي احترافي مكون من 3 طبقات عزل أسمنتي ومطاطي، واختبار الحوض بالماء لمدة 48 ساعة للتأكد التام قبل لصق الأحجار أو الرخام النهائي، بالإضافة إلى استخدام مواسير PVC ضغط عالي ومضخات معتمدة تضمن دورة مياه مغلقة وآمنة بنسبة 100%.', 4, 1, '2026-11-23 19:59:25'),
(5, 'كم تستغرق عادةً مدة تنفيذ حديقة منزلية متكاملة؟', 'تتراوح مدة التنفيذ للحدائق المنزلية المتوسطة بين 3 إلى 7 أيام عمل فقط، تشمل كافة أعمال التسوية، تمديد شبكة الري، بناء الشلال، تركيب الثيل، وغرس الأشجار وتوزيع الإنارة، وذلك بفضل كفاءة طاقمنا ومعداتنا المتطورة.', 5, 1, '2026-11-23 19:59:25');

-- --------------------------------------------------------

--
-- Table structure for table `fragrant_haven`
--

CREATE TABLE `fragrant_haven` (
  `id` int(11) NOT NULL,
  `badge` varchar(100) DEFAULT 'عبير الذكريات',
  `title` varchar(255) DEFAULT NULL,
  `paragraph_1` text DEFAULT NULL,
  `paragraph_2` text DEFAULT NULL,
  `box_title` varchar(150) DEFAULT NULL,
  `box_text` text DEFAULT NULL,
  `cta_text` varchar(100) DEFAULT NULL,
  `cta_link` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'css/6.jpg',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fragrant_haven`
--

INSERT INTO `fragrant_haven` (`id`, `badge`, `title`, `paragraph_1`, `paragraph_2`, `box_title`, `box_text`, `cta_text`, `cta_link`, `image`, `updated_at`) VALUES
(1, 'عبير الذكريات', 'عبق الطبيعة في كل ركن أخضر', 'لا تكتمل روعة الحديقة المنزلية إلا بعبق النباتات العطرية التقليدية التي تسحر الحواس مع نسمات الصباح الباكر وهدوء المساء. نخصص في مشتل الفيروز أركاناً خاصة لزهور الفل والياسمين والريحان البلدي داخل التصميم العام.', 'نحدد المواقع الأكثر ملائمة من حيث حركة الشمس والتهوية، ونعتمد خلطات تربة غنية بالعناصر العضوية الطبيعية المحفزة لظهور البراعم الزهرية بكثافة، مع مد شبكة تنقيط هادئة تحافظ على رطوبة الجذور دون إغراق الزهور، لتستمتع بجلسة قهوة صباحية تحفها الروائح الزكية.', 'ركن القهوة العطري', 'نصمم لك زاوية جلوس مخصصة محاطة بسياج من شجيرات الياسمين والفل والنعناع والريحان لتنعم بالاسترخاء التام.', 'اطلب تشكيلة الزهور العطرية: 0505527615', 'tel:0505527615', 'css/6.jpg', '2026-11-23 20:20:53');

-- --------------------------------------------------------

--
-- Table structure for table `garden_checkup_items`
--

CREATE TABLE `garden_checkup_items` (
  `id` int(11) NOT NULL,
  `item_text` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `garden_checkup_items`
--

INSERT INTO `garden_checkup_items` (`id`, `item_text`, `sort_order`, `is_active`) VALUES
(1, 'ظهور بقع صفراء أو جافة في الثيل', 1, 1),
(2, 'ضعف نمو الأشجار أو اصفرار أوراقها', 2, 1),
(3, 'تسريب أو انسداد في شبكة الري', 3, 1),
(4, 'انتشار الحشائش الضارة بين النجيلة', 4, 1),
(5, 'تراجع كفاءة الشلال أو النافورة', 5, 1),
(6, 'بهتان ألوان الزهور وقلة التزهير', 6, 1),
(7, 'تشقق الممرات أو تلف العشب الجداري', 7, 1),
(8, 'لم تجرِ صيانة دورية منذ أكثر من 3 أشهر', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hero_content`
--

CREATE TABLE `hero_content` (
  `id` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `lead` text DEFAULT NULL,
  `body` text DEFAULT NULL,
  `areas` text DEFAULT NULL,
  `image` varchar(255) DEFAULT 'css/hero.jpeg',
  `btn1_text` varchar(100) DEFAULT NULL,
  `btn1_link` varchar(255) DEFAULT NULL,
  `btn1_style` varchar(50) DEFAULT 'btn-hero-wa',
  `btn2_text` varchar(100) DEFAULT NULL,
  `btn2_link` varchar(255) DEFAULT NULL,
  `btn2_style` varchar(50) DEFAULT 'btn-hero-call',
  `btn3_text` varchar(100) DEFAULT NULL,
  `btn3_link` varchar(255) DEFAULT NULL,
  `btn3_style` varchar(50) DEFAULT 'btn-hero-outline',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hero_content`
--

INSERT INTO `hero_content` (`id`, `title`, `lead`, `body`, `areas`, `image`, `btn1_text`, `btn1_link`, `btn1_style`, `btn2_text`, `btn2_link`, `btn2_style`, `btn3_text`, `btn3_link`, `btn3_style`, `updated_at`) VALUES
(1, 'تنسيق حدائق بالرياض<br/>مساحة خضراء تشبهك', 'مشتل الفيروز | أبو محمد لتنسيق الحدائق في الرياض', 'نصمم وننفذ حدائق الفلل والاستراحات من الفكرة إلى التسليم: شبكات ري، مظلات وبرجولات، شلالات ونوافير، وزهور الفل والياسمين والريحان.', 'الملقا والنرجس والياسمين والقيروان والعارض والصحافة', 'css/hero.jpeg', 'تواصل واتساب الآن', 'https://wa.me/966505527615?text=مرحباً%20مشتل%20الفيروز،%20أرغب%20في%20طلب%20معاينة%20لتنسيق%20حديقتي', 'btn-hero-wa', 'اتصل فوري 0505527615', 'tel:0505527615', 'btn-hero-call', 'تصفح أعمالنا', '#portfolio', 'btn-hero-outline', '2026-11-23 19:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `inspiration_content`
--

CREATE TABLE `inspiration_content` (
  `id` int(11) NOT NULL,
  `badge` varchar(100) DEFAULT 'لمسة سحرية',
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `btn1_text` varchar(100) DEFAULT NULL,
  `btn1_link` varchar(255) DEFAULT NULL,
  `btn2_text` varchar(100) DEFAULT NULL,
  `btn2_link` varchar(255) DEFAULT NULL,
  `background_image` varchar(255) DEFAULT 'css/1.jpg',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inspiration_content`
--

INSERT INTO `inspiration_content` (`id`, `badge`, `title`, `description`, `btn1_text`, `btn1_link`, `btn2_text`, `btn2_link`, `background_image`, `updated_at`) VALUES
(1, 'لمسة سحرية', 'جمال الطبيعة يبدأ من لمستنا في مشتل الفيروز', 'دعنا نحوّل المساحة الترابية الصامتة في باحة منزلك أو فوق الروف إلى جنة خضراء تفيض بالحياة والجمال والظلال الوارفة. صممنا مئات الحدائق بحلول هندسية مذهلة تجمع بين الراحة والجمال البصري ورائحة النباتات الطبيعية.', 'اطلب المعاينة الآن 0505527615', 'tel:0505527615', 'استشارة واتساب مجانية', 'https://wa.me/966505527615', 'css/1.jpg', '2026-11-23 20:20:53');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_plans`
--

CREATE TABLE `maintenance_plans` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(80) DEFAULT 'fa-calendar-check',
  `cta_text` varchar(100) DEFAULT 'طلب تفاصيل البرنامج',
  `cta_link` varchar(255) DEFAULT NULL,
  `card_style` varchar(50) DEFAULT 'hover-mint-shift',
  `gradient_start` varchar(20) DEFAULT '#1d7168',
  `gradient_end` varchar(20) DEFAULT '#33948a',
  `btn_class` varchar(50) DEFAULT 'btn-outline-success',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maintenance_plans`
--

INSERT INTO `maintenance_plans` (`id`, `title`, `description`, `icon`, `cta_text`, `cta_link`, `card_style`, `gradient_start`, `gradient_end`, `btn_class`, `sort_order`, `is_active`) VALUES
(1, 'برنامج العناية الأسبوعي', 'يشمل قص وتسوية الثيل الطبيعي، إزالة الأوراق المتساقطة، تنظيف ممرات الحديقة، وإزالة الأعشاب الضارة من أحواض الزهور لتبقى الحديقة مرتبة دائماً.', 'fa-calendar-check', 'طلب تفاصيل البرنامج', 'https://wa.me/966505527615?text=أود%20الاستفسار%20عن%20برنامج%20الصيانة%20الأسبوعي', 'hover-mint-shift', '#147a4b', '#1fa861', 'btn-outline-success', 1, 1),
(2, 'برنامج الصيانة نصف الشهري', 'يتضمن تقليم وتشكيل أشجار الزينة والنخيل، فحص واختبار رشاشات شبكة الري وتنظيف فلاترها، وإضافة الأسمدة المحفزة للنمو الخضري والزهري.', 'fa-scissors', 'طلب تفاصيل البرنامج', 'https://wa.me/966505527615?text=أود%20الاستفسار%20عن%20برنامج%20الصيانة%20نصف%20الشهري', 'hover-rose-shift', '#e0496b', '#f0aeb9', 'btn-outline-danger', 2, 1),
(3, 'برنامج التأهيل الموسمي الشامل', 'تهوية التربة الزراعية، مكافحة الآفات والحشرات بمبيدات آمنة، تجديد الزهور الموسمية الشتوية والصيفية، وصيانة مضخات الشلالات والنوافير.', 'fa-spray-can-sparkles', 'طلب تفاصيل البرنامج', 'https://wa.me/966505527615?text=أود%20الاستفسار%20عن%20برنامج%20التأهيل%20الموسمي', 'hover-sky-shift', '#116da6', '#4fa9d6', 'btn-outline-primary', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `navigation_links`
--

CREATE TABLE `navigation_links` (
  `id` int(11) NOT NULL,
  `label` varchar(100) NOT NULL,
  `href` varchar(255) NOT NULL,
  `icon` varchar(80) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `show_in_nav` tinyint(1) DEFAULT 1,
  `show_in_drawer` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `navigation_links`
--

INSERT INTO `navigation_links` (`id`, `label`, `href`, `icon`, `sort_order`, `is_active`, `show_in_nav`, `show_in_drawer`) VALUES
(1, 'الرئيسية', '#hero', 'fa-house', 1, 1, 1, 1),
(2, 'من نحن', '#about', 'fa-seedling', 2, 1, 1, 1),
(3, 'الزهرة والشجرة', '#garden-interactive', 'fa-tree', 3, 1, 1, 1),
(4, 'خدماتنا', '#services', 'fa-wand-magic-sparkles', 4, 1, 1, 1),
(5, 'شبكات الري', '#smart-irrigation', 'fa-faucet-drip', 5, 1, 0, 1),
(6, 'الشلالات والنوافير', '#water-features', 'fa-water', 6, 1, 0, 1),
(7, 'الفل والياسمين والريحان', '#fragrant-haven', 'fa-fan', 7, 1, 0, 1),
(8, 'المظلات والبرجولات', '#pergolas', 'fa-umbrella-beach', 8, 1, 0, 1),
(9, 'معرض الأعمال', '#portfolio', 'fa-images', 9, 1, 1, 1),
(10, 'صور المشاريع', '#project-photos', 'fa-camera', 10, 1, 1, 1),
(11, 'الأسئلة الشائعة', '#faq', 'fa-circle-question', 11, 1, 1, 1),
(12, 'اختار نباتاتك', '#plant-quiz', 'fa-leaf', 12, 1, 0, 1),
(13, 'شخّص حديقتك', '#garden-checkup', 'fa-stethoscope', 13, 1, 0, 1),
(14, 'أسرار المهندس', '#pro-tips', 'fa-lightbulb', 14, 1, 0, 1),
(15, 'موقعنا على الخريطة', '#location', 'fa-location-dot', 15, 1, 0, 1),
(16, 'تواصل معنا', '#contact', 'fa-phone', 16, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `night_lighting`
--

CREATE TABLE `night_lighting` (
  `id` int(11) NOT NULL,
  `badge` varchar(100) DEFAULT 'إضاءة معمارية',
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `feature_1_title` varchar(150) DEFAULT NULL,
  `feature_1_text` text DEFAULT NULL,
  `feature_2_title` varchar(150) DEFAULT NULL,
  `feature_2_text` text DEFAULT NULL,
  `stat_title` varchar(150) DEFAULT NULL,
  `stat_text` text DEFAULT NULL,
  `cta_text` varchar(100) DEFAULT NULL,
  `cta_link` varchar(255) DEFAULT NULL,
  `background_image` varchar(255) DEFAULT 'css/7.jpg',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `night_lighting`
--

INSERT INTO `night_lighting` (`id`, `badge`, `title`, `description`, `feature_1_title`, `feature_1_text`, `feature_2_title`, `feature_2_text`, `stat_title`, `stat_text`, `cta_text`, `cta_link`, `background_image`, `updated_at`) VALUES
(1, 'إضاءة معمارية', 'خضرة تحتفظ بجمالها بعد الغروب', 'الإنارة الليلية هي اللمسة التي تبرز تفاصيل الحديقة وتحولها إلى لوحة فنية أخاذة بعد غروب الشمس. نعتمد أسساً هندسية في توجيه الإضاءة الخافتة والمباشرة لإبراز جذوع الأشجار والنوافير والممرات بأمان وجمال.', 'سبوت لايت الأشجار والنخيل', 'كشافات موجهة من الأسفل إلى الأعلى ترسم ظلالاً ساحرة وتبرز قوام الأشجار.', 'إنارة الممرات الغاطسة', 'إضاءات أرضية مقاومة للماء والدهس تحدد مسار المشي وتمنح إحساساً فندقياً راقياً.', 'أنظمة أمان موفرة للطاقة 12V', 'تمديدات كهربائية معزولة بالكامل بجهد منخفض آمن للأطفال والحيوانات الأليفة مع تحكم ذكي عبر التايمر.', 'استفسر عن شبكات الإنارة: 0505527615', 'tel:0505527615', 'css/7.jpg', '2026-11-23 20:20:53');

-- --------------------------------------------------------

--
-- Table structure for table `pergolas_section`
--

CREATE TABLE `pergolas_section` (
  `id` int(11) NOT NULL,
  `badge` varchar(100) DEFAULT 'جلسات الاسترخاء',
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `feature_1_title` varchar(150) DEFAULT NULL,
  `feature_1_text` text DEFAULT NULL,
  `feature_2_title` varchar(150) DEFAULT NULL,
  `feature_2_text` text DEFAULT NULL,
  `stat_title` varchar(150) DEFAULT NULL,
  `stat_text` text DEFAULT NULL,
  `cta_text` varchar(100) DEFAULT NULL,
  `cta_link` varchar(255) DEFAULT NULL,
  `background_image` varchar(255) DEFAULT 'css/5.jpg',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pergolas_section`
--

INSERT INTO `pergolas_section` (`id`, `badge`, `title`, `description`, `feature_1_title`, `feature_1_text`, `feature_2_title`, `feature_2_text`, `stat_title`, `stat_text`, `cta_text`, `cta_link`, `background_image`, `updated_at`) VALUES
(1, 'جلسات الاسترخاء', 'ظلال وارفة وخضرة تهدّئ الروح', 'حوّل فناءك إلى مجلس خارجي فخم يستوعب العائلة والضيوف في أجواء من الخصوصية والظلال الوارفة. نصمم البرجولات بأحدث الخامات العصرية المتوافقة مع أحدث صيحات الديكور الخارجي.', 'خشب طبيعي وWPC بلاستيكي معالج', 'مقاوم للأمطار، النمل الأبيض، وأشعة الشمس الحارقة بدون تشقق أو بهتان.', 'حديد ليزر وتغطيات لكسان', 'نقوشات هندسية وإسلامية بالغة الدقة مع عزل حراري ومائي وإضاءة سبوت مدمجة.', 'جلسات خارجية متكاملة', 'نوفر كذلك الأرضيات الخشبية (الباركيه الخارجي) وأماكن الشواء المجهزة وديكورات الجلسات الأرضية والمرتفعة.', 'اطلب كتالوج البرجولات واتساب', 'https://wa.me/966505527615?text=أريد%20الاطلاع%20على%20تصاميم%20البرجولات', 'css/5.jpg', '2026-11-23 20:20:53');

-- --------------------------------------------------------

--
-- Table structure for table `plant_quiz_questions`
--

CREATE TABLE `plant_quiz_questions` (
  `id` int(11) NOT NULL,
  `group_key` varchar(50) NOT NULL,
  `question` varchar(255) NOT NULL,
  `hint` text DEFAULT NULL,
  `options` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plant_quiz_questions`
--

INSERT INTO `plant_quiz_questions` (`id`, `group_key`, `question`, `hint`, `options`, `sort_order`, `is_active`) VALUES
(1, 'sun', 'كم تصل الشمس لحديقتك؟', 'راقب حديقتك يوماً كاملاً: هل تغطيها الشمس المباشرة معظم النهار، أم يظللها جدار أو مبنى؟', 'full:شمس كاملة,half:نصف ظل,shade:ظل أغلب اليوم', 1, 1),
(2, 'space', 'ما مساحة الحديقة التقريبية؟', 'تقدير تقريبي يكفي؛ المساحة تحدد عدد الشتلات وحجم الأشجار المناسب دون تزاحم.', 'small:أقل من 50 م²,mid:من 50 إلى 150 م²,big:أكثر من 150 م²', 2, 1),
(3, 'care', 'كم وقتك للعناية بها؟', 'كن صريحاً مع نفسك؛ هناك نباتات جميلة تكاد لا تطلب شيئاً، وأخرى تعشق الدلال اليومي.', 'low:وقت قليل جداً,mid:عناية أسبوعية,high:البستنة هوايتي', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `portfolio_items`
--

CREATE TABLE `portfolio_items` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `portfolio_items`
--

INSERT INTO `portfolio_items` (`id`, `title`, `image`, `category`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'تشكيل أشجار ونخيل واشنطني', 'css/i (1).jpeg', 'مشاريع', 1, 1, '2026-11-23 19:46:37'),
(2, 'ممر عشبي متعرج بين الزهور', 'css/i (2).jpeg', 'مشاريع', 2, 1, '2026-11-23 19:46:37'),
(3, 'جلسة خارجية مع موقد ديكوري', 'css/i (3).jpeg', 'مشاريع', 3, 1, '2026-11-23 19:46:37'),
(4, 'تزيين أسوار بنباتات متسلقة', 'css/i (4).jpeg', 'مشاريع', 4, 1, '2026-11-23 19:46:37'),
(5, 'شلال رخامي مدرج مياه متدفقة', 'css/i (5).jpeg', 'مشاريع', 5, 1, '2026-11-23 19:46:37'),
(6, 'تنسيق فناء خلفي هادئ', 'css/i (6).jpeg', 'مشاريع', 6, 1, '2026-11-23 19:46:37'),
(7, 'أحواض زهور ملونة وريحان', 'css/i (7).jpeg', 'مشاريع', 7, 1, '2026-11-23 19:46:37'),
(8, 'برجولة حديد مع قص ليزر', 'css/i (8).jpeg', 'مشاريع', 8, 1, '2026-11-23 19:46:37'),
(9, 'عشب جداري عالي الكثافة', 'css/i (9).jpeg', 'مشاريع', 9, 1, '2026-11-23 19:46:37'),
(10, 'حديقة داخلية بإضاءة سبوت', 'css/i (10).jpeg', 'مشاريع', 10, 1, '2026-11-23 19:46:37'),
(11, 'نافورة جدارية مع مصب ستيل', 'css/i (11).jpeg', 'مشاريع', 11, 1, '2026-11-23 19:46:37'),
(12, 'أشجار ليمون وحمضيات مثمرة', 'css/i (12).jpeg', 'مشاريع', 12, 1, '2026-11-23 19:46:37'),
(13, 'ممر حجر عشوائي مع نجيلة', 'css/i (13).jpeg', 'مشاريع', 13, 1, '2026-11-23 19:46:37'),
(14, 'جلسة سطح روف بأجواء خضراء', 'css/i (14).jpeg', 'مشاريع', 14, 1, '2026-11-23 19:46:37'),
(15, 'زراعة نخيل عربي وبلدي', 'css/i (15).jpeg', 'مشاريع', 15, 1, '2026-11-23 19:46:37'),
(16, 'تصميم لاندسكيب كامل لفيلا', 'css/i (16).jpeg', 'مشاريع', 16, 1, '2026-11-23 19:46:37'),
(17, 'تزيين مدخل فيلا بأحواض رخام', 'css/i (17).jpeg', 'مشاريع', 17, 1, '2026-11-23 19:46:37'),
(18, 'شلال مودرن مع خرير هادئ', 'css/i (18).jpeg', 'مشاريع', 18, 1, '2026-11-23 19:46:37'),
(19, 'حديقة منزلية منسقة (19)', 'css/i (19).jpeg', 'مشاريع', 19, 1, '2026-11-23 19:46:37'),
(20, 'حديقة منزلية منسقة (20)', 'css/i (20).jpeg', 'مشاريع', 20, 1, '2026-11-23 19:46:37'),
(21, 'حديقة منزلية منسقة (21)', 'css/i (21).jpeg', 'مشاريع', 21, 1, '2026-11-23 19:46:37'),
(22, 'حديقة منزلية منسقة (22)', 'css/i (22).jpeg', 'مشاريع', 22, 1, '2026-11-23 19:46:37'),
(23, 'حديقة منزلية منسقة (23)', 'css/i (23).jpeg', 'مشاريع', 23, 1, '2026-11-23 19:46:37'),
(24, 'حديقة منزلية منسقة (24)', 'css/i (24).jpeg', 'مشاريع', 24, 1, '2026-11-23 19:46:37'),
(25, 'حديقة منزلية منسقة (25)', 'css/i (25).jpeg', 'مشاريع', 25, 1, '2026-11-23 19:46:37'),
(26, 'حديقة منزلية منسقة (26)', 'css/i (26).jpeg', 'مشاريع', 26, 1, '2026-11-23 19:46:37'),
(27, 'حديقة منزلية منسقة (27)', 'css/i (27).jpeg', 'مشاريع', 27, 1, '2026-11-23 19:46:37'),
(28, 'حديقة منزلية منسقة (28)', 'css/i (28).jpeg', 'مشاريع', 28, 1, '2026-11-23 19:46:37'),
(29, 'حديقة منزلية منسقة (29)', 'css/i (29).jpeg', 'مشاريع', 29, 1, '2026-11-23 19:46:37'),
(30, 'حديقة منزلية منسقة (30)', 'css/i (30).jpeg', 'مشاريع', 30, 1, '2026-11-23 19:46:37');

-- --------------------------------------------------------

--
-- Table structure for table `project_photos`
--

CREATE TABLE `project_photos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_photos`
--

INSERT INTO `project_photos` (`id`, `title`, `image`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'نافورة جدارية مع مصب ستيل', 'css/i (11).jpeg', 1, 1, '2026-11-23 19:46:37'),
(2, 'أشجار ليمون وحمضيات مثمرة', 'css/i (12).jpeg', 2, 1, '2026-11-23 19:46:37'),
(3, 'ممر حجر عشوائي مع نجيلة', 'css/i (13).jpeg', 3, 1, '2026-11-23 19:46:37'),
(4, 'جلسة سطح روف بأجواء خضراء', 'css/i (14).jpeg', 4, 1, '2026-11-23 19:46:37'),
(5, 'زراعة نخيل عربي وبلدي', 'css/i (15).jpeg', 5, 1, '2026-11-23 19:46:37'),
(6, 'تصميم لاندسكيب كامل لفيلا', 'css/i (16).jpeg', 6, 1, '2026-11-23 19:46:37'),
(7, 'تزيين مدخل فيلا بأحواض رخام', 'css/i (17).jpeg', 7, 1, '2026-11-23 19:46:37'),
(8, 'شلال مودرن مع خرير هادئ', 'css/i (18).jpeg', 8, 1, '2026-11-23 19:46:37'),
(9, 'لقطة من مشروع تنسيق حدائق (19)', 'css/i (19).jpeg', 9, 1, '2026-11-23 19:46:37'),
(10, 'لقطة من مشروع تنسيق حدائق (20)', 'css/i (20).jpeg', 10, 1, '2026-11-23 19:46:37'),
(11, 'لقطة من مشروع تنسيق حدائق (21)', 'css/i (21).jpeg', 11, 1, '2026-11-23 19:46:37'),
(12, 'لقطة من مشروع تنسيق حدائق (22)', 'css/i (22).jpeg', 12, 1, '2026-11-23 19:46:37'),
(13, 'لقطة من مشروع تنسيق حدائق (23)', 'css/i (23).jpeg', 13, 1, '2026-11-23 19:46:37'),
(14, 'لقطة من مشروع تنسيق حدائق (24)', 'css/i (24).jpeg', 14, 1, '2026-11-23 19:46:37'),
(15, 'لقطة من مشروع تنسيق حدائق (25)', 'css/i (25).jpeg', 15, 1, '2026-11-23 19:46:37'),
(16, 'لقطة من مشروع تنسيق حدائق (26)', 'css/i (26).jpeg', 16, 1, '2026-11-23 19:46:37'),
(17, 'لقطة من مشروع تنسيق حدائق (27)', 'css/i (27).jpeg', 17, 1, '2026-11-23 19:46:37'),
(18, 'لقطة من مشروع تنسيق حدائق (28)', 'css/i (28).jpeg', 18, 1, '2026-11-23 19:46:37'),
(19, 'لقطة من مشروع تنسيق حدائق (29)', 'css/i (29).jpeg', 19, 1, '2026-11-23 19:46:37'),
(20, 'لقطة من مشروع تنسيق حدائق (30)', 'css/i (30).jpeg', 20, 1, '2026-11-23 19:46:37'),
(21, 'لقطة من مشروع تنسيق حدائق (31)', 'css/i (31).jpeg', 21, 1, '2026-11-23 19:46:37'),
(22, 'لقطة من مشروع تنسيق حدائق (32)', 'css/i (32).jpeg', 22, 1, '2026-11-23 19:46:37'),
(23, 'لقطة من مشروع تنسيق حدائق (33)', 'css/i (33).jpeg', 23, 1, '2026-11-23 19:46:37'),
(24, 'لقطة من مشروع تنسيق حدائق (34)', 'css/i (34).jpeg', 24, 1, '2026-11-23 19:46:37'),
(25, 'لقطة من مشروع تنسيق حدائق (35)', 'css/i (35).jpeg', 25, 1, '2026-11-23 19:46:37'),
(26, 'لقطة من مشروع تنسيق حدائق (36)', 'css/i (36).jpeg', 26, 1, '2026-11-23 19:46:37'),
(27, 'لقطة من مشروع تنسيق حدائق (37)', 'css/i (37).jpeg', 27, 1, '2026-11-23 19:46:37'),
(28, 'لقطة من مشروع تنسيق حدائق (38)', 'css/i (38).jpeg', 28, 1, '2026-11-23 19:46:37'),
(29, 'لقطة من مشروع تنسيق حدائق (39)', 'css/i (39).jpeg', 29, 1, '2026-11-23 19:46:37'),
(30, 'لقطة من مشروع تنسيق حدائق (40)', 'css/i (40).jpeg', 30, 1, '2026-11-23 19:46:37');

-- --------------------------------------------------------

--
-- Table structure for table `pro_tips`
--

CREATE TABLE `pro_tips` (
  `id` int(11) NOT NULL,
  `icon` varchar(80) DEFAULT 'fa-lightbulb',
  `title` varchar(255) NOT NULL,
  `back_text` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pro_tips`
--

INSERT INTO `pro_tips` (`id`, `icon`, `title`, `back_text`, `sort_order`, `is_active`) VALUES
(1, 'fa-droplet', 'ابدأ بالاستخدام', 'هل تحتاج جلسة عائلية، مساحة لعب، أم ممراً أخضر؟ اكتب أولويتك قبل اختيار العناصر الزخرفية.', 1, 1),
(2, 'fa-scissors', 'اعرف مساحة المكان', 'جهّز الطول والعرض التقريبيين وحدد الأبواب والممرات التي يجب أن تبقى مفتوحة.', 2, 1),
(3, 'fa-flask', 'راقب الإضاءة', 'صور المكان في أوقات مختلفة ليكون توزيع الشمس والظل واضحاً أثناء مناقشة النباتات.', 3, 1),
(4, 'fa-seedling', 'خطط للعناية', 'حدد الوقت الذي يناسبك للعناية، واسأل عن احتياجات كل خيار قبل اعتماده.', 4, 1),
(5, 'fa-fan', 'حدد طابعك', 'اجمع صورتين أو ثلاثاً لتصاميم تعجبك، ووضح ما تحبه في الألوان والخامات والتوزيع.', 5, 1),
(6, 'fa-lightbulb', 'ناقش نطاق العمل', 'اطلب توضيح الخامات والتنفيذ والصيانة والمدة والتكلفة قبل الاتفاق على المشروع.', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `seasonal_calendar`
--

CREATE TABLE `seasonal_calendar` (
  `id` int(11) NOT NULL,
  `badge_text` varchar(50) NOT NULL,
  `badge_class` varchar(50) DEFAULT 'bg-success text-white',
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `card_style` varchar(50) DEFAULT 'hover-mint-shift',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seasonal_calendar`
--

INSERT INTO `seasonal_calendar` (`id`, `badge_text`, `badge_class`, `title`, `description`, `card_style`, `sort_order`, `is_active`) VALUES
(1, 'فصل الربيع', 'bg-success text-white', 'موسم التجدد والإزهار', 'أنسب وقت لغرس شتلات الفل والياسمين والريحان الجديدة، تسميد النجيل بالسماد العضوي، وبدء زيادة وتيرة الري تدريجياً مع ارتفاع درجات الحرارة.', 'hover-mint-shift', 1, 1),
(2, 'فصل الصيف', 'bg-danger text-white', 'الحماية وترشيد الري', 'الري في الصباح الباكر وقبل الغروب، استخدام شباك التظليل للنباتات الحساسة، وزيادة ارتفاع قص النجيل قليلاً لحماية الجذور من أشعة الشمس المباشرة.', 'hover-rose-shift', 2, 1),
(3, 'فصل الخريف', 'bg-primary text-white', 'التقليم والتهوية', 'تقليم الأفرع الجافة للأشجار والنخيل، تهوية تربة المسطحات الخضراء، وزراعة بذور الزهور الحولية الشتوية لتتفتح في الأشهر الباردة.', 'hover-sky-shift', 3, 1),
(4, 'فصل الشتاء', 'bg-warning text-dark', 'الدوران الهادئ ومقاومة البرد', 'تقليل كميات الري لمنع تعفن الجذور، حماية النباتات العطرية الحساسة من التيارات الباردة، والتجهيز المبكر للموسم القادم.', 'hover-jasmine-shift', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(80) DEFAULT 'fa-seedling',
  `card_style` varchar(50) DEFAULT 'hover-mint-shift',
  `gradient_start` varchar(20) DEFAULT '#1d7168',
  `gradient_end` varchar(20) DEFAULT '#33948a',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `icon`, `card_style`, `gradient_start`, `gradient_end`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'تصميم حدائق 3D واوتوكاد', 'نرفع مساحات فنائك ونقدم مخططات ثلاثية الأبعاد واقعية تمكنك من رؤية حديقة أحلامك وتوزيع الأشجار والجلسات والممرات قبل البدء بالتنفيذ.', 'fa-compass-drafting', 'hover-mint-shift', '#147a4b', '#1fa861', 1, 1, '2026-11-23 19:03:43'),
(2, 'الشلالات والنوافير الجدارية المودرن', 'تصميم وبناء شلالات حجرية ورخامية عصرية بإضاءات مائية هادئة ومضخات غاطسة إيطالية مانعة للصوت تضفي سحر الطبيعة العذب.', 'fa-water', 'hover-sky-shift', '#116da6', '#4fa9d6', 2, 1, '2026-11-23 19:03:43'),
(3, 'شبكات الري الأوتوماتيكية الذكية', 'تركيب منظومات ري متطورة بالرشاشات التلسكوبية والتنقيط مع أجهزة توقيت رقمية موفرة للمياه تضمن ري جميع النباتات في مواعيدها بدقة.', 'fa-faucet-drip', 'hover-jasmine-shift', '#ca8a04', '#fde047', 3, 1, '2026-11-23 19:03:43'),
(4, 'المظلات والبرجولات والجلسات', 'تفصيل برجولات خشبية معالجة ضد الرطوبة والحرارة، ومظلات حديد قص ليزر وقماش ألماني وأرضيات باركيه خارجية متينة تمنحك جلسة استرخاء ملوكية.', 'fa-umbrella-beach', 'hover-rayhan-shift', '#4d7c0f', '#84cc16', 4, 1, '2026-11-23 19:03:43'),
(5, 'زراعة الأشجار المثمرة والزهور العطرية', 'غرس أشجار النخيل والحمضيات والجهنمية، وأحواض الفل والياسمين والريحان الفواح والزهور الموسمية المستوردة لتبقى حديقتك عامرة بالألوان والعطور.', 'fa-seedling', 'hover-purple-shift', '#9333ea', '#c084fc', 5, 1, '2026-11-23 19:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `setting_key` varchar(100) NOT NULL,
  `setting_value` longtext DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`setting_key`, `setting_value`, `updated_at`) VALUES
('address', 'الرياض، المملكة العربية السعودية', '2026-11-23 19:03:43'),
('email', '', '2026-11-23 19:03:43'),
('facebook', '', '2026-11-23 19:03:43'),
('footer_credit', 'تصميم وتطوير احترافي', '2026-11-23 19:03:43'),
('instagram', '', '2026-11-23 19:03:43'),
('logo', 'css/logo.jpeg', '2026-11-23 19:03:43'),
('phone', '0505527615', '2026-11-23 19:03:43'),
('phone_intl', '966505527615', '2026-11-23 19:03:43'),
('primary_color', '#147a4b', '2026-11-23 19:03:43'),
('secondary_color', '#1fa861', '2026-11-23 19:03:43'),
('site_description', 'مشتل الفيروز - أبو محمد لتنسيق الحدائق بالرياض: تصميم وتنفيذ حدائق الفلل والاستراحات، شبكات ري، مظلات وبرجولات، شلالات، وزهور الفل والياسمين.', '2026-11-23 19:03:43'),
('site_name', 'مشتل الفيروز', '2026-11-23 19:03:43'),
('site_tagline', 'أبو محمد لتنسيق الحدائق', '2026-11-23 19:03:43'),
('snapchat', '', '2026-11-23 19:03:43'),
('tiktok', '', '2026-11-23 19:03:43'),
('twitter', '', '2026-11-23 19:03:43'),
('whatsapp', '966505527615', '2026-11-23 19:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `smart_irrigation`
--

CREATE TABLE `smart_irrigation` (
  `id` int(11) NOT NULL,
  `badge` varchar(100) DEFAULT 'ترشيد واستدامة',
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `feature_1_title` varchar(150) DEFAULT NULL,
  `feature_1_text` text DEFAULT NULL,
  `feature_2_title` varchar(150) DEFAULT NULL,
  `feature_2_text` text DEFAULT NULL,
  `stat_title` varchar(150) DEFAULT NULL,
  `stat_text` text DEFAULT NULL,
  `cta_text` varchar(100) DEFAULT NULL,
  `cta_link` varchar(255) DEFAULT NULL,
  `background_image` varchar(255) DEFAULT 'css/3.jpg',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `smart_irrigation`
--

INSERT INTO `smart_irrigation` (`id`, `badge`, `title`, `description`, `feature_1_title`, `feature_1_text`, `feature_2_title`, `feature_2_text`, `stat_title`, `stat_text`, `cta_text`, `cta_link`, `background_image`, `updated_at`) VALUES
(1, 'ترشيد واستدامة', 'خضرة تنبض بالحياة طوال العام', 'الري السليم هو سر نضارة الحديقة وازدهارها الدائم. نقوم في مشتل الفيروز بتصميم شبكات ري متكاملة تعمل بمحابس كهربائية وحساسات رطوبة وتايمر أوتوماتيكي متطور.', 'رشاشات بوب أب مخفية', 'ترتفع تلقائياً أثناء الري وتختفي داخل العشب للحفاظ على المظهر الجمالي.', 'تحكم ذكي دقيق', 'جدولة أوقات الري في الصباح الباكر أو المساء لتقليل التبخر وحفظ المياه.', 'توفير حتى 60% من المياه', 'من خلال التوزيع الهيدروليكي المتوازن الذي يغذي جذور الأشجار مباشرة دون هدر.', 'استفسر عن شبكات الري: 0505527615', 'tel:0505527615', 'css/3.jpg', '2026-11-23 20:20:53');

-- --------------------------------------------------------

--
-- Table structure for table `stone_pathways`
--

CREATE TABLE `stone_pathways` (
  `id` int(11) NOT NULL,
  `badge` varchar(100) DEFAULT 'هارموني الديكور',
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `btn1_text` varchar(100) DEFAULT NULL,
  `btn1_link` varchar(255) DEFAULT NULL,
  `btn2_text` varchar(100) DEFAULT NULL,
  `btn2_link` varchar(255) DEFAULT NULL,
  `background_image` varchar(255) DEFAULT 'css/9.jpg',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stone_pathways`
--

INSERT INTO `stone_pathways` (`id`, `badge`, `title`, `description`, `btn1_text`, `btn1_link`, `btn2_text`, `btn2_link`, `background_image`, `updated_at`) VALUES
(1, 'هارموني الديكور', 'دروب تأخذك إلى أحضان الطبيعة', 'الممرات الحجرية هي الشرايين التي تربط أجزاء حديقتك وتسهل التنقل بين الجلسة والشلال دون وطء العشب. ندمج أحجار البازلت العشوائي مع الحصى الأبيض والرمادي الناصع، بالإضافة إلى تجهيز أرضيات إسفنجية ومطاطية آمنة لمناطق ألعاب الأطفال.', 'تواصل مع مهندس الديكور 0505527615', 'tel:0505527615', 'استفسر عن الممرات الحجرية', 'https://wa.me/966505527615?text=أريد%20معلومات%20عن%20الممرات%20الحجرية%20والديكورات', 'css/9.jpg', '2026-11-23 20:10:23');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `client_title` varchar(100) DEFAULT NULL,
  `content` text NOT NULL,
  `rating` tinyint(1) DEFAULT 5,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `client_name`, `client_title`, `content`, `rating`, `image`, `sort_order`, `is_active`, `created_at`) VALUES
(1, 'أبو عبدالله', 'صاحب فيلا - حي الملقا', 'تعاملت مع مشتل الفيروز لتنسيق حديقة الفيلا بالكامل من الصفر، وكانت التجربة أكثر من رائعة. المهندس أبو محمد شخص محترم جداً، قدّم لنا تصميم 3D كامل قبل التنفيذ، ونفّذ كل التفاصيل بدقة عالية.', 5, NULL, 1, 1, '2026-11-23 19:03:43'),
(2, 'م. خالد الحربي', 'مهندس - حي النرجس', 'أخذت منهم باقة الصيانة نصف الشهرية بعد ما خلصوا تنسيق الحديقة، والصراحة الخدمة ممتازة والالتزام بالمواعيد دقيق. شبكة الري شغالة بكفاءة عالية من غير أي مشاكل.', 5, NULL, 2, 1, '2026-11-23 19:03:43'),
(3, 'أبو سارة', 'صاحب استراحة - العارض', 'كان عندي مشكلة في شبكة الري القديمة وتعبت وأنا أدور على حد يفهم فيها صح. مشتل الفيروز عملوا فحص كامل وغيّروا كل الرشاشات وضبطوا التايمر، والآن الحديقة تُروى أوتوماتيك.', 5, NULL, 3, 1, '2026-11-23 19:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `vertical_gardens`
--

CREATE TABLE `vertical_gardens` (
  `id` int(11) NOT NULL,
  `badge` varchar(100) DEFAULT 'استغلال المساحات',
  `title` varchar(255) DEFAULT NULL,
  `paragraph_1` text DEFAULT NULL,
  `paragraph_2` text DEFAULT NULL,
  `feature_1` varchar(255) DEFAULT NULL,
  `feature_2` varchar(255) DEFAULT NULL,
  `feature_3` varchar(255) DEFAULT NULL,
  `cta_text` varchar(100) DEFAULT NULL,
  `cta_link` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'css/10.jpg',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vertical_gardens`
--

INSERT INTO `vertical_gardens` (`id`, `badge`, `title`, `paragraph_1`, `paragraph_2`, `feature_1`, `feature_2`, `feature_3`, `cta_text`, `cta_link`, `image`, `updated_at`) VALUES
(1, 'استغلال المساحات', 'الخضرة تكسو كل زاوية وجدار', 'إذا كانت مساحة فنائك محدودة أو ترغب في إخفاء الجدران الإسمنتية الصامتة، فإن الحدائق الجدارية (Vertical Gardens) هي الحل الأمثل لتحويل الأسوار إلى ستائر خضراء مزهرة تنبض بالحياة.', 'نقوم بتركيب شاشات العشب الجداري ثلاثي الأبعاد عالي الكثافة، أو شبكات الأحواض الجدارية الحية المزودة بنظام ري أوتوماتيكي بالتنقيط الخفي، إلى جانب تفصيل مراكن وأحواض إسمنتية ورخامية مصممة خصيصاً لتناسب مقاسات وزوايا فناء منزلك وتبرز جمال الشتلات والزهور.', 'عشب جداري عازل للحرارة', 'أحواض فيبر جلاس ورخام', 'إخفاء عيوب الأسوار بأناقة', 'اطلب أحواضك الجدارية: 0505527615', 'tel:0505527615', 'css/10.jpg', '2026-11-23 20:10:23');

-- --------------------------------------------------------

--
-- Table structure for table `water_features`
--

CREATE TABLE `water_features` (
  `id` int(11) NOT NULL,
  `badge` varchar(100) DEFAULT 'سحر خرير الماء',
  `title` varchar(255) DEFAULT NULL,
  `paragraph_1` text DEFAULT NULL,
  `paragraph_2` text DEFAULT NULL,
  `feature_1` varchar(255) DEFAULT NULL,
  `feature_2` varchar(255) DEFAULT NULL,
  `feature_3` varchar(255) DEFAULT NULL,
  `feature_4` varchar(255) DEFAULT NULL,
  `cta_text` varchar(100) DEFAULT NULL,
  `cta_link` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'css/4.jpg',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `water_features`
--

INSERT INTO `water_features` (`id`, `badge`, `title`, `paragraph_1`, `paragraph_2`, `feature_1`, `feature_2`, `feature_3`, `feature_4`, `cta_text`, `cta_link`, `image`, `updated_at`) VALUES
(1, 'سحر خرير الماء', 'سحر الطبيعة الخضراء يسكن حديقتك', 'يضفي صوت الماء المتدفق روحاً من السكون والصفاء تبعد عنك صخب الحياة اليومية. نحن متخصصون في ابتكار الشلالات الجدارية بتشكيلات حجرية طبيعية ورخام بورسلان إسباني، مع مصبات ستانلس ستيل عريضة مقاومة للصدأ.', 'نعتني بأدق التفاصيل الفنية كالعزل المائي متعدد الطبقات لمنع أي تسريب نهائياً، واختيار مضخات مائية متطورة لا تصدر ضجيجاً وتتحمل التشغيل الطويل، وتزويد الشلال بكشافات ليد غاطسة متعددة الألوان تمنحك منظراً خيالياً في الليل.', 'شلالات ستيل مودرن', 'نوافير كلاسيكية رخام', 'بحيرات صخرية ريفية', 'شلالات زوايا وجلسات', 'شاهد أحدث تصاميم الشلالات عبر الواتساب', 'https://wa.me/966505527615?text=أرغب%20في%20تصميم%20شلال%20جداري', 'css/4.jpg', '2026-11-23 20:20:53');

-- --------------------------------------------------------

--
-- Table structure for table `why_choose_us`
--

CREATE TABLE `why_choose_us` (
  `id` int(11) NOT NULL,
  `icon` varchar(80) DEFAULT 'fa-star',
  `icon_color` varchar(50) DEFAULT 'text-success',
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `why_choose_us`
--

INSERT INTO `why_choose_us` (`id`, `icon`, `icon_color`, `title`, `description`, `sort_order`, `is_active`) VALUES
(1, 'fa-user-gear', 'text-success', 'طاقم مهندسين زراعيين', 'إشراف علمي وهندسي مباشر يضمن وضع النباتات والري بالأسلوب الأمثل لبيئتنا.', 1, 1),
(2, 'fa-award', 'text-warning', 'أصناف نباتية نخب أول', 'جميع شتلاتنا مقطوفة من مزارعنا بعناية وتخضع لفحص صحي شامل قبل الغرس.', 2, 1),
(3, 'fa-stopwatch', 'text-info', 'التزام صارم بالمواعيد', 'نحترم وقت العميل وننهي كافة بنود الاتفاق في الموعد المحدد دون أي تأخير.', 3, 1),
(4, 'fa-headset', 'text-danger', 'متابعة ما بعد التسليم', 'نظل على تواصل دائم معك لتقديم الاستشارات ومتابعة سلامة الشلالات وشبكات الري.', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `workflow_steps`
--

CREATE TABLE `workflow_steps` (
  `id` int(11) NOT NULL,
  `step_number` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `card_style` varchar(50) DEFAULT 'hover-mint-shift',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workflow_steps`
--

INSERT INTO `workflow_steps` (`id`, `step_number`, `title`, `description`, `card_style`, `sort_order`, `is_active`) VALUES
(1, 1, 'المعاينة ورفع المقاسات', 'يزورك مهندس المشتل لمعاينة الموقع وتحديد أبعاد الفناء ودراسة اتجاهات الشمس والرياح والتربة.', 'hover-mint-shift', 1, 1),
(2, 2, 'التصميم واختيار العناصر', 'نعرض عليك المخططات ونماذج الشلالات والبرجولات وتوزيع أحواض الزهور حتى نصل للنموذج المفضل لديك.', 'hover-rose-shift', 2, 1),
(3, 3, 'تجهيز الموقع والتمديدات', 'تسوية الأرض وتمديد مواسير شبكة الري والأسلاك الكهربائية المعزولة وبناء القواعد الخرسانية.', 'hover-sky-shift', 3, 1),
(4, 4, 'الزراعة والتركيب', 'فرش الثيل وتركيب المظلات وتشييد الشلال وغرس الأشجار وزهور الفل والياسمين والريحان بعناية فائقة.', 'hover-jasmine-shift', 4, 1),
(5, 5, 'التشغيل والتسليم', 'برمجة أجهزة التايمر، تشغيل الشلالات والإنارة، تقديم إرشادات الرعاية وتسليم الموقع نظيفاً وجاهزاً.', 'hover-rayhan-shift', 5, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_content`
--
ALTER TABLE `about_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `botanical_varieties`
--
ALTER TABLE `botanical_varieties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_read` (`is_read`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fragrant_haven`
--
ALTER TABLE `fragrant_haven`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `garden_checkup_items`
--
ALTER TABLE `garden_checkup_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hero_content`
--
ALTER TABLE `hero_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inspiration_content`
--
ALTER TABLE `inspiration_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance_plans`
--
ALTER TABLE `maintenance_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `navigation_links`
--
ALTER TABLE `navigation_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `night_lighting`
--
ALTER TABLE `night_lighting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pergolas_section`
--
ALTER TABLE `pergolas_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plant_quiz_questions`
--
ALTER TABLE `plant_quiz_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `portfolio_items`
--
ALTER TABLE `portfolio_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_photos`
--
ALTER TABLE `project_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pro_tips`
--
ALTER TABLE `pro_tips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seasonal_calendar`
--
ALTER TABLE `seasonal_calendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `smart_irrigation`
--
ALTER TABLE `smart_irrigation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stone_pathways`
--
ALTER TABLE `stone_pathways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vertical_gardens`
--
ALTER TABLE `vertical_gardens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `water_features`
--
ALTER TABLE `water_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `why_choose_us`
--
ALTER TABLE `why_choose_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workflow_steps`
--
ALTER TABLE `workflow_steps`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_content`
--
ALTER TABLE `about_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `botanical_varieties`
--
ALTER TABLE `botanical_varieties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fragrant_haven`
--
ALTER TABLE `fragrant_haven`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `garden_checkup_items`
--
ALTER TABLE `garden_checkup_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `hero_content`
--
ALTER TABLE `hero_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inspiration_content`
--
ALTER TABLE `inspiration_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `maintenance_plans`
--
ALTER TABLE `maintenance_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `navigation_links`
--
ALTER TABLE `navigation_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `night_lighting`
--
ALTER TABLE `night_lighting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pergolas_section`
--
ALTER TABLE `pergolas_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `plant_quiz_questions`
--
ALTER TABLE `plant_quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `portfolio_items`
--
ALTER TABLE `portfolio_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `project_photos`
--
ALTER TABLE `project_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `pro_tips`
--
ALTER TABLE `pro_tips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `seasonal_calendar`
--
ALTER TABLE `seasonal_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `smart_irrigation`
--
ALTER TABLE `smart_irrigation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stone_pathways`
--
ALTER TABLE `stone_pathways`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vertical_gardens`
--
ALTER TABLE `vertical_gardens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `water_features`
--
ALTER TABLE `water_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `why_choose_us`
--
ALTER TABLE `why_choose_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `workflow_steps`
--
ALTER TABLE `workflow_steps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
