<?php
// admin/includes/sidebar.php
$activeMenu = $activeMenu ?? '';

// عدد الرسائل غير المقروءة
$unreadCount = 0;
try { $unreadCount = (int)db()->query("SELECT COUNT(*) FROM contact_messages WHERE is_read=0")->fetchColumn(); } catch (Throwable $e) {}

$navItems = [
    ['group' => 'الرئيسية', 'items' => [
        ['id'=>'dashboard','label'=>'لوحة القيادة','icon'=>'fa-chart-pie','href'=>'/admin/index.php'],
        ['id'=>'messages','label'=>'صندوق الوارد','icon'=>'fa-inbox','href'=>'/admin/messages.php','badge'=>$unreadCount],
    ]],
    ['group' => 'إدارة المحتوى', 'items' => [
        ['id'=>'hero','label'=>'الواجهة الرئيسية','icon'=>'fa-heading','href'=>'/admin/hero.php'],
        ['id'=>'about','label'=>'من نحن','icon'=>'fa-align-right','href'=>'/admin/about.php'],
        ['id'=>'services','label'=>'خدمات المشتل','icon'=>'fa-wand-magic-sparkles','href'=>'/admin/services.php'],
        ['id'=>'botanical','label'=>'النباتات والزهور','icon'=>'fa-leaf','href'=>'/admin/botanical.php'],
        ['id'=>'workflow','label'=>'مراحل التنفيذ','icon'=>'fa-route','href'=>'/admin/workflow.php'],
        ['id'=>'maintenance','label'=>'باقات الصيانة','icon'=>'fa-hand-holding-heart','href'=>'/admin/maintenance.php'],
        ['id'=>'why-choose-us','label'=>'لماذا يختارنا العملاء','icon'=>'fa-star','href'=>'/admin/why_choose_us.php'],
['id'=>'seasonal-calendar','label'=>'التقويم الزراعي','icon'=>'fa-calendar-days','href'=>'/admin/seasonal_calendar.php'],
['id'=>'pro-tips','label'=>'أسرار المهندس','icon'=>'fa-lightbulb','href'=>'/admin/pro_tips.php'],
['id'=>'stone-pathways','label'=>'الممرات الحجرية','icon'=>'fa-road','href'=>'/admin/stone_pathways.php'],
['id'=>'vertical-gardens','label'=>'الحدائق الجدارية','icon'=>'fa-leaf','href'=>'/admin/vertical_gardens.php'],
['id'=>'inspiration','label'=>'قسم الإلهام','icon'=>'fa-wand-magic','href'=>'/admin/inspiration.php'],
['id'=>'smart-irrigation','label'=>'شبكات الري','icon'=>'fa-faucet-drip','href'=>'/admin/smart_irrigation.php'],
['id'=>'water-features','label'=>'الشلالات والنوافير','icon'=>'fa-water','href'=>'/admin/water_features.php'],
['id'=>'pergolas','label'=>'المظلات والبرجولات','icon'=>'fa-umbrella-beach','href'=>'/admin/pergolas.php'],
['id'=>'fragrant-haven','label'=>'الفل والياسمين','icon'=>'fa-fan','href'=>'/admin/fragrant_haven.php'],
['id'=>'night-lighting','label'=>'الإضاءة الليلية','icon'=>'fa-lightbulb','href'=>'/admin/night_lighting.php'],
['id'=>'plant-quiz','label'=>'أسئلة الكويز','icon'=>'fa-clipboard-question','href'=>'/admin/plant_quiz.php'],
['id'=>'garden-checkup','label'=>'فحص الحديقة','icon'=>'fa-stethoscope','href'=>'/admin/garden_checkup.php'],
    ]],
    ['group' => 'المعرض والتفاعل', 'items' => [
        ['id'=>'portfolio','label'=>'معرض الأعمال','icon'=>'fa-images','href'=>'/admin/portfolio.php'],
        ['id'=>'photos','label'=>'صور المشاريع','icon'=>'fa-camera','href'=>'/admin/photos.php'],
        ['id'=>'testimonials','label'=>'آراء العملاء','icon'=>'fa-star','href'=>'/admin/testimonials.php'],
        ['id'=>'faqs','label'=>'الأسئلة الشائعة','icon'=>'fa-circle-question','href'=>'/admin/faqs.php'],
    ]],
    ['group' => 'النظام', 'items' => [
        ['id'=>'settings','label'=>'الإعدادات العامة','icon'=>'fa-sliders','href'=>'/admin/settings.php'],
        ['id'=>'nav','label'=>'القوائم العلوية','icon'=>'fa-link','href'=>'/admin/navigation.php'],
        ['id'=>'districts','label'=>'نطاق التغطية','icon'=>'fa-map-location-dot','href'=>'/admin/districts.php'],
        ['id'=>'account','label'=>'حساب الإدارة','icon'=>'fa-user-shield','href'=>'/admin/account.php'],
    ]],
];
?>
<button class="sb-collapse-btn" onclick="toggleSidebarCollapse()" title="طي / فتح القائمة">
    <i class="fa-solid fa-angles-right"></i>
</button>
<aside class="sidebar" id="sidebar">
    <div class="sb-brand">
        <?php if (file_exists(BASE_PATH . '/css/logo.jpeg')): ?>
            <img src="../css/logo.jpeg" alt="مشتل الفيروز">
        <?php else: ?>
            <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,var(--color-green-mid),var(--color-green-bright));display:grid;place-items:center;box-shadow:0 4px 14px rgba(31,168,97,.4)">
                <i class="fa-solid fa-leaf text-white"></i>
            </div>
        <?php endif; ?>
        <div>
            <h1>مشتل الفيروز</h1>
            <small>لوحة الإدارة</small>
        </div>
    </div>

    <nav class="sb-nav">
        <?php foreach ($navItems as $grp): ?>
            <div class="sb-section"><?= e($grp['group']) ?></div>
            <?php foreach ($grp['items'] as $it): ?>
              <a href="<?= e($it['href']) ?>" class="sb-link<?= $activeMenu === $it['id'] ? ' active' : '' ?>" title="<?= e($it['label']) ?>">
                    <i class="fa-solid <?= e($it['icon']) ?>"></i>
                    <span><?= e($it['label']) ?></span>
                    <?php if (!empty($it['badge'])): ?>
                        <span class="sb-badge"><?= $it['badge'] > 99 ? '99+' : (int)$it['badge'] ?></span>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </nav>

    <div class="sb-footer">
        <div class="user-card">
            <div class="user-avatar"><?= e(mb_substr($admin['full_name'] ?: $admin['username'], 0, 1)) ?></div>
            <div class="user-info">
                <strong><?= e($admin['full_name'] ?: $admin['username']) ?></strong>
                <small><?= e($admin['role'] === 'admin' ? 'مدير النظام' : 'محرر') ?></small>
            </div>
        </div>
        <a href="/admin/logout.php" class="btn-logout" onclick="return confirmLogout(event)">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> تسجيل الخروج
        </a>
    </div>
</aside>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sbOverlay').classList.toggle('show');
}
function confirmLogout(e) {
    e.preventDefault();
    Swal.fire({
        title: 'تسجيل الخروج',
        html: '<p>هل تريد تسجيل الخروج من لوحة التحكم؟</p>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'نعم، اخرج',
        cancelButtonText: 'إلغاء',
        reverseButtons: true,
        confirmButtonColor: '#e0496b'
    }).then(r => { if (r.isConfirmed) window.location = '/admin/logout.php'; });
    return false;
}
</script>