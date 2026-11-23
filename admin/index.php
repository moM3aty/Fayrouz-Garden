<?php
// admin/index.php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
requireLogin();

$pageTitle  = 'لوحة القيادة';
$activeMenu = 'dashboard';

$stats = [
    'services'=>0,'portfolio'=>0,'testimonials'=>0,'messages'=>0,'unread'=>0,
    'faqs'=>0,'districts'=>0,'botanical'=>0,'workflow'=>0,'maintenance'=>0,'photos'=>0
];
try {
    $stats['services']     = (int)db()->query("SELECT COUNT(*) FROM services WHERE is_active=1")->fetchColumn();
    $stats['portfolio']    = (int)db()->query("SELECT COUNT(*) FROM portfolio_items WHERE is_active=1")->fetchColumn();
    $stats['testimonials'] = (int)db()->query("SELECT COUNT(*) FROM testimonials WHERE is_active=1")->fetchColumn();
    $stats['messages']     = (int)db()->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
    $stats['unread']       = (int)db()->query("SELECT COUNT(*) FROM contact_messages WHERE is_read=0")->fetchColumn();
    $stats['faqs']         = (int)db()->query("SELECT COUNT(*) FROM faqs WHERE is_active=1")->fetchColumn();
    $stats['districts']    = (int)db()->query("SELECT COUNT(*) FROM districts WHERE is_active=1")->fetchColumn();
    $stats['botanical']    = (int)db()->query("SELECT COUNT(*) FROM botanical_varieties WHERE is_active=1")->fetchColumn();
    $stats['workflow']     = (int)db()->query("SELECT COUNT(*) FROM workflow_steps WHERE is_active=1")->fetchColumn();
    $stats['maintenance']  = (int)db()->query("SELECT COUNT(*) FROM maintenance_plans WHERE is_active=1")->fetchColumn();
    $stats['photos']       = (int)db()->query("SELECT COUNT(*) FROM project_photos WHERE is_active=1")->fetchColumn();
} catch (Throwable $e) {}

$recentMessages = [];
try {
    $recentMessages = db()->query("SELECT id,name,phone,message,is_read,created_at FROM contact_messages ORDER BY id DESC LIMIT 6")->fetchAll();
} catch (Throwable $e) {}

$msgByDay = [];
try {
    $msgByDay = db()->query("
        SELECT DATE(created_at) AS d, COUNT(*) AS c
        FROM contact_messages
        WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
        GROUP BY DATE(created_at) ORDER BY d ASC
    ")->fetchAll();
} catch (Throwable $e) {}

$days = [];
$counts = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $days[] = date('d M', strtotime($date));
    $found = array_filter($msgByDay, fn($r) => $r['d'] === $date);
    $counts[] = $found ? (int)reset($found)['c'] : 0;
}

include __DIR__ . '/includes/head.php';
?>

<style>
    .welcome-hero { background: linear-gradient(135deg, var(--color-green-dark) 0%, var(--color-green-mid) 55%, var(--color-green-bright) 100%); border-radius: var(--radius-lg); padding: 32px; margin-bottom: 28px; color: #fff; display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap; position: relative; overflow: hidden; box-shadow: 0 20px 50px rgba(15,61,40,.25); }
    .welcome-hero::before { content: ''; position: absolute; top: -100px; right: -80px; width: 320px; height: 320px; background: radial-gradient(circle, rgba(255,255,255,.12), transparent 70%); border-radius: 50%; }
    .welcome-hero::after { content: ''; position: absolute; bottom: -120px; left: -60px; width: 280px; height: 280px; background: radial-gradient(circle, rgba(255,255,255,.08), transparent 70%); border-radius: 50%; }
    .welcome-hero .wh-content { position: relative; z-index: 2; }
    .welcome-hero h2 { color: #fff; margin: 0 0 6px; font-size: 1.6rem; font-weight: 900; }
    .welcome-hero p { margin: 0; opacity: .9; font-weight: 700; font-size: .95rem; }
    .wh-actions { display: flex; gap: 10px; position: relative; z-index: 2; flex-wrap: wrap; }
    .wh-btn { padding: 11px 20px; border-radius: 12px; background: rgba(255,255,255,.15); color: #fff; font-weight: 800; font-size: .88rem; display: inline-flex; align-items: center; gap: 8px; border: 1px solid rgba(255,255,255,.25); backdrop-filter: blur(10px); transition: var(--transition-smooth); font-family: 'Cairo'; cursor: pointer; text-decoration:none; }
    .wh-btn:hover { background: #fff; color: var(--color-green-dark); transform: translateY(-2px); }
    .wh-btn.primary { background: #fff; color: var(--color-green-dark); }
    .wh-btn.primary:hover { background: var(--color-jasmine); }

    .f-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 28px; }
    .f-stat-card { padding: 22px; display: flex; flex-direction: column; position: relative; background: var(--bg-white); border-radius: var(--radius-lg); border: 1px solid var(--border-soft); box-shadow: var(--shadow-fayrouz); transition: var(--transition-smooth); overflow: hidden; cursor: pointer; text-decoration: none; color: inherit; }
    .f-stat-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-hover); border-color: transparent; }
    .f-stat-card.c-green { border-bottom: 4px solid var(--color-green-mid); }
    .f-stat-card.c-blue { border-bottom: 4px solid var(--color-baby-blue); }
    .f-stat-card.c-jasmine { border-bottom: 4px solid var(--color-jasmine-glow); }
    .f-stat-card.c-pink { border-bottom: 4px solid var(--color-pink); }
    .f-stat-card.c-purple { border-bottom: 4px solid var(--color-floral-purple); }
    .stat-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; z-index: 2; position: relative; }
    .stat-icon { width: 48px; height: 48px; border-radius: 14px; display: grid; place-items: center; font-size: 1.3rem; color: #fff; }
    .c-green .stat-icon { background: linear-gradient(135deg, var(--color-green-mid), var(--color-green-bright)); }
    .c-blue .stat-icon { background: linear-gradient(135deg, var(--color-baby-blue), var(--color-sky-blue)); }
    .c-jasmine .stat-icon { background: linear-gradient(135deg, var(--color-jasmine-glow), var(--color-floral-orange)); }
    .c-pink .stat-icon { background: linear-gradient(135deg, var(--color-pink), var(--color-wardy)); }
    .c-purple .stat-icon { background: linear-gradient(135deg, var(--color-floral-purple), var(--color-rose)); }
    .stat-badge { padding: 4px 10px; border-radius: 20px; font-size: .7rem; font-weight: 900; display: inline-flex; align-items: center; gap: 4px; }
    .stat-badge.up { background: var(--color-soft-rayhan); color: var(--color-rayhan); }
    .stat-badge.alert { background: var(--color-soft-pink); color: var(--color-pink); animation: pulseBadge 2s infinite; }
    .f-stat-card h3 { font-size: 2.2rem; color: var(--color-green-dark); margin: 0 0 4px; line-height: 1; z-index: 2; position: relative; font-weight: 900; }
    .f-stat-card p { font-size: .92rem; color: var(--text-muted); font-weight: 700; margin: 0; z-index: 2; position: relative; }
    .stat-bg-icon { position: absolute; left: -15px; bottom: -15px; font-size: 7rem; opacity: .04; color: var(--color-green-dark); z-index: 1; transform: rotate(-10deg); transition: .4s; }
    .f-stat-card:hover .stat-bg-icon { transform: rotate(0) scale(1.1); opacity: .08; }

    .dash-grid { display: grid; grid-template-columns: 1.4fr 1fr; gap: 20px; }
    @media(max-width: 1100px) { .dash-grid { grid-template-columns: 1fr; } }
    .msg-item { display: flex; gap: 14px; padding: 16px 20px; border-bottom: 1px solid var(--border-soft); transition: var(--transition-smooth); text-decoration: none; color: inherit; }
    .msg-item:hover { background: var(--color-soft-rayhan); }
    .msg-item:last-child { border-bottom: none; }
    .msg-avatar { width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0; display: grid; place-items: center; font-weight: 900; color: #fff; font-family: 'Cairo'; background: linear-gradient(135deg, var(--color-green-mid), var(--color-green-bright)); }
    .msg-item.unread .msg-avatar { background: linear-gradient(135deg, var(--color-pink), var(--color-wardy)); }
    .msg-body { flex: 1; min-width: 0; }
    .msg-body strong { display: block; font-size: .92rem; color: var(--color-green-dark); font-weight: 900; margin-bottom: 3px; }
    .msg-body p { margin: 0; font-size: .82rem; color: var(--text-muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-weight: 600; }
    .msg-time { font-size: .72rem; color: var(--text-muted); opacity: .7; font-weight: 700; white-space: nowrap; }
    .msg-item.unread .msg-body strong::before { content: ''; display: inline-block; width: 8px; height: 8px; background: var(--color-pink); border-radius: 50%; margin-left: 6px; vertical-align: middle; }
    .quick-actions { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; padding: 20px; }
    .qa-item { padding: 16px; border-radius: 12px; background: var(--bg-light); border: 1px solid var(--border-soft); display: flex; align-items: center; gap: 10px; font-weight: 800; color: var(--color-green-dark); font-size: .88rem; transition: var(--transition-smooth); text-decoration: none; }
    .qa-item:hover { background: var(--color-soft-rayhan); border-color: var(--color-green-bright); transform: translateY(-2px); color: var(--color-green-dark); }
    .qa-item i { width: 34px; height: 34px; border-radius: 9px; display: grid; place-items: center; background: linear-gradient(135deg, var(--color-green-mid), var(--color-green-bright)); color: #fff; font-size: .9rem; }
</style>

<div class="welcome-hero">
    <div class="wh-content">
        <h2>أهلاً بك، <?= e($admin['full_name'] ?: $admin['username']) ?> 👋</h2>
        <p>لديك <strong style="color:var(--color-jasmine)"><?= $stats['unread'] ?></strong> رسالة جديدة بانتظارك اليوم</p>
    </div>
    <div class="wh-actions">
        <a href="/admin/messages.php" class="wh-btn primary"><i class="fa-solid fa-inbox"></i> الرسائل</a>
        <a href="<?= APP_URL ?>" target="_blank" class="wh-btn"><i class="fa-solid fa-eye"></i> عرض الموقع</a>
    </div>
</div>

<div class="f-grid">
    <a href="/admin/services.php" class="f-stat-card c-green">
        <div class="stat-header"><div class="stat-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div><span class="stat-badge up"><i class="fa-solid fa-check"></i> نشط</span></div>
        <h3><?= $stats['services'] ?></h3><p>الخدمات المفعّلة</p><i class="fa-solid fa-wand-magic-sparkles stat-bg-icon"></i>
    </a>
    <a href="/admin/portfolio.php" class="f-stat-card c-blue">
        <div class="stat-header"><div class="stat-icon"><i class="fa-solid fa-images"></i></div><span class="stat-badge up"><i class="fa-solid fa-check"></i> نشط</span></div>
        <h3><?= $stats['portfolio'] ?></h3><p>مشاريع المعرض</p><i class="fa-solid fa-images stat-bg-icon"></i>
    </a>
    <a href="/admin/botanical.php" class="f-stat-card c-jasmine">
        <div class="stat-header"><div class="stat-icon"><i class="fa-solid fa-leaf"></i></div><span class="stat-badge up"><i class="fa-solid fa-check"></i> نشط</span></div>
        <h3><?= $stats['botanical'] ?></h3><p>النباتات والزهور</p><i class="fa-solid fa-leaf stat-bg-icon"></i>
    </a>
    <a href="/admin/messages.php" class="f-stat-card c-pink">
        <div class="stat-header"><div class="stat-icon"><i class="fa-solid fa-inbox"></i></div>
            <?php if ($stats['unread'] > 0): ?><span class="stat-badge alert"><i class="fa-solid fa-bell"></i> <?= $stats['unread'] ?> جديد</span>
            <?php else: ?><span class="stat-badge up"><i class="fa-solid fa-check"></i> تم</span><?php endif; ?>
        </div>
        <h3><?= $stats['messages'] ?></h3><p>إجمالي الرسائل</p><i class="fa-solid fa-inbox stat-bg-icon"></i>
    </a>
</div>

<div class="dash-grid">
    <div class="f-panel">
        <div class="panel-head"><h2><i class="fa-solid fa-chart-line"></i> حركة الرسائل — آخر 7 أيام</h2></div>
        <div style="padding: 20px"><div id="msgChart"></div></div>
    </div>
    <div class="f-panel">
        <div class="panel-head"><h2><i class="fa-solid fa-bolt"></i> إجراءات سريعة</h2></div>
        <div class="quick-actions">
            <a href="/admin/hero.php" class="qa-item"><i class="fa-solid fa-heading"></i> تعديل الهيرو</a>
            <a href="/admin/about.php" class="qa-item"><i class="fa-solid fa-align-right"></i> من نحن</a>
            <a href="/admin/portfolio.php" class="qa-item"><i class="fa-solid fa-plus"></i> مشروع جديد</a>
            <a href="/admin/workflow.php" class="qa-item"><i class="fa-solid fa-route"></i> المراحل</a>
            <a href="/admin/maintenance.php" class="qa-item"><i class="fa-solid fa-hand-holding-heart"></i> الصيانة</a>
            <a href="/admin/photos.php" class="qa-item"><i class="fa-solid fa-camera"></i> صور المشاريع</a>
        </div>
    </div>
</div>

<div class="f-panel" style="margin-top: 24px">
    <div class="panel-head">
        <h2><i class="fa-solid fa-inbox"></i> أحدث الرسائل</h2>
        <a href="/admin/messages.php" class="btn-primary-c" style="padding:8px 16px;font-size:.82rem">الكل <i class="fa-solid fa-arrow-left"></i></a>
    </div>
    <?php if (empty($recentMessages)): ?>
        <div class="empty-state" style="border:none;padding:50px 20px"><i class="fa-solid fa-inbox"></i><h4>لا توجد رسائل بعد</h4></div>
    <?php else: ?>
        <?php foreach ($recentMessages as $m): ?>
            <a class="msg-item <?= $m['is_read'] ? '' : 'unread' ?>" href="/admin/messages.php?id=<?= (int)$m['id'] ?>">
                <div class="msg-avatar"><?= e(mb_substr($m['name'], 0, 1)) ?></div>
                <div class="msg-body"><strong><?= e($m['name']) ?></strong><p><?= e(mb_substr($m['message'], 0, 90)) ?>...</p></div>
                <span class="msg-time"><?= e(date('d M H:i', strtotime($m['created_at']))) ?></span>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const el = document.querySelector('#msgChart');
    if (!el || typeof ApexCharts === 'undefined') return;
    new ApexCharts(el, {
        chart: { type: 'area', height: 300, toolbar: { show: false }, fontFamily: 'Tajawal, sans-serif' },
        series: [{ name: 'الرسائل', data: <?= json_encode($counts) ?> }],
        colors: ['#1fa861'], stroke: { curve: 'smooth', width: 3 },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.5, opacityTo: 0.02, stops: [0, 90, 100] } },
        dataLabels: { enabled: false },
        xaxis: { categories: <?= json_encode($days) ?>, labels: { style: { colors: '#64748b', fontWeight: 700 } }, axisBorder: { show: false }, axisTicks: { show: false } },
        yaxis: { labels: { style: { colors: '#64748b', fontWeight: 700 } } },
        grid: { borderColor: '#e5efe7', strokeDashArray: 4 },
        tooltip: { theme: 'light', style: { fontFamily: 'Tajawal' }, y: { formatter: v => v + ' رسالة' } }
    }).render();
});
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>