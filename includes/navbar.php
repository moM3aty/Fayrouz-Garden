<div class="side-drawer-overlay" id="drawerOverlay" onclick="closeDrawer()"></div>
<div class="side-drawer" id="sideDrawer">
<div class="side-drawer-header">
<div class="d-flex align-items-center gap-3">
<img alt="<?= e($siteName) ?>" onerror="this.style.display='none'" src="<?= e($logo) ?>" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover;"/>
<div>
<h5 class="fw-bold mb-0 text-success"><?= e($siteName) ?></h5>
</div>
</div>
<button class="drawer-close-btn" onclick="closeDrawer()" type="button"><i class="fa-solid fa-xmark"></i></button>
</div>
<ul class="drawer-nav-list">
<?php if (!empty($drawerItems)): ?>
  <?php foreach ($drawerItems as $item): ?>
    <li class="drawer-nav-item"><a href="<?= e($item['href'] ?? '') ?>" onclick="closeDrawer()"><i class="fa-solid <?= e($item['icon'] ?? '') ?>"></i> <?= e($item['label'] ?? '') ?></a></li>
  <?php endforeach; ?>
<?php else: ?>
  <li class="drawer-nav-item"><a href="#hero" onclick="closeDrawer()"><i class="fa-solid fa-house"></i> الرئيسية</a></li>
  <li class="drawer-nav-item"><a href="#about" onclick="closeDrawer()"><i class="fa-solid fa-seedling"></i> من نحن</a></li>
  <li class="drawer-nav-item"><a href="#garden-interactive" onclick="closeDrawer()"><i class="fa-solid fa-tree"></i> حديقة الزهرة والشجرة</a></li>
  <li class="drawer-nav-item"><a href="#services" onclick="closeDrawer()"><i class="fa-solid fa-wand-magic-sparkles"></i> خدماتنا</a></li>
  <li class="drawer-nav-item"><a href="#portfolio" onclick="closeDrawer()"><i class="fa-solid fa-images"></i> معرض الأعمال</a></li>
  <li class="drawer-nav-item"><a href="#contact" onclick="closeDrawer()"><i class="fa-solid fa-phone"></i> تواصل معنا</a></li>
<?php endif; ?>
</ul>
<div class="drawer-contact-box">
<a class="btn btn-success fw-bold py-2 rounded-pill" href="tel:<?= e($phone) ?>"><i class="fa-solid fa-phone-volume me-2"></i> اتصل: <?= e($phone) ?></a>
<a class="btn btn-outline-success fw-bold py-2 rounded-pill" href="https://wa.me/<?= e($whatsapp) ?>" rel="noopener noreferrer" target="_blank"><i class="fa-brands fa-whatsapp me-2"></i> واتساب مباشر</a>
</div>
</div>
<nav class="navbar navbar-expand-lg navbar-main fixed-top">
<div class="container">
<a class="navbar-brand d-flex align-items-center gap-3" href="#hero">
<img alt="شعار <?= e($siteName) ?>" onerror="this.style.display='none'" src="<?= e($logo) ?>"/>
<div>
<span class="d-block fw-bold text-success fs-5"><?= e($siteName) ?></span>
</div>
</a>
<button class="btn btn-light mobile-toggle-btn border p-2 rounded-3" onclick="openDrawer()" type="button">
<i class="fa-solid fa-bars fs-4 text-success"></i>
</button>
<div class="collapse navbar-collapse" id="mainNav">
<ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center gap-1">
<?php if (!empty($navItems)): ?>
  <?php foreach ($navItems as $item): ?>
    <li class="nav-item"><a class="nav-link" href="<?= e($item['href'] ?? '') ?>"><?= e($item['label'] ?? '') ?></a></li>
  <?php endforeach; ?>
<?php else: ?>
  <li class="nav-item"><a class="nav-link" href="#hero">الرئيسية</a></li>
  <li class="nav-item"><a class="nav-link" href="#about">من نحن</a></li>
  <li class="nav-item"><a class="nav-link" href="#services">خدماتنا</a></li>
  <li class="nav-item"><a class="nav-link" href="#portfolio">معرض الأعمال</a></li>
  <li class="nav-item"><a class="nav-link" href="#contact">اتصل بنا</a></li>
<?php endif; ?>
</ul>
<div class="d-flex align-items-center gap-2 me-lg-3">
<a class="nav-btn-call" href="tel:<?= e($phone) ?>">
<i class="fa-solid fa-phone-volume me-2"></i> <?= e($phone) ?>
          </a>
</div>
</div>
</div>
</nav>