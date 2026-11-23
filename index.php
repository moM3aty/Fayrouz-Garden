<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';

try {
    $settings = [];
    foreach (db()->query('SELECT setting_key, setting_value FROM site_settings') as $r) {
        $settings[$r['setting_key']] = $r['setting_value'];
    }
    $hero         = db()->query('SELECT * FROM hero_content LIMIT 1')->fetch() ?: [];
    $about        = db()->query('SELECT * FROM about_content LIMIT 1')->fetch() ?: [];
    $services     = db()->query('SELECT * FROM services WHERE is_active=1 ORDER BY sort_order, id')->fetchAll();
    $botanical    = db()->query('SELECT * FROM botanical_varieties WHERE is_active=1 ORDER BY sort_order, id')->fetchAll();
    $maintenance  = db()->query('SELECT * FROM maintenance_plans WHERE is_active=1 ORDER BY sort_order, id')->fetchAll();
    $workflow     = db()->query('SELECT * FROM workflow_steps WHERE is_active=1 ORDER BY sort_order, step_number')->fetchAll();
    $portfolio    = db()->query('SELECT * FROM portfolio_items WHERE is_active=1 ORDER BY sort_order, id')->fetchAll();
    $photos       = db()->query('SELECT * FROM project_photos WHERE is_active=1 ORDER BY sort_order, id')->fetchAll();
    $testimonials = db()->query('SELECT * FROM testimonials WHERE is_active=1 ORDER BY sort_order, id DESC')->fetchAll();
    $faqs         = db()->query('SELECT * FROM faqs WHERE is_active=1 ORDER BY sort_order, id')->fetchAll();
    $districts    = db()->query('SELECT * FROM districts WHERE is_active=1 ORDER BY sort_order, id')->fetchAll();
    $navLinks     = db()->query('SELECT * FROM navigation_links WHERE is_active=1 ORDER BY sort_order, id')->fetchAll();
    $whyChooseUs      = db()->query('SELECT * FROM why_choose_us WHERE is_active=1 ORDER BY sort_order, id')->fetchAll();
$seasonalCalendar = db()->query('SELECT * FROM seasonal_calendar WHERE is_active=1 ORDER BY sort_order, id')->fetchAll();
$proTips          = db()->query('SELECT * FROM pro_tips WHERE is_active=1 ORDER BY sort_order, id')->fetchAll();
$stonePathways    = db()->query('SELECT * FROM stone_pathways LIMIT 1')->fetch() ?: [];
$verticalGardens  = db()->query('SELECT * FROM vertical_gardens LIMIT 1')->fetch() ?: [];
$inspiration     = db()->query('SELECT * FROM inspiration_content LIMIT 1')->fetch() ?: [];
$smartIrrigation = db()->query('SELECT * FROM smart_irrigation LIMIT 1')->fetch() ?: [];
$waterFeatures   = db()->query('SELECT * FROM water_features LIMIT 1')->fetch() ?: [];
$pergolasData    = db()->query('SELECT * FROM pergolas_section LIMIT 1')->fetch() ?: [];
$fragrantData    = db()->query('SELECT * FROM fragrant_haven LIMIT 1')->fetch() ?: [];
$nightLighting   = db()->query('SELECT * FROM night_lighting LIMIT 1')->fetch() ?: [];
$quizQuestions   = db()->query('SELECT * FROM plant_quiz_questions WHERE is_active=1 ORDER BY sort_order')->fetchAll();
$checkupItems    = db()->query('SELECT * FROM garden_checkup_items WHERE is_active=1 ORDER BY sort_order')->fetchAll();
$whyChooseUs     = db()->query('SELECT * FROM why_choose_us WHERE is_active=1 ORDER BY sort_order, id')->fetchAll();
$seasonalCalendar = db()->query('SELECT * FROM seasonal_calendar WHERE is_active=1 ORDER BY sort_order, id')->fetchAll();
$proTips         = db()->query('SELECT * FROM pro_tips WHERE is_active=1 ORDER BY sort_order, id')->fetchAll();
$stonePathways   = db()->query('SELECT * FROM stone_pathways LIMIT 1')->fetch() ?: [];
$verticalGardens = db()->query('SELECT * FROM vertical_gardens LIMIT 1')->fetch() ?: [];
} catch (Throwable $e) {
    error_log('index load: ' . $e->getMessage());
    http_response_code(500);
    die('حدث خطأ في تحميل الموقع.');
}

function s(string $key, string $default = ''): string {
    global $settings;
    $val = $settings[$key] ?? '';
    return $val !== '' ? (string)$val : $default;
}

$phone       = s('phone', '0505527615');
$phoneIntl   = s('phone_intl', '966505527615');
$whatsapp    = s('whatsapp', '966505527615');
$siteName    = s('site_name', 'مشتل الفيروز');
$logo        = s('logo', 'css/logo.jpeg');

$navItems    = array_values(array_filter($navLinks, fn($n) => (int)$n['show_in_nav'] === 1));
$drawerItems = array_values(array_filter($navLinks, fn($n) => (int)$n['show_in_drawer'] === 1));
$areasText   = !empty($hero['areas']) ? $hero['areas'] : 'الملقا والنرجس والياسمين والقيروان والعارض والصحافة';

$oldContact = $_SESSION['contact_old'] ?? [];
unset($_SESSION['contact_old']);

include __DIR__ . '/includes/head.php';
?>
<body>
<?php include __DIR__ . '/includes/navbar.php'; ?>

<!-- ============ HERO ============ -->
<section class="hero-section" id="hero">
<canvas class="hero-canvas" id="heroCanvas"></canvas>
<div class="hero-split">
<div class="hero-media">
<img alt="تنسيق حدائق منزلية في الرياض - مشتل الفيروز" onerror="this.style.display='none';if(!this.nextElementSibling||!this.nextElementSibling.classList.contains('missing-image')){const x=document.createElement('div');x.className='missing-image';x.textContent='الصورة غير مرفقة';this.after(x)}" src="<?= !empty($hero['image']) ? e($hero['image']) : 'css/hero.jpeg' ?>" fetchpriority="high"/>
<div class="hero-copy">
<h1><?= !empty($hero['title']) ? $hero['title'] : 'تنسيق حدائق بالرياض<br/>مساحة خضراء تشبهك' ?></h1>
<p class="hero-lead"><?= !empty($hero['lead']) ? e($hero['lead']) : 'مشتل الفيروز | أبو محمد لتنسيق الحدائق في الرياض' ?></p>
<p class="hero-body"><?= !empty($hero['body']) ? e($hero['body']) : 'نصمم وننفذ حدائق الفلل والاستراحات من الفكرة إلى التسليم: شبكات ري، مظلات وبرجولات، شلالات ونوافير، وزهور الفل والياسمين والريحان.' ?></p>
<p class="hero-areas"><i class="fa-solid fa-location-dot"></i> نخدم <?= e($areasText) ?></p>
</div></div>
<div class="hero-actions">
<div class="d-flex flex-wrap gap-3 justify-content-center">
<a class="btn-action-main btn-hero-wa" href="<?= e($hero['btn1_link'] ?? 'https://wa.me/'.$whatsapp) ?>" rel="noopener noreferrer" target="_blank">
<i class="fa-brands fa-whatsapp fs-5"></i> <?= e($hero['btn1_text'] ?? 'تواصل واتساب الآن') ?>
</a>
<a class="btn-action-main btn-hero-call" href="<?= e($hero['btn2_link'] ?? 'tel:'.$phone) ?>">
<i class="fa-solid fa-phone-flip fs-5"></i> <?= e($hero['btn2_text'] ?? 'اتصل فوري '.$phone) ?>
</a>
<a class="btn-action-main btn-hero-outline" href="<?= e($hero['btn3_link'] ?? '#portfolio') ?>">
<i class="fa-solid fa-images fs-5"></i> <?= e($hero['btn3_text'] ?? 'تصفح أعمالنا') ?>
</a>
</div>
</div>
</div>
</section>

<!-- ============ ABOUT ============ -->
<section class="section-padding bg-white" id="about">
<div class="container">
<div class="row align-items-center gy-5">
<div class="col-lg-6">
<div class="section-badge badge-green"><i class="fa-solid fa-leaf"></i> <?= e($about['badge'] ?? 'رؤيتنا وفلسفتنا') ?></div>
<h2 class="section-title"><?= !empty($about['title']) ? e($about['title']) : 'مشتل الفيروز.. حين تعانق الطبيعة ذوقك المعماري الرفيع' ?></h2>
<p class="text-muted fs-5 mb-4" style="line-height: 2;">
            <?= !empty($about['paragraph_1']) ? $about['paragraph_1'] : 'تأسس <strong>مشتل الفيروز لتنسيق الحدائق المنزلية</strong> ليصنع فارقاً حقيقياً في مفهوم المساحات الخضراء المنزلية. نؤمن أن حديقة البيت ليست مجرد رقعة عشبية، بل هي الملاذ الهادئ الذي تلتقي فيه العائلة، ومصدر الطاقة الإيجابية والسكينة بعد عناء اليوم.' ?>
          </p>
<p class="text-muted mb-4" style="line-height: 1.9;">
            <?= !empty($about['paragraph_2']) ? $about['paragraph_2'] : 'يقود مشتلنا طاقم متخصص من المهندسين الزراعيين وفنيي تنسيق اللاندسكيب المحترفين، حيث نجمع بين المعرفة العميقة بمتطلبات البيئة والمناخ المحلي، وبين أحدث خطوط التصميم الديكوري العصري. نحرص على اختيار أفضل أنواع التربة الخصبة، وتمديد أحدث أنظمة الري المتطورة التي توفر استهلاك المياه، وزراعة شتلات الزهور النضرة كالفل والياسمين والريحان والورود الجورية التي تملأ الأرجاء عبقاً وألقاً.' ?>
          </p>
<div class="row g-3 mb-4">
<div class="col-sm-6">
<div class="p-3 rounded-3 bg-light border-start border-4 border-success">
<h5 class="fw-bold text-dark mb-1"><i class="fa-solid <?= e($about['feature_1_icon'] ?? 'fa-shield-halved') ?> text-success me-2"></i> <?= e($about['feature_1_title'] ?? 'ضمان الجودة الفائقة') ?></h5>
<small class="text-muted"><?= e($about['feature_1_text'] ?? 'نضمن لك نمو النباتات وسلامة التمديدات والشلالات.') ?></small>
</div>
</div>
<div class="col-sm-6">
<div class="p-3 rounded-3 bg-light border-start border-4 border-danger">
<h5 class="fw-bold text-dark mb-1"><i class="fa-solid <?= e($about['feature_2_icon'] ?? 'fa-clock') ?> text-danger me-2"></i> <?= e($about['feature_2_title'] ?? 'سرعة والتزام زمني') ?></h5>
<small class="text-muted"><?= e($about['feature_2_text'] ?? 'تسليم المشاريع في الوقت المتفق عليه بأعلى دقة.') ?></small>
</div>
</div>
</div>
<a class="btn btn-success fw-bold px-4 py-3 rounded-pill shadow-sm" href="<?= e($about['cta_link'] ?? 'tel:'.$phone) ?>">
<i class="fa-solid fa-phone me-2"></i> <?= e($about['cta_text'] ?? 'تواصل مع مهندس المشتل: '.$phone) ?>
          </a>
</div>
<div class="col-lg-6">
<div class="text-img-box">
<img alt="تنسيق حدائق مشتل الفيروز" onerror="this.style.display='none';if(!this.nextElementSibling||!this.nextElementSibling.classList.contains('missing-image')){const x=document.createElement('div');x.className='missing-image';x.textContent='الصورة غير مرفقة';this.after(x)}" src="<?= !empty($about['image']) ? e($about['image']) : 'css/1.jpg' ?>"/>
</div>
</div>
</div>
</div>
</section>

<!-- ============ INSPIRATION ============ -->
<section class="bg-section-parallax" id="inspiration" style="background-image: url('<?= e($inspiration['background_image'] ?? 'css/1.jpg') ?>');">
<div class="bg-overlay-dark"></div>
<div class="container text-center">
<div class="section-badge badge-green mb-3"><i class="fa-solid fa-wand-magic"></i> <?= e($inspiration['badge'] ?? 'لمسة سحرية') ?></div>
<h2 class="display-5 fw-black mb-4"><?= e($inspiration['title'] ?? '') ?></h2>
<p class="lead max-w-75 mx-auto mb-5 text-light fs-5" style="max-width: 800px; line-height: 2;">
        <?= e($inspiration['description'] ?? '') ?>
      </p>
<div class="d-flex flex-wrap justify-content-center gap-3">
<a class="btn-action-main btn-hero-call" href="<?= e($inspiration['btn1_link'] ?? 'tel:'.$phone) ?>">
<i class="fa-solid fa-phone-volume"></i> <?= e($inspiration['btn1_text'] ?? 'اطلب المعاينة الآن') ?>
        </a>
<a class="btn-action-main btn-hero-wa" href="<?= e($inspiration['btn2_link'] ?? 'https://wa.me/'.$whatsapp) ?>" target="_blank" rel="noopener">
<i class="fa-brands fa-whatsapp"></i> <?= e($inspiration['btn2_text'] ?? 'استشارة واتساب مجانية') ?>
        </a>
</div>
</div>
</section>

<!-- ============ GARDEN INTERACTIVE ============ -->
<section class="section-padding bg-white" id="garden-interactive">
<div class="container">
<div class="text-center mb-5">
<div class="section-badge badge-pink"><i class="fa-solid fa-wand-sparkles"></i> تجربة فريدة</div>
<h2 class="section-title">شجرة الفيروز وزهرة الفل والياسمين التفاعلية</h2>
<p class="section-subtitle">
          تفاعل مع الحديقة الرقمية لمشتل الفيروز! اضغط على الأزرار لسقي شجرة الفيروز ورؤية أوراقها تتلألأ خضاراً، واجعل زهرة الياسمين تتفتح وتفيض بألوان البتلات ونفحات العطر الفواحة.
        </p>
</div>
<div class="interactive-garden-box text-center">
<div class="water-droplets-container" id="dropletsContainer"></div>
<div class="flower-tree-stage" id="flowerTreeStage">
<div class="tree-container">
<svg class="interactive-tree-svg" height="260" id="treeSvg" viewbox="0 0 200 240" width="220">
<path d="M90,230 L110,230 L105,140 L95,140 Z" fill="#78350f" stroke="#451a03" stroke-width="3"></path>
<path d="M98,160 Q70,140 60,110" fill="none" stroke="#78350f" stroke-width="6"></path>
<path d="M102,150 Q130,130 140,100" fill="none" stroke="#78350f" stroke-width="6"></path>
<circle class="tree-leaf-cluster" cx="100" cy="80" fill="#147a4b" id="leaf1" opacity="0.95" r="48"></circle>
<circle class="tree-leaf-cluster" cx="65" cy="100" fill="#1fa861" id="leaf2" opacity="0.9" r="38"></circle>
<circle class="tree-leaf-cluster" cx="135" cy="95" fill="#16a34a" id="leaf3" opacity="0.9" r="40"></circle>
<circle class="tree-leaf-cluster" cx="100" cy="45" fill="#4ade80" id="leaf4" opacity="0.95" r="32"></circle>
</svg>
<h5 class="fw-bold text-success mt-2">شجرة الفيروز الوارفة</h5>
</div>
<div class="flower-container">
<svg class="interactive-flower-svg" height="260" id="flowerSvg" viewbox="0 0 300 300" width="220">
<path d="M150,290 Q150,210 150,150" fill="none" stroke="#147a4b" stroke-width="8"></path>
<path d="M150,220 Q120,200 110,180 Q140,190 150,220" fill="#1fa861"></path>
<path d="M150,240 Q180,220 190,200 Q160,210 150,240" fill="#16a34a"></path>
<g id="petalsGroup">
<circle class="flower-petal" cx="150" cy="90" fill="#e0496b" opacity="0.88" r="35"></circle>
<circle class="flower-petal" cx="205" cy="125" fill="#ec8093" opacity="0.88" r="35"></circle>
<circle class="flower-petal" cx="185" cy="185" fill="#e57aa2" opacity="0.88" r="35"></circle>
<circle class="flower-petal" cx="115" cy="185" fill="#f0aeb9" opacity="0.88" r="35"></circle>
<circle class="flower-petal" cx="95" cy="125" fill="#e0496b" opacity="0.88" r="35"></circle>
</g>
<circle cx="150" cy="150" fill="#fde047" id="flowerCenter" r="30" stroke="#d9a50a" stroke-width="4"></circle>
</svg>
<h5 class="fw-bold text-danger mt-2" id="flowerNameLabel">زهرة الياسمين والفل</h5>
</div>
</div>
<div class="mt-4 pt-3 border-top d-flex flex-wrap justify-content-center gap-3">
<button class="garden-ctrl-btn ctrl-btn-water" onclick="waterTheGarden()" type="button">
<i class="fa-solid fa-faucet-drip"></i> اسقِ شجرة الفيروز 💧
          </button>
<button class="garden-ctrl-btn ctrl-btn-bloom" onclick="bloomTheFlower()" type="button">
<i class="fa-solid fa-spa"></i> تفتيح بتلات الزهرة 🌸
          </button>
<button class="garden-ctrl-btn ctrl-btn-fol" onclick="changeFlowerAura('fol')" type="button">
<i class="fa-solid fa-certificate"></i> نفحة الفل الأبيض 🌼
          </button>
<button class="garden-ctrl-btn ctrl-btn-rayhan" onclick="changeFlowerAura('rayhan')" type="button">
<i class="fa-solid fa-leaf"></i> عطر الريحان البلدي 🌿
          </button>
</div>
<div class="mt-3 text-muted fw-bold" id="gardenStatusText">
          انقر فوق الأزرار لترى سحر نمو الأشجار وتفتح الزهور في مشتل الفيروز!
        </div>
</div>
</div>
</section>

<!-- ============ SERVICES ============ -->
<section class="section-padding bg-light" id="services">
<div class="container">
<div class="text-center mb-5">
<div class="section-badge badge-blue"><i class="fa-solid fa-cubes"></i> خدمات متكاملة</div>
<h2 class="section-title">باقة خدمات مشتل الفيروز الشاملة لتنسيق الحدائق</h2>
<p class="section-subtitle">
          نقدم منظومة لاندسكيب متكاملة تغنيك عن الاستعانة بجهات متعددة، بدءاً من التصميم والمخططات الهندسية وحتى التسليم المتكامل بأرقى المعايير.
        </p>
</div>
<div class="row g-4">
<?php if (!empty($services)): ?>
  <?php foreach ($services as $svc): 
    $grad_start = $svc['gradient_start'] ?? '#147a4b';
    $grad_end = $svc['gradient_end'] ?? '#1fa861';
  ?>
  <div class="col-lg-4 col-md-6">
  <div class="<?= e($svc['card_style'] ?? 'hover-mint-shift') ?> p-4 h-100">
  <div class="step-badge-number mb-3" style="background: linear-gradient(135deg, <?= e($grad_start) ?>, <?= e($grad_end) ?>);"><i class="fa-solid <?= e($svc['icon'] ?? 'fa-check') ?>"></i></div>
  <h4 class="h5 fw-bold text-dark mb-3"><?= e($svc['title']) ?></h4>
  <p class="text-muted mb-0"><?= e($svc['description']) ?></p>
  </div>
  </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-lg-4 col-md-6">
  <div class="hover-mint-shift p-4 h-100">
  <div class="step-badge-number mb-3"><i class="fa-solid fa-compass-drafting"></i></div>
  <h4 class="h5 fw-bold text-dark mb-3">تصميم حدائق 3D واوتوكاد</h4>
  <p class="text-muted mb-0">نرفع مساحات فنائك ونقدم مخططات ثلاثية الأبعاد واقعية تمكنك من رؤية حديقة أحلامك وتوزيع الأشجار والجلسات والممرات قبل البدء بالتنفيذ.</p>
  </div>
  </div>
<?php endif; ?>
</div>
</div>
</section>

<!-- ============ SMART IRRIGATION ============ -->
<section class="bg-section-parallax" id="smart-irrigation" style="background-image: url('<?= e($smartIrrigation['background_image'] ?? 'css/3.jpg') ?>');">
<div class="bg-overlay-dark"></div>
<div class="container">
<div class="row align-items-center gy-5">
<div class="col-lg-7">
<div class="section-badge badge-blue mb-3"><i class="fa-solid fa-droplet"></i> <?= e($smartIrrigation['badge'] ?? 'ترشيد واستدامة') ?></div>
<h2 class="display-6 fw-black mb-4"><?= e($smartIrrigation['title'] ?? '') ?></h2>
<p class="text-light fs-5 mb-4" style="line-height: 2;"><?= e($smartIrrigation['description'] ?? '') ?></p>
<div class="row g-3">
<div class="col-sm-6"><div class="p-3 rounded-3" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(8px);">
<h5 class="fw-bold text-warning mb-1"><i class="fa-solid fa-faucet text-info me-2"></i> <?= e($smartIrrigation['feature_1_title'] ?? '') ?></h5>
<small class="text-light"><?= e($smartIrrigation['feature_1_text'] ?? '') ?></small>
</div></div>
<div class="col-sm-6"><div class="p-3 rounded-3" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(8px);">
<h5 class="fw-bold text-warning mb-1"><i class="fa-solid fa-clock text-info me-2"></i> <?= e($smartIrrigation['feature_2_title'] ?? '') ?></h5>
<small class="text-light"><?= e($smartIrrigation['feature_2_text'] ?? '') ?></small>
</div></div>
</div>
</div>
<div class="col-lg-5 text-center">
<div class="p-4 rounded-4" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); border: 2px solid rgba(255,255,255,0.25);">
<i class="fa-solid fa-gauge-high fs-1 text-info mb-3"></i>
<h4 class="fw-bold text-white mb-2"><?= e($smartIrrigation['stat_title'] ?? '') ?></h4>
<p class="text-light small mb-4"><?= e($smartIrrigation['stat_text'] ?? '') ?></p>
<a class="btn btn-light text-success fw-bold px-4 py-2 rounded-pill" href="<?= e($smartIrrigation['cta_link'] ?? 'tel:'.$phone) ?>">
<i class="fa-solid fa-phone me-2"></i> <?= e($smartIrrigation['cta_text'] ?? '') ?>
            </a>
</div>
</div>
</div>
</div>
</section>

<!-- ============ WATER FEATURES ============ -->
<section class="section-padding bg-light" id="water-features">
<div class="container">
<div class="row align-items-center gy-5">
<div class="col-lg-6">
<div class="section-badge badge-blue"><i class="fa-solid fa-water"></i> <?= e($waterFeatures['badge'] ?? '') ?></div>
<h2 class="section-title"><?= e($waterFeatures['title'] ?? '') ?></h2>
<p class="text-muted fs-5 mb-4" style="line-height: 2;"><?= e($waterFeatures['paragraph_1'] ?? '') ?></p>
<p class="text-muted mb-4" style="line-height: 1.9;"><?= e($waterFeatures['paragraph_2'] ?? '') ?></p>
<div class="d-flex flex-wrap gap-3 mb-4">
<?php foreach (['feature_1','feature_2','feature_3','feature_4'] as $fk): if (!empty($waterFeatures[$fk])): ?>
<span class="badge bg-white text-dark border p-2 px-3 rounded-pill fw-bold"><i class="fa-solid fa-check text-primary me-1"></i> <?= e($waterFeatures[$fk]) ?></span>
<?php endif; endforeach; ?>
</div>
<a class="btn btn-primary fw-bold px-4 py-3 rounded-pill shadow-sm" href="<?= e($waterFeatures['cta_link'] ?? 'https://wa.me/'.$whatsapp) ?>" style="background: #116da6; border: none;" target="_blank" rel="noopener">
<i class="fa-brands fa-whatsapp me-2"></i> <?= e($waterFeatures['cta_text'] ?? '') ?>
          </a>
</div>
<div class="col-lg-6">
<div class="text-img-box">
<img alt="شلال جداري" src="<?= e($waterFeatures['image'] ?? 'css/4.jpg') ?>"/>
</div>
</div>
</div>
</div>
</section>

<!-- ============ BOTANICAL ============ -->
<section class="section-padding bg-white" id="botanical-varieties">
<div class="container">
<div class="text-center mb-5">
<div class="section-badge badge-jasmine"><i class="fa-solid fa-seedling"></i> واحة نباتاتنا</div>
<h2 class="section-title">أشجار الزينة والنخيل والزهور الفواحة المتوفرة بمشتلنا</h2>
<p class="section-subtitle">
          ننتج ونستورد في مشتل الفيروز مئات الأصناف من النباتات والأشجار التي أثبتت نجاحها وتأقلمها العالي مع الأجواء المحلية، لنمنح حديقتك تنوعاً بيئياً مبهراً.
        </p>
</div>
<div class="row g-4">
<?php if (!empty($botanical)): ?>
  <?php foreach ($botanical as $b): ?>
  <div class="col-lg-4 col-md-6">
  <div class="<?= e($b['card_style'] ?? 'hover-jasmine-shift') ?> p-4 h-100">
  <div class="d-flex align-items-center gap-3 mb-3">
  <div class="<?= e($b['badge_class'] ?? 'bg-warning text-dark') ?> p-3 rounded-circle" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;"><i class="fa-solid <?= e($b['icon'] ?? 'fa-leaf') ?>"></i></div>
  <h4 class="h5 fw-bold text-dark mb-0"><?= e($b['title']) ?></h4>
  </div>
  <p class="text-muted mb-0"><?= e($b['description']) ?></p>
  </div>
  </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-lg-4 col-md-6">
  <div class="hover-jasmine-shift p-4 h-100">
  <div class="d-flex align-items-center gap-3 mb-3">
  <div class="bg-warning text-dark p-3 rounded-circle" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-certificate"></i></div>
  <h4 class="h5 fw-bold text-dark mb-0">زهور الفل البلدي والعراقي</h4>
  </div>
  <p class="text-muted mb-0">شجيرات الفل البيضاء ذات العبير الأخّاذ في المساء، زهور ناصعة البياض تدوم فترات طويلة وتناسب الأحواض القريبة من مجالس الجلوس.</p>
  </div>
  </div>
<?php endif; ?>
</div>
</div>
</section>

<!-- ============ PERGOLAS ============ -->
<section class="bg-section-parallax" id="pergolas" style="background-image: url('<?= e($pergolasData['background_image'] ?? 'css/5.jpg') ?>');">
<div class="bg-overlay-rose"></div>
<div class="container">
<div class="row align-items-center gy-5">
<div class="col-lg-7">
<div class="section-badge badge-pink mb-3"><i class="fa-solid fa-chair"></i> <?= e($pergolasData['badge'] ?? '') ?></div>
<h2 class="display-6 fw-black mb-4"><?= e($pergolasData['title'] ?? '') ?></h2>
<p class="text-light fs-5 mb-4" style="line-height: 2;"><?= e($pergolasData['description'] ?? '') ?></p>
<div class="row g-3">
<div class="col-sm-6"><div class="p-3 rounded-3" style="background: rgba(0, 0, 0, 0.25); backdrop-filter: blur(8px); border-right: 4px solid #e0496b;">
<h5 class="fw-bold text-white mb-1"><?= e($pergolasData['feature_1_title'] ?? '') ?></h5>
<small class="text-light"><?= e($pergolasData['feature_1_text'] ?? '') ?></small>
</div></div>
<div class="col-sm-6"><div class="p-3 rounded-3" style="background: rgba(0, 0, 0, 0.25); backdrop-filter: blur(8px); border-right: 4px solid #4fa9d6;">
<h5 class="fw-bold text-white mb-1"><?= e($pergolasData['feature_2_title'] ?? '') ?></h5>
<small class="text-light"><?= e($pergolasData['feature_2_text'] ?? '') ?></small>
</div></div>
</div>
</div>
<div class="col-lg-5 text-center">
<div class="p-4 rounded-4" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); border: 2px solid rgba(255,255,255,0.3);">
<i class="fa-solid fa-couch fs-1 text-warning mb-3"></i>
<h4 class="fw-bold text-white mb-2"><?= e($pergolasData['stat_title'] ?? '') ?></h4>
<p class="text-light small mb-4"><?= e($pergolasData['stat_text'] ?? '') ?></p>
<a class="btn btn-light text-danger fw-bold px-4 py-2 rounded-pill" href="<?= e($pergolasData['cta_link'] ?? 'https://wa.me/'.$whatsapp) ?>" target="_blank" rel="noopener">
<i class="fa-brands fa-whatsapp me-2"></i> <?= e($pergolasData['cta_text'] ?? '') ?>
            </a>
</div>
</div>
</div>
</div>
</section>

<!-- ============ FRAGRANT HAVEN ============ -->
<section class="section-padding bg-light" id="fragrant-haven">
<div class="container">
<div class="row align-items-center gy-5">
<div class="col-lg-6 order-lg-2">
<div class="section-badge badge-jasmine"><i class="fa-solid fa-wind"></i> <?= e($fragrantData['badge'] ?? '') ?></div>
<h2 class="section-title"><?= e($fragrantData['title'] ?? '') ?></h2>
<p class="text-muted fs-5 mb-4" style="line-height: 2;"><?= e($fragrantData['paragraph_1'] ?? '') ?></p>
<p class="text-muted mb-4" style="line-height: 1.9;"><?= e($fragrantData['paragraph_2'] ?? '') ?></p>
<div class="p-3 rounded-3 bg-white border mb-4">
<h5 class="fw-bold text-success mb-2"><i class="fa-solid fa-mug-hot me-2"></i> <?= e($fragrantData['box_title'] ?? '') ?></h5>
<p class="text-muted small mb-0"><?= e($fragrantData['box_text'] ?? '') ?></p>
</div>
<a class="btn btn-success fw-bold px-4 py-3 rounded-pill shadow-sm" href="<?= e($fragrantData['cta_link'] ?? 'tel:'.$phone) ?>">
<i class="fa-solid fa-phone me-2"></i> <?= e($fragrantData['cta_text'] ?? '') ?>
          </a>
</div>
<div class="col-lg-6 order-lg-1">
<div class="text-img-box">
<img alt="زهور الفل والياسمين" src="<?= e($fragrantData['image'] ?? 'css/6.jpg') ?>"/>
</div>
</div>
</div>
</div>
</section>

<!-- ============ MAINTENANCE ============ -->
<section class="section-padding bg-white" id="maintenance-plans">
<div class="container">
<div class="text-center mb-5">
<div class="section-badge badge-green"><i class="fa-solid fa-hand-holding-heart"></i> رعاية مستمرة</div>
<h2 class="section-title">برامج العناية والصيانة الدورية للحدائق المنزلية</h2>
<p class="section-subtitle">
          الحديقة كائن حي يحتاج للمتابعة المنتظمة ليبقى في أوج جماله. نوفر برامج صيانة مرنة وشاملة تغطي كافة احتياجات حديقتك على أيدي عمالة زراعية مدربة.
        </p>
</div>
<div class="row g-4">
<?php if (!empty($maintenance)): ?>
  <?php foreach ($maintenance as $mp): 
    $mp_grad_start = $mp['gradient_start'] ?? '#147a4b';
    $mp_grad_end = $mp['gradient_end'] ?? '#1fa861';
  ?>
  <div class="col-lg-4 col-md-6">
  <div class="<?= e($mp['card_style'] ?? 'hover-mint-shift') ?> p-4 h-100 text-center">
  <div class="step-badge-number mx-auto mb-3" style="background: linear-gradient(135deg, <?= e($mp_grad_start) ?>, <?= e($mp_grad_end) ?>);"><i class="fa-solid <?= e($mp['icon'] ?? 'fa-calendar-check') ?>"></i></div>
  <h4 class="h5 fw-bold text-dark mb-3"><?= e($mp['title']) ?></h4>
  <p class="text-muted mb-4"><?= e($mp['description']) ?></p>
  <a class="btn <?= e($mp['btn_class'] ?? 'btn-outline-success') ?> fw-bold px-4 py-2 rounded-pill w-100" href="<?= !empty($mp['cta_link']) ? e($mp['cta_link']) : 'https://wa.me/'.e($whatsapp) ?>" rel="noopener noreferrer" target="_blank">
    <?= !empty($mp['cta_text']) ? e($mp['cta_text']) : 'طلب تفاصيل البرنامج' ?>
  </a>
  </div>
  </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-lg-4 col-md-6">
  <div class="hover-mint-shift p-4 h-100 text-center">
  <div class="step-badge-number mx-auto mb-3"><i class="fa-solid fa-calendar-check"></i></div>
  <h4 class="h5 fw-bold text-dark mb-3">برنامج العناية الأسبوعي</h4>
  <p class="text-muted mb-4">يشمل قص وتسوية الثيل الطبيعي، إزالة الأوراق المتساقطة، تنظيف ممرات الحديقة، وإزالة الأعشاب الضارة من أحواض الزهور لتبقى الحديقة مرتبة دائماً.</p>
  <a class="btn btn-outline-success fw-bold px-4 py-2 rounded-pill w-100" href="https://wa.me/<?= e($whatsapp) ?>?text=أود%20الاستفسار%20عن%20برنامج%20الصيانة%20الأسبوعي" rel="noopener noreferrer" target="_blank">طلب تفاصيل البرنامج</a>
  </div>
  </div>
<?php endif; ?>
</div>
</div>
</section>

<!-- ============ NIGHT LIGHTING ============ -->
<section class="bg-section-parallax" id="night-lighting" style="background-image: url('<?= e($nightLighting['background_image'] ?? 'css/7.jpg') ?>');">
<div class="bg-overlay-dark"></div>
<div class="container">
<div class="row align-items-center gy-5">
<div class="col-lg-7">
<div class="section-badge badge-jasmine mb-3"><i class="fa-solid fa-lightbulb"></i> <?= e($nightLighting['badge'] ?? '') ?></div>
<h2 class="display-6 fw-black mb-4"><?= e($nightLighting['title'] ?? '') ?></h2>
<p class="text-light fs-5 mb-4" style="line-height: 2;"><?= e($nightLighting['description'] ?? '') ?></p>
<div class="row g-3">
<div class="col-sm-6"><div class="p-3 rounded-3" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(8px);">
<h5 class="fw-bold text-warning mb-1"><i class="fa-solid fa-sun text-warning me-2"></i> <?= e($nightLighting['feature_1_title'] ?? '') ?></h5>
<small class="text-light"><?= e($nightLighting['feature_1_text'] ?? '') ?></small>
</div></div>
<div class="col-sm-6"><div class="p-3 rounded-3" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(8px);">
<h5 class="fw-bold text-warning mb-1"><i class="fa-solid fa-road text-warning me-2"></i> <?= e($nightLighting['feature_2_title'] ?? '') ?></h5>
<small class="text-light"><?= e($nightLighting['feature_2_text'] ?? '') ?></small>
</div></div>
</div>
</div>
<div class="col-lg-5 text-center">
<div class="p-4 rounded-4" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); border: 2px solid rgba(255,255,255,0.25);">
<i class="fa-solid fa-moon fs-1 text-warning mb-3"></i>
<h4 class="fw-bold text-white mb-2"><?= e($nightLighting['stat_title'] ?? '') ?></h4>
<p class="text-light small mb-4"><?= e($nightLighting['stat_text'] ?? '') ?></p>
<a class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-pill" href="<?= e($nightLighting['cta_link'] ?? 'tel:'.$phone) ?>">
<i class="fa-solid fa-phone me-2"></i> <?= e($nightLighting['cta_text'] ?? '') ?>
            </a>
</div>
</div>
</div>
</div>
</section>

<!-- ============ WORKFLOW ============ -->
<section class="section-padding bg-white" id="workflow">
<div class="container">
<div class="text-center mb-5">
<div class="section-badge badge-blue"><i class="fa-solid fa-route"></i> خطوات واضحة</div>
<h2 class="section-title">مراحل العمل معنا من الفكرة حتى الحديقة المكتملة</h2>
<p class="section-subtitle">
          نعتمد منهجية تنفيذ مدروسة تضمن لك راحة البال ومتابعة كل مرحلة بدقة واحترافية عالية.
        </p>
</div>
<div class="row g-4">
<?php if (!empty($workflow)): ?>
  <?php foreach ($workflow as $wf): ?>
  <div class="col-lg col-md-6">
  <div class="hover-step <?= e($wf['card_style'] ?? 'hover-mint-shift') ?> p-4 h-100 text-center">
  <div class="step-badge-number mx-auto"><?= (int)$wf['step_number'] ?></div>
  <h5 class="fw-bold text-dark mb-2"><?= e($wf['title']) ?></h5>
  <p class="text-muted small mb-0"><?= e($wf['description']) ?></p>
  </div>
  </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-lg col-md-6">
  <div class="hover-step hover-mint-shift p-4 h-100 text-center">
  <div class="step-badge-number mx-auto">1</div>
  <h5 class="fw-bold text-dark mb-2">المعاينة ورفع المقاسات</h5>
  <p class="text-muted small mb-0">يزورك مهندس المشتل لمعاينة الموقع وتحديد أبعاد الفناء ودراسة اتجاهات الشمس والرياح والتربة.</p>
  </div>
  </div>
<?php endif; ?>
</div>
</div>
</section>

<!-- ============ STONE PATHWAYS ============ -->
<section class="bg-section-parallax" id="stone-pathways" style="background-image: url('<?= e($stonePathways['background_image'] ?? 'css/9.jpg') ?>');">
<div class="bg-overlay-dark"></div>
<div class="container text-center">
<div class="section-badge badge-rayhan mb-3"><i class="fa-solid fa-shapes"></i> <?= e($stonePathways['badge'] ?? 'هارموني الديكور') ?></div>
<h2 class="display-6 fw-black mb-4"><?= e($stonePathways['title'] ?? 'دروب تأخذك إلى أحضان الطبيعة') ?></h2>
<p class="lead max-w-75 mx-auto mb-5 text-light fs-5" style="max-width: 820px; line-height: 2;">
        <?= e($stonePathways['description'] ?? '') ?>
      </p>
<div class="d-flex flex-wrap justify-content-center gap-3">
<a class="btn-action-main btn-hero-call" href="<?= e($stonePathways['btn1_link'] ?? 'tel:'.$phone) ?>">
<i class="fa-solid fa-phone"></i> <?= e($stonePathways['btn1_text'] ?? 'تواصل مع مهندس الديكور '.$phone) ?>
        </a>
<a class="btn-action-main btn-hero-wa" href="<?= e($stonePathways['btn2_link'] ?? 'https://wa.me/'.$whatsapp) ?>" target="_blank" rel="noopener">
<i class="fa-brands fa-whatsapp"></i> <?= e($stonePathways['btn2_text'] ?? 'استفسر عن الممرات الحجرية') ?>
        </a>
</div>
</div>
</section>

<!-- ============ VERTICAL GARDENS ============ -->
<section class="section-padding bg-light" id="vertical-gardens">
<div class="container">
<div class="row align-items-center gy-5">
<div class="col-lg-6 order-lg-2">
<div class="section-badge badge-green"><i class="fa-solid fa-leaf"></i> <?= e($verticalGardens['badge'] ?? 'استغلال المساحات') ?></div>
<h2 class="section-title"><?= e($verticalGardens['title'] ?? 'الخضرة تكسو كل زاوية وجدار') ?></h2>
<p class="text-muted fs-5 mb-4" style="line-height: 2;"><?= e($verticalGardens['paragraph_1'] ?? '') ?></p>
<p class="text-muted mb-4" style="line-height: 1.9;"><?= e($verticalGardens['paragraph_2'] ?? '') ?></p>
<div class="d-flex flex-wrap gap-2 mb-4">
<?php if (!empty($verticalGardens['feature_1'])): ?><span class="badge bg-white text-dark border p-2 px-3 rounded-pill fw-bold"><i class="fa-solid fa-check text-success me-1"></i> <?= e($verticalGardens['feature_1']) ?></span><?php endif; ?>
<?php if (!empty($verticalGardens['feature_2'])): ?><span class="badge bg-white text-dark border p-2 px-3 rounded-pill fw-bold"><i class="fa-solid fa-check text-success me-1"></i> <?= e($verticalGardens['feature_2']) ?></span><?php endif; ?>
<?php if (!empty($verticalGardens['feature_3'])): ?><span class="badge bg-white text-dark border p-2 px-3 rounded-pill fw-bold"><i class="fa-solid fa-check text-success me-1"></i> <?= e($verticalGardens['feature_3']) ?></span><?php endif; ?>
</div>
<a class="btn btn-success fw-bold px-4 py-3 rounded-pill shadow-sm" href="<?= e($verticalGardens['cta_link'] ?? 'tel:'.$phone) ?>">
<i class="fa-solid fa-phone me-2"></i> <?= e($verticalGardens['cta_text'] ?? 'اطلب أحواضك الجدارية') ?>
          </a>
</div>
<div class="col-lg-6 order-lg-1">
<div class="text-img-box">
<img alt="<?= e($verticalGardens['title'] ?? 'حدائق جدارية') ?>" src="<?= e($verticalGardens['image'] ?? 'css/10.jpg') ?>"/>
</div>
</div>
</div>
</div>
</section>

<!-- ============ PORTFOLIO ============ -->
<section class="section-padding bg-white" id="portfolio">
<div class="container">
<div class="text-center mb-5">
<div class="section-badge badge-pink"><i class="fa-solid fa-camera"></i> ألبوم الإنجازات</div>
<h2 class="section-title">معرض أعمال مشتل الفيروز لتنسيق الحدائق</h2>
<p class="section-subtitle">
          تصفح تشكيلة واسعة من أحدث مشاريعنا المنفذة على أرض الواقع في مختلف مدن وأحياء المملكة، حيث تلتقي الدقة الهندسية بجمال الطبيعة الخضراء.
        </p>
</div>
<div class="row g-3" id="portfolioGrid">
<?php if (!empty($portfolio)): ?>
    <?php foreach ($portfolio as $pf): ?>
      <div class="col-6 col-md-4 col-fifth portfolio-item">
        <button class="portfolio-card" type="button" data-src="<?= e($pf['image']) ?>" aria-label="تكبير الصورة" onclick="openLightbox(this)">
          <img alt="<?= e($pf['title'] ?? 'عمل') ?>" class="portfolio-thumb" loading="lazy" decoding="async" onerror="this.style.display='none';if(!this.nextElementSibling||!this.nextElementSibling.classList.contains('missing-image')){const x=document.createElement('div');x.className='missing-image';x.textContent='الصورة غير مرفقة';this.after(x)}" src="<?= e($pf['image']) ?>"/>
        </button>
      </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="col-12 text-center py-5 text-muted">لم يتم إضافة صور للمعرض بعد.</div>
<?php endif; ?>
</div>
</div>
</section>

<!-- ============ PROJECT PHOTOS ============ -->
<section class="section-padding bg-light" id="project-photos">
<div class="container">
<div class="text-center mb-5">
<div class="section-badge badge-blue"><i class="fa-solid fa-camera"></i> لقطات من الموقع</div>
<h2 class="section-title">صور من مشاريعنا بعد التنفيذ</h2>
<p class="section-subtitle">
          صور حقيقية من مواقع العمل بعد اكتمال التنفيذ، حيث تظهر الخضرة وسحر الطبيعة في كل ركن.
        </p>
</div>
<div class="row g-3" id="momentsGrid">
<?php if (!empty($photos)): ?>
    <?php foreach ($photos as $ph): ?>
      <div class="col-6 col-md-4 col-lg-2 portfolio-item">
        <button class="portfolio-card" type="button" data-src="<?= e($ph['image']) ?>" aria-label="تكبير الصورة" onclick="openLightbox(this)">
          <img alt="<?= e($ph['title'] ?? 'صورة') ?>" class="portfolio-thumb" loading="lazy" decoding="async" onerror="this.style.display='none';if(!this.nextElementSibling||!this.nextElementSibling.classList.contains('missing-image')){const x=document.createElement('div');x.className='missing-image';x.textContent='الصورة غير مرفقة';this.after(x)}" src="<?= e($ph['image']) ?>"/>
        </button>
      </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="col-12 text-center py-5 text-muted">لم يتم إضافة صور للمشاريع بعد.</div>
<?php endif; ?>
</div>
</div>
</section>

<!-- ============ LIGHTBOX ============ -->
<div class="portfolio-lightbox" id="portfolioLightbox" onclick="closeLightbox(event)">
<button class="lightbox-nav lightbox-prev" type="button" aria-label="السابقة" onclick="stepLightbox(-1)"><i class="fa-solid fa-chevron-right"></i></button>
<button class="lightbox-nav lightbox-next" type="button" aria-label="التالية" onclick="stepLightbox(1)"><i class="fa-solid fa-chevron-left"></i></button>
<div class="lightbox-content-wrapper">
<button class="lightbox-close" onclick="closeLightboxDirect()" type="button"><i class="fa-solid fa-xmark"></i></button>
<img alt="" class="lightbox-img" id="lightboxImg" src=""/>
<div class="lightbox-title" id="lightboxCount"></div>
</div>
</div>

<!-- ============ TESTIMONIALS ============ -->
<section class="section-padding bg-white" id="testimonials">
<div class="container">
<div class="text-center mb-5">
<div class="section-badge badge-green"><i class="fa-solid fa-star"></i> آراء العملاء</div>
<h2 class="section-title">ماذا يقول عملاؤنا عنّا؟</h2>
</div>
<?php if (!empty($testimonials)): ?>
  <div class="row g-4">
    <?php foreach ($testimonials as $t): 
      $rating = max(1, min(5, (int)($t['rating'] ?? 5)));
    ?>
      <div class="col-lg-4 col-md-6">
        <div class="testimonial-card h-100">
          <div class="d-flex align-items-center gap-3 mb-3">
            <?php if (!empty($t['image'])): ?>
              <img class="rounded-circle object-fit-cover" src="<?= e($t['image']) ?>" alt="<?= e($t['client_name']) ?>" style="width:60px;height:60px;border:3px solid #fff;box-shadow:0 4px 10px rgba(0,0,0,.1);"/>
            <?php else: ?>
              <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width:60px;height:60px;background:linear-gradient(135deg,#1d7168,#33948a); font-size:1.5rem;">
                <?= e(mb_substr($t['client_name'], 0, 1)) ?>
              </div>
            <?php endif; ?>
            <div>
              <h5 class="fw-bold mb-0" style="color:#0f3d28"><?= e($t['client_name']) ?></h5>
              <?php if (!empty($t['client_title'])): ?>
                <small class="text-muted"><?= e($t['client_title']) ?></small>
              <?php endif; ?>
            </div>
          </div>
          <div class="mb-3" style="color:#d9a50a">
            <?php for ($i = 0; $i < 5; $i++): ?>
              <i class="fa-<?= $i < $rating ? 'solid' : 'regular' ?> fa-star"></i>
            <?php endfor; ?>
          </div>
          <p class="text-muted mb-0" style="line-height:1.9"><?= nl2br(e($t['content'])) ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
</div>
</section>
<!-- ============ WHY CHOOSE US ============ -->
<section class="bg-section-parallax" id="why-choose-us" style="background-image: url('css/11.jpg');">
<div class="bg-overlay-dark"></div>
<div class="container">
<div class="text-center mb-5">
<div class="section-badge badge-green"><i class="fa-solid fa-star"></i> معايير التميز</div>
<h2 class="display-6 fw-black text-white">لماذا يختار العملاء مشتل الفيروز دائماً؟</h2>
<p class="text-light fs-5 mx-auto" style="max-width: 750px;">
          لأننا نضع رضا العميل وشغف الإتقان فوق كل اعتبار، ونقدم ضمانات حقيقية على كافة الأعمال المنفذة.
        </p>
</div>
<div class="row g-4">
<?php if (!empty($whyChooseUs)): ?>
  <?php foreach ($whyChooseUs as $w): ?>
    <div class="col-lg-3 col-md-6">
    <div class="p-4 rounded-4 text-center h-100" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
    <i class="fa-solid <?= e($w['icon']) ?> fs-1 <?= e($w['icon_color']) ?> mb-3"></i>
    <h4 class="h5 fw-bold text-white mb-2"><?= e($w['title']) ?></h4>
    <p class="text-light small mb-0"><?= e($w['description']) ?></p>
    </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
</div>
</div>
</section>

<!-- ============ PLANT QUIZ ============ -->
<div class="row g-4 justify-content-center">
<?php foreach ($quizQuestions as $q):
    $opts = array_filter(explode(',', $q['options']));
?>
<div class="col-lg-4 col-md-6">
<div class="quiz-question">
<h4 class="h5 fw-bold text-success mb-2"><i class="fa-solid fa-question-circle me-2"></i> <?= e($q['question']) ?></h4>
<p class="text-muted small mb-3"><?= e($q['hint'] ?? '') ?></p>
<?php foreach ($opts as $o):
    [$key, $label] = array_pad(explode(':', $o, 2), 2, '');
?>
<button aria-pressed="false" class="quiz-chip" onclick="pickQuiz(this,'<?= e($q['group_key']) ?>','<?= e($key) ?>')" type="button"><?= e($label) ?></button>
<?php endforeach; ?>
</div>
</div>
<?php endforeach; ?>
</div>

<!-- ============ GARDEN CHECKUP ============ -->
<div class="row g-3 justify-content-center">
<?php foreach ($checkupItems as $item): ?>
<div class="col-lg-5 col-md-6"><label class="checkup-item"><input class="checkup-check" type="checkbox"/> <span><?= e($item['item_text']) ?></span></label></div>
<?php endforeach; ?>
</div>
<!-- ============ PRO TIPS ============ -->
<section class="section-padding bg-light" id="pro-tips">
<div class="container">
<div class="text-center mb-5">
<div class="section-badge badge-jasmine"><i class="fa-solid fa-lightbulb"></i> من خبرة الميدان</div>
<h2 class="section-title">تفاصيل تصنع فرقاً في التصميم</h2>
<p class="section-subtitle">اضغط على كل بطاقة لتكشف سؤالاً يساعدك في تجهيز طلب واضح.</p>
</div>
<div class="row g-4">
<?php if (!empty($proTips)): ?>
  <?php foreach ($proTips as $tip): ?>
    <div class="col-lg-4 col-md-6">
    <div aria-pressed="false" class="tip-card" onclick="toggleTip(this)" onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();toggleTip(this)}" role="button" tabindex="0">
    <div class="tip-card-inner">
    <div class="tip-face tip-front">
    <i class="fa-solid <?= e($tip['icon']) ?> fs-1 mb-3"></i>
    <h4 class="fw-bold"><?= e($tip['title']) ?></h4>
    <small>اضغط لقلب البطاقة</small>
    </div>
    <div class="tip-face tip-back">
    <p class="fw-bold mb-0"><?= e($tip['back_text']) ?></p>
    </div>
    </div>
    </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
</div>
</div>
</section>
<!-- ============ FAQ ============ -->
<section class="section-padding bg-light" id="faq">
<div class="container">
<div class="text-center mb-5">
<div class="section-badge badge-blue"><i class="fa-solid fa-circle-question"></i> الإجابات الشافية</div>
<h2 class="section-title">بنك الأسئلة الشائعة حول تنسيق وصيانة الحدائق</h2>
<p class="section-subtitle">
          إليك إجابات شاملة ومفصلة من مهندسي مشتل الفيروز على أكثر التساؤلات التي يطرحها عملاؤنا قبل البدء في تنسيق حدائقهم.
        </p>
</div>
<div class="row justify-content-center">
<div class="col-lg-10">
<div class="accordion faq-accordion" id="faqAccordion">
<?php if (!empty($faqs)): ?>
    <?php foreach ($faqs as $i => $f): ?>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button <?= $i > 0 ? 'collapsed' : '' ?>" data-bs-target="#faq-<?= (int)$f['id'] ?>" data-bs-toggle="collapse" type="button">
            <?= e($f['question']) ?>
          </button>
        </h2>
        <div class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>" data-bs-parent="#faqAccordion" id="faq-<?= (int)$f['id'] ?>">
          <div class="accordion-body">
            <?= nl2br(e($f['answer'])) ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>
</div>
</div>
</div>
</section>

<!-- ============ SEASONAL CALENDAR ============ -->
<section class="section-padding bg-white" id="seasonal-calendar">
<div class="container">
<div class="text-center mb-5">
<div class="section-badge badge-jasmine"><i class="fa-solid fa-calendar-days"></i> الدليل الزراعي</div>
<h2 class="section-title">تقويم العناية بحديقتك عبر فصول السنة</h2>
<p class="section-subtitle">إرشادات مهندسي مشتل الفيروز لكل فصل لضمان استمرار نضارة وجمال نباتاتك وأشجارك طوال أشهر العام.</p>
</div>
<div class="row g-4">
<?php if (!empty($seasonalCalendar)): ?>
  <?php foreach ($seasonalCalendar as $sc): ?>
    <div class="col-lg-3 col-md-6">
    <div class="<?= e($sc['card_style']) ?> p-4 h-100">
    <span class="badge <?= e($sc['badge_class']) ?> px-3 py-2 rounded-pill mb-3"><?= e($sc['badge_text']) ?></span>
    <h4 class="h5 fw-bold text-dark mb-2"><?= e($sc['title']) ?></h4>
    <p class="text-muted small mb-0"><?= e($sc['description']) ?></p>
    </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
</div>
</div>
</section>

<!-- ============ LOCATION ============ -->
<section class="section-padding bg-white" id="location">
<div class="container">
<div class="text-center mb-5">
<div class="section-badge badge-green"><i class="fa-solid fa-location-dot"></i> موقعنا على الخريطة</div>
<h2 class="section-title">موقعنا على الخريطة</h2>
<p class="section-subtitle">تواصل مع أبو محمد لتأكيد نقطة الوصول وموعد الزيارة. نخدم أحياء الملقا والنرجس والياسمين والقيروان والعارض والصحافة في الرياض.</p>
</div>
<div class="row justify-content-center">
<div class="col-lg-10">
<div class="map-frame-wrapper shadow">
<iframe allowfullscreen="" height="450" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7242.707796647152!2d46.60142822488057!3d24.81756823629663!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e2ee5a62aa820fb%3A0xceee08fd178451d3!2z2YXYpNiz2LPYqSDYp9io2Ygg2LnYqNiv2KfZhNix2K3ZhdmGINmE2YTZhdi02KfYqtmE!5e0!3m2!1sar!2seg!4v1795434899399!5m2!1sar!2seg" style="border:0;" title="خريطة الموقع المرسلة" width="600"></iframe>
</div>
<div class="d-flex flex-wrap gap-3 justify-content-center mt-4">
<a class="btn-action-main btn-hero-call" href="tel:<?= e($phone) ?>">
<i class="fa-solid fa-phone-volume"></i> اتصل بنا: <?= e($phone) ?>
            </a>
<a class="btn-action-main btn-hero-wa" href="https://wa.me/<?= e($whatsapp) ?>" rel="noopener noreferrer" target="_blank">
<i class="fa-brands fa-whatsapp"></i> أرسل موقعك واتساب
            </a>
</div>
</div>
</div>
</div>
</section>

<!-- ============ CONTACT ============ -->
<section class="section-padding bg-light" id="contact">
<div class="container">
<div class="row align-items-center gy-5">
<div class="col-lg-6">
<div class="section-badge badge-green"><i class="fa-solid fa-headset"></i> تواصل فوري</div>
<h2 class="section-title">احجز موعد معاينة ميدانية لحديقتك</h2>
<p class="text-muted fs-5 mb-4" style="line-height: 2;">تواصل مع أبو محمد لمناقشة مساحة حديقتك والخدمات المطلوبة وموعد المعاينة. يتم الاتفاق على نطاق العمل والتكلفة قبل التنفيذ.</p>
<div class="d-flex flex-column gap-3 mb-4">
<div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border">
<div class="bg-success text-white p-3 rounded-circle"><i class="fa-solid fa-phone-volume fs-4"></i></div>
<div>
<small class="text-muted d-block">الاتصال الهاتفي المباشر</small>
<a class="fs-5 fw-bold text-success" href="tel:<?= e($phone) ?>"><?= e($phone) ?></a>
</div>
</div>
<div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border">
<div class="bg-primary text-white p-3 rounded-circle" style="background-color: #25d366 !important;"><i class="fa-brands fa-whatsapp fs-4"></i></div>
<div>
<small class="text-muted d-block">المحادثة عبر الواتساب</small>
<a class="fs-5 fw-bold text-dark" href="https://wa.me/<?= e($whatsapp) ?>" rel="noopener noreferrer" target="_blank"><?= e($phone) ?></a>
</div>
</div>
<div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border">
<div class="bg-info text-white p-3 rounded-circle"><i class="fa-solid fa-clock fs-4"></i></div>
<div>
<small class="text-muted d-block">مواعيد التواصل والزيارة</small>
<span class="fs-6 fw-bold text-dark">تواصل لتأكيد المواعيد المتاحة</span>
</div>
</div>
</div>
<div class="districts-box bg-white rounded-3 border p-3 mt-2">
<small class="text-muted d-block mb-2 fw-bold"><i class="fa-solid fa-map-location-dot text-success me-1"></i> أحياء نصل إليها بسرعة في الرياض</small>
<div class="d-flex flex-wrap gap-2">
<?php if(!empty($districts)): foreach($districts as $d): ?>
<span class="district-chip"><?= e($d['name']) ?></span>
<?php endforeach; else: ?>
<span class="district-chip">حي الملقا</span>
<span class="district-chip">حي النرجس</span>
<span class="district-chip">حي الياسمين</span>
<?php endif; ?>
</div>
</div></div>
<div class="col-lg-6">
<div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border">
<h4 class="fw-bold text-dark mb-4 text-center">أرسل بياناتك للمعاينة عبر الواتساب</h4>
<form id="consultForm" onsubmit="handleConsultSubmit(event)">
<div class="mb-3">
<label class="form-label fw-bold text-secondary" for="custName">الاسم الكريم</label>
<input class="form-control form-control-lg fs-6" id="custName" placeholder="اكتب اسمك هنا" required="" type="text"/>
</div>
<div class="mb-3">
<label class="form-label fw-bold text-secondary" for="custPhone">رقم الجوال</label>
<input class="form-control form-control-lg fs-6" id="custPhone" placeholder="مثال: <?= e($phone) ?>" required="" type="tel"/>
</div>
<div class="mb-3">
<label class="form-label fw-bold text-secondary" for="custCity">المدينة أو الحي</label>
<input class="form-control form-control-lg fs-6" id="custCity" placeholder="اسم المدينة والحي" required="" type="text"/>
</div>
<div class="mb-3">
<label class="form-label fw-bold text-secondary" for="custService">الخدمة المطلوبة</label>
<select class="form-select form-select-lg fs-6" id="custService">
<option value="تنسيق حديقة فيلا متكاملة">تنسيق حديقة فيلا متكاملة</option>
<option value="تصميم شلال جداري أو نافورة">تصميم شلال جداري أو نافورة</option>
<option value="تركيب شبكة ري أوتوماتيكية">تركيب شبكة ري أوتوماتيكية</option>
<option value="برجولة خشبية ومظلات وجلسات">برجولة خشبية ومظلات وجلسات</option>
<option value="زراعة أشجار وزهور الفل والياسمين والريحان">زراعة أشجار وزهور الفل والياسمين والريحان</option>
<option value="صيانة دورية لحديقة قائمة">صيانة دورية لحديقة قائمة</option>
</select>
</div>
<div class="mb-4">
<label class="form-label fw-bold text-secondary" for="custNotes">ملاحظات إضافية أو المساحة التقريبية</label>
<textarea class="form-control fs-6" id="custNotes" placeholder="اكتب أي تفاصيل تود إخبار المهندس بها..." rows="3"></textarea>
</div>
<button class="btn btn-success fw-bold w-100 py-3 rounded-pill fs-5 shadow" type="submit">افتح رسالة الطلب في واتساب</button>
</form>
</div>
</div>
</div>
</div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>