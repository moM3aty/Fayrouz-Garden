-- =====================================================================
--  مشتل الفيروز - Database Schema & Seed
--  Database: u315614949_fayrouz
-- =====================================================================
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------
-- Admin Users
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `full_name` VARCHAR(100) DEFAULT NULL,
  `role` ENUM('admin','editor') NOT NULL DEFAULT 'admin',
  `last_login` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
-- Site Settings (Key/Value)
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `site_settings` (
  `setting_key` VARCHAR(100) NOT NULL,
  `setting_value` LONGTEXT DEFAULT NULL,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
-- Hero Section
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `hero_content` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` TEXT DEFAULT NULL,
  `lead` TEXT DEFAULT NULL,
  `body` TEXT DEFAULT NULL,
  `areas` TEXT DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT 'css/hero.jpeg',
  `btn1_text` VARCHAR(100) DEFAULT NULL,
  `btn1_link` VARCHAR(255) DEFAULT NULL,
  `btn1_style` VARCHAR(50) DEFAULT 'btn-hero-wa',
  `btn2_text` VARCHAR(100) DEFAULT NULL,
  `btn2_link` VARCHAR(255) DEFAULT NULL,
  `btn2_style` VARCHAR(50) DEFAULT 'btn-hero-call',
  `btn3_text` VARCHAR(100) DEFAULT NULL,
  `btn3_link` VARCHAR(255) DEFAULT NULL,
  `btn3_style` VARCHAR(50) DEFAULT 'btn-hero-outline',
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
-- About Section
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `about_content` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `badge` VARCHAR(100) DEFAULT NULL,
  `title` VARCHAR(255) DEFAULT NULL,
  `paragraph_1` TEXT DEFAULT NULL,
  `paragraph_2` TEXT DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT 'css/1.jpg',
  `feature_1_title` VARCHAR(100) DEFAULT NULL,
  `feature_1_text` TEXT DEFAULT NULL,
  `feature_1_icon` VARCHAR(50) DEFAULT 'fa-shield-halved',
  `feature_2_title` VARCHAR(100) DEFAULT NULL,
  `feature_2_text` TEXT DEFAULT NULL,
  `feature_2_icon` VARCHAR(50) DEFAULT 'fa-clock',
  `cta_text` VARCHAR(100) DEFAULT NULL,
  `cta_link` VARCHAR(255) DEFAULT NULL,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
-- Services
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `services` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `icon` VARCHAR(80) DEFAULT 'fa-seedling',
  `card_style` VARCHAR(50) DEFAULT 'hover-mint-shift',
  `gradient_start` VARCHAR(20) DEFAULT '#1d7168',
  `gradient_end` VARCHAR(20) DEFAULT '#33948a',
  `sort_order` INT(11) DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
-- Portfolio Items
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `portfolio_items` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) DEFAULT NULL,
  `image` VARCHAR(255) NOT NULL,
  `category` VARCHAR(100) DEFAULT NULL,
  `sort_order` INT(11) DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
-- Project Photos
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_photos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) DEFAULT NULL,
  `image` VARCHAR(255) NOT NULL,
  `sort_order` INT(11) DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
-- Botanical Varieties
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `botanical_varieties` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `icon` VARCHAR(80) DEFAULT 'fa-leaf',
  `badge_class` VARCHAR(50) DEFAULT 'bg-success',
  `card_style` VARCHAR(50) DEFAULT 'hover-jasmine-shift',
  `sort_order` INT(11) DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
-- Workflow Steps
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `workflow_steps` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `step_number` INT(11) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `card_style` VARCHAR(50) DEFAULT 'hover-mint-shift',
  `sort_order` INT(11) DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
-- Maintenance Plans
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `maintenance_plans` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `icon` VARCHAR(80) DEFAULT 'fa-calendar-check',
  `cta_text` VARCHAR(100) DEFAULT 'طلب تفاصيل البرنامج',
  `cta_link` VARCHAR(255) DEFAULT NULL,
  `card_style` VARCHAR(50) DEFAULT 'hover-mint-shift',
  `gradient_start` VARCHAR(20) DEFAULT '#1d7168',
  `gradient_end` VARCHAR(20) DEFAULT '#33948a',
  `btn_class` VARCHAR(50) DEFAULT 'btn-outline-success',
  `sort_order` INT(11) DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
-- Testimonials
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `client_name` VARCHAR(100) NOT NULL,
  `client_title` VARCHAR(100) DEFAULT NULL,
  `content` TEXT NOT NULL,
  `rating` TINYINT(1) DEFAULT 5,
  `image` VARCHAR(255) DEFAULT NULL,
  `sort_order` INT(11) DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
-- FAQs
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `question` VARCHAR(500) NOT NULL,
  `answer` TEXT NOT NULL,
  `sort_order` INT(11) DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
-- Districts
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `districts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `sort_order` INT(11) DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
-- Contact Messages
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `district` VARCHAR(100) DEFAULT NULL,
  `message` TEXT NOT NULL,
  `is_read` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `is_read` (`is_read`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------
-- Navigation Links
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `navigation_links` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `label` VARCHAR(100) NOT NULL,
  `href` VARCHAR(255) NOT NULL,
  `icon` VARCHAR(80) DEFAULT NULL,
  `sort_order` INT(11) DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `show_in_nav` TINYINT(1) DEFAULT 1,
  `show_in_drawer` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
--  SEED DATA
-- =====================================================================

-- Site Settings
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
('site_name',       'مشتل الفيروز'),
('site_tagline',    'أبو محمد لتنسيق الحدائق'),
('site_description','مشتل الفيروز - أبو محمد لتنسيق الحدائق بالرياض: تصميم وتنفيذ حدائق الفلل والاستراحات، شبكات ري، مظلات وبرجولات، شلالات، وزهور الفل والياسمين. الملقا والنرجس والعارض. اتصل 0505527615'),
('phone',           '0505527615'),
('phone_intl',      '966505527615'),
('whatsapp',        '966505527615'),
('email',           ''),
('address',         'الرياض، المملكة العربية السعودية'),
('logo',            'css/logo.jpeg'),
('map_embed',       ''),
('facebook',        ''),
('instagram',       ''),
('twitter',         ''),
('tiktok',          ''),
('snapchat',        ''),
('primary_color',   '#1d7168'),
('secondary_color', '#123f3e'),
('meta_keywords',   'تنسيق حدائق الرياض, مشتل الفيروز, أبو محمد لتنسيق الحدائق, لاندسكيب الرياض, تنسيق حدائق منزلية'),
('meta_author',     'مشتل الفيروز'),
('footer_credit',   'تصميم وتطوير احترافي')
ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);

-- Hero Content
INSERT INTO `hero_content` 
(`title`,`lead`,`body`,`areas`,`image`,`btn1_text`,`btn1_link`,`btn1_style`,`btn2_text`,`btn2_link`,`btn2_style`,`btn3_text`,`btn3_link`,`btn3_style`)
VALUES
('تنسيق حدائق بالرياض<br/>مساحة خضراء تشبهك',
 'مشتل الفيروز | أبو محمد لتنسيق الحدائق في الرياض',
 'نصمم وننفذ حدائق الفلل والاستراحات من الفكرة إلى التسليم: شبكات ري، مظلات وبرجولات، شلالات ونوافير، وزهور الفل والياسمين والريحان.',
 'الملقا والنرجس والياسمين والقيروان والعارض والصحافة',
 'css/hero.jpeg',
 'تواصل واتساب الآن','https://wa.me/966505527615?text=مرحباً%20مشتل%20الفيروز،%20أرغب%20في%20طلب%20معاينة%20لتنسيق%20حديقتي','btn-hero-wa',
 'اتصل فوري 0505527615','tel:0505527615','btn-hero-call',
 'تصفح أعمالنا','#portfolio','btn-hero-outline');

-- About Content
INSERT INTO `about_content`
(`badge`,`title`,`paragraph_1`,`paragraph_2`,`image`,`feature_1_title`,`feature_1_text`,`feature_1_icon`,`feature_2_title`,`feature_2_text`,`feature_2_icon`,`cta_text`,`cta_link`)
VALUES
('رؤيتنا وفلسفتنا',
 'مشتل الفيروز.. حين تعانق الطبيعة ذوقك المعماري الرفيع',
 'تأسس <strong>مشتل الفيروز لتنسيق الحدائق المنزلية</strong> ليصنع فارقاً حقيقياً في مفهوم المساحات الخضراء المنزلية. نؤمن أن حديقة البيت ليست مجرد رقعة عشبية، بل هي الملاذ الهادئ الذي تلتقي فيه العائلة، ومصدر الطاقة الإيجابية والسكينة بعد عناء اليوم.',
 'يقود مشتلنا طاقم متخصص من المهندسين الزراعيين وفنيي تنسيق اللاندسكيب المحترفين، حيث نجمع بين المعرفة العميقة بمتطلبات البيئة والمناخ المحلي، وبين أحدث خطوط التصميم الديكوري العصري.',
 'css/1.jpg',
 'ضمان الجودة الفائقة','نضمن لك نمو النباتات وسلامة التمديدات والشلالات.','fa-shield-halved',
 'سرعة والتزام زمني','تسليم المشاريع في الوقت المتفق عليه بأعلى دقة.','fa-clock',
 'تواصل مع مهندس المشتل: 0505527615','tel:0505527615');

-- Services
INSERT INTO `services` (`title`,`description`,`icon`,`card_style`,`gradient_start`,`gradient_end`,`sort_order`) VALUES
('تصميم حدائق 3D واوتوكاد','نرفع مساحات فنائك ونقدم مخططات ثلاثية الأبعاد واقعية تمكنك من رؤية حديقة أحلامك وتوزيع الأشجار والجلسات والممرات قبل البدء بالتنفيذ.','fa-compass-drafting','hover-mint-shift','#1d7168','#33948a',1),
('الشلالات والنوافير الجدارية المودرن','تصميم وبناء شلالات حجرية ورخامية عصرية بإضاءات مائية هادئة ومضخات غاطسة إيطالية مانعة للصوت تضفي سحر الطبيعة العذب.','fa-water','hover-sky-shift','#116da6','#4fa9d6',2),
('شبكات الري الأوتوماتيكية الذكية','تركيب منظومات ري متطورة بالرشاشات التلسكوبية والتنقيط مع أجهزة توقيت رقمية موفرة للمياه تضمن ري جميع النباتات في مواعيدها بدقة.','fa-faucet-drip','hover-jasmine-shift','#ca8a04','#fde047',3),
('المظلات والبرجولات والجلسات','تفصيل برجولات خشبية معالجة ضد الرطوبة والحرارة، ومظلات حديد قص ليزر وقماش ألماني وأرضيات باركيه خارجية متينة تمنحك جلسة استرخاء ملوكية.','fa-umbrella-beach','hover-rayhan-shift','#4d7c0f','#84cc16',4),
('زراعة الأشجار المثمرة والزهور العطرية','غرس أشجار النخيل والحمضيات والجهنمية، وأحواض الفل والياسمين والريحان الفواح والزهور الموسمية المستوردة لتبقى حديقتك عامرة بالألوان والعطور.','fa-seedling','hover-purple-shift','#9333ea','#c084fc',5);

-- Botanical Varieties
INSERT INTO `botanical_varieties` (`title`,`description`,`icon`,`badge_class`,`card_style`,`sort_order`) VALUES
('زهور الفل البلدي والعراقي','شجيرات الفل البيضاء ذات العبير الأخّاذ في المساء، زهور ناصعة البياض تدوم فترات طويلة وتناسب الأحواض القريبة من مجالس الجلوس.','fa-certificate','bg-warning','hover-jasmine-shift',1),
('الياسمين الهندي والمتسلق','نباتات متسلقة بديعة لتغطية الأسوار والمظلات بالخضرة والزهور العطرية الفواحة، مع نمو سريع وكثافة ورقية تمنح خصوصية تامة.','fa-spa','bg-danger','hover-rose-shift',2),
('الريحان الإيطالي والبلدي الفواح','نباتات عشبية عطرية لا غنى عنها في باحة كل منزل، تعبق بأجمل الروائح المنعشة وتطرد الحشرات طبيعياً وتصلح للزراعة في أحواض ديكورية.','fa-leaf','bg-success','hover-rayhan-shift',3),
('نخيل واشنطونيا ونخيل عربي','أشجار النخيل الباسقة التي تعكس الهوية والفخامة، يتم توريدها بأطوال مختلفة مع الضمان الكامل لنجاح الغرس وتناسق المسافات.','fa-tree','bg-success','hover-mint-shift',4),
('أشجار الفواكه والحمضيات','شتلات الليمون الشهري، البرتقال، الرمان، والتين المزروعة في أكياس زراعية قوية وجاهزة للإنتاج السريع في حدائق المنازل.','fa-lemon','bg-info','hover-sky-shift',5),
('شجيرات الجهنمية (البوجنفيل)','ألوان زاهية لا تقاوم من الوردي والبنفسجي والأبيض والبرتقالي، تتميز بقدرتها الفائقة على تحمل الشمس وتزهر طوال العام بغزارة.','fa-sun','bg-primary','hover-purple-shift',6);

-- Workflow
INSERT INTO `workflow_steps` (`step_number`,`title`,`description`,`card_style`,`sort_order`) VALUES
(1,'المعاينة ورفع المقاسات','يزورك مهندس المشتل لمعاينة الموقع وتحديد أبعاد الفناء ودراسة اتجاهات الشمس والرياح والتربة.','hover-mint-shift',1),
(2,'التصميم واختيار العناصر','نعرض عليك المخططات ونماذج الشلالات والبرجولات وتوزيع أحواض الزهور حتى نصل للنموذج المفضل لديك.','hover-rose-shift',2),
(3,'تجهيز الموقع والتمديدات','تسوية الأرض وتمديد مواسير شبكة الري والأسلاك الكهربائية المعزولة وبناء القواعد الخرسانية.','hover-sky-shift',3),
(4,'الزراعة والتركيب','فرش الثيل وتركيب المظلات وتشييد الشلال وغرس الأشجار وزهور الفل والياسمين والريحان بعناية فائقة.','hover-jasmine-shift',4),
(5,'التشغيل والتسليم','برمجة أجهزة التايمر، تشغيل الشلالات والإنارة، تقديم إرشادات الرعاية وتسليم الموقع نظيفاً وجاهزاً.','hover-rayhan-shift',5);

-- Maintenance Plans
INSERT INTO `maintenance_plans` (`title`,`description`,`icon`,`cta_text`,`cta_link`,`card_style`,`gradient_start`,`gradient_end`,`btn_class`,`sort_order`) VALUES
('برنامج العناية الأسبوعي','يشمل قص وتسوية الثيل الطبيعي، إزالة الأوراق المتساقطة، تنظيف ممرات الحديقة، وإزالة الأعشاب الضارة من أحواض الزهور لتبقى الحديقة مرتبة دائماً.','fa-calendar-check','طلب تفاصيل البرنامج','https://wa.me/966505527615?text=أود%20الاستفسار%20عن%20برنامج%20الصيانة%20الأسبوعي','hover-mint-shift','#1d7168','#33948a','btn-outline-success',1),
('برنامج الصيانة نصف الشهري','يتضمن تقليم وتشكيل أشجار الزينة والنخيل، فحص واختبار رشاشات شبكة الري وتنظيف فلاترها، وإضافة الأسمدة المحفزة للنمو الخضري والزهري.','fa-scissors','طلب تفاصيل البرنامج','https://wa.me/966505527615?text=أود%20الاستفسار%20عن%20برنامج%20الصيانة%20نصف%20الشهري','hover-rose-shift','#e0496b','#f0aeb9','btn-outline-danger',2),
('برنامج التأهيل الموسمي الشامل','تهوية التربة الزراعية، مكافحة الآفات والحشرات بمبيدات آمنة، تجديد الزهور الموسمية الشتوية والصيفية، وصيانة مضخات الشلالات والنوافير.','fa-spray-can-sparkles','طلب تفاصيل البرنامج','https://wa.me/966505527615?text=أود%20الاستفسار%20عن%20برنامج%20التأهيل%20الموسمي','hover-sky-shift','#116da6','#4fa9d6','btn-outline-primary',3);

-- Districts
INSERT INTO `districts` (`name`,`sort_order`) VALUES
('الملقا',1),('النرجس',2),('الياسمين',3),('القيروان',4),('العارض',5),('الصحافة',6);

-- Navigation Links
INSERT INTO `navigation_links` (`label`,`href`,`icon`,`sort_order`,`show_in_nav`,`show_in_drawer`) VALUES
('الرئيسية','#hero','fa-house',1,1,1),
('من نحن','#about','fa-seedling',2,1,1),
('الزهرة والشجرة','#garden-interactive','fa-tree',3,1,1),
('خدماتنا','#services','fa-wand-magic-sparkles',4,1,1),
('شبكات الري','#smart-irrigation','fa-faucet-drip',5,0,1),
('الشلالات والنوافير','#water-features','fa-water',6,0,1),
('الفل والياسمين والريحان','#fragrant-haven','fa-fan',7,0,1),
('المظلات والبرجولات','#pergolas','fa-umbrella-beach',8,0,1),
('معرض الأعمال','#portfolio','fa-images',9,1,1),
('صور المشاريع','#project-photos','fa-camera',10,1,1),
('الأسئلة الشائعة','#faq','fa-circle-question',11,1,1),
('اختار نباتاتك','#plant-quiz','fa-leaf',12,0,1),
('شخّص حديقتك','#garden-checkup','fa-stethoscope',13,0,1),
('أسرار المهندس','#pro-tips','fa-lightbulb',14,0,1),
('موقعنا على الخريطة','#location','fa-location-dot',15,0,1),
('تواصل معنا','#contact','fa-phone',16,1,1);

SET FOREIGN_KEY_CHECKS = 1;
-- =====================================================================
--  END
-- =====================================================================