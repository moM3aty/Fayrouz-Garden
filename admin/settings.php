<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';

requireLogin();

$pageTitle  = 'الإعدادات العامة';
$activeMenu = 'settings';

/* ==============================
 *  حفظ التعديلات
 * ============================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();

    $fields = $_POST['settings'] ?? [];

    try {
        $stmt = db()->prepare(
            "INSERT INTO site_settings (setting_key, setting_value)
             VALUES (?, ?)
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)"
        );
        foreach ($fields as $k => $v) {
            $stmt->execute([(string)$k, (string)$v]);
        }
        flash('success', 'تم حفظ الإعدادات ✅');
    } catch (Throwable $e) {
        error_log('settings save: ' . $e->getMessage());
        flash('danger', 'حدث خطأ أثناء الحفظ.');
    }
    redirect('/admin/settings.php');
}

/* ==============================
 *  جلب الإعدادات
 * ============================== */
$settings = [];
foreach (db()->query('SELECT setting_key, setting_value FROM site_settings')->fetchAll() as $r) {
    $settings[$r['setting_key']] = $r['setting_value'];
}

/* ==============================
 *  مجموعات الحقول
 * ============================== */
$groups = [
    'بيانات الموقع' => [
        'icon'   => 'fa-globe',
        'color'  => '#1fa861',
        'fields' => [
            'site_name'        => ['اسم الموقع', 'text', 'col-md-6', 'مشتل الفيروز'],
            'site_tagline'     => ['الشعار الفرعي', 'text', 'col-md-6', 'أبو محمد لتنسيق الحدائق'],
            'site_description' => ['وصف الموقع (Meta Description)', 'textarea', 'col-12', 'وصف قصير يظهر في جوجل...'],
            'meta_keywords'    => ['الكلمات المفتاحية', 'text', 'col-md-6', 'تنسيق حدائق الرياض، مشتل، لاندسكيب'],
            'meta_author'      => ['المؤلف', 'text', 'col-md-6', 'مشتل الفيروز'],
            'footer_credit'    => ['حقوق الفوتر', 'text', 'col-12', 'تصميم وتطوير احترافي'],
        ],
    ],
    'التواصل' => [
        'icon'   => 'fa-phone',
        'color'  => '#116da6',
        'fields' => [
            'phone'      => ['رقم الهاتف (محلي)', 'text', 'col-md-4', '0505527615'],
            'phone_intl' => ['الهاتف الدولي', 'text', 'col-md-4', '966505527615'],
            'whatsapp'   => ['رقم الواتساب', 'text', 'col-md-4', '966505527615'],
            'email'      => ['البريد الإلكتروني', 'email', 'col-md-6', 'info@example.com'],
            'address'    => ['العنوان', 'text', 'col-md-6', 'الرياض، المملكة العربية السعودية'],
            'map_embed'  => ['كود خريطة جوجل (iframe)', 'textarea', 'col-12', ''],
        ],
    ],
    'السوشيال ميديا' => [
        'icon'   => 'fa-share-nodes',
        'color'  => '#a855f7',
        'fields' => [
            'facebook'  => ['فيسبوك', 'url', 'col-md-6', 'https://facebook.com/...'],
            'instagram' => ['إنستجرام', 'url', 'col-md-6', 'https://instagram.com/...'],
            'twitter'   => ['تويتر (X)', 'url', 'col-md-6', 'https://twitter.com/...'],
            'tiktok'    => ['تيك توك', 'url', 'col-md-6', 'https://tiktok.com/...'],
            'snapchat'  => ['سناب شات', 'url', 'col-md-6', 'https://snapchat.com/...'],
        ],
    ],
    'الهوية البصرية' => [
        'icon'   => 'fa-palette',
        'color'  => '#e0496b',
        'fields' => [
            'logo'            => ['شعار الموقع (مسار)', 'text', 'col-12', 'css/logo.jpeg'],
            'primary_color'   => ['اللون الأساسي', 'color', 'col-md-6', '#1d7168'],
            'secondary_color' => ['اللون الثانوي', 'color', 'col-md-6', '#123f3e'],
        ],
    ],
];

include __DIR__ . '/includes/head.php';
?>

<form method="post" autocomplete="off" id="settingsForm">
<?= csrfField() ?>

<?php foreach ($groups as $title => $grp): ?>
    <div class="h-card">
        <h3 style="border-bottom-color:<?= e($grp['color']) ?>33">
            <i class="fa-solid <?= e($grp['icon']) ?>"
               style="background:linear-gradient(135deg,<?= e($grp['color']) ?>,<?= e($grp['color']) ?>cc)"></i>
            <?= e($title) ?>
        </h3>

        <div class="row g-3">
            <?php foreach ($grp['fields'] as $key => $conf):
                [$label, $type, $col, $placeholder] = $conf;
                $val = $settings[$key] ?? '';
            ?>
                <div class="<?= e($col) ?>">
                    <label class="f-label"><?= e($label) ?></label>

                    <?php if ($type === 'textarea'): ?>
                        <textarea name="settings[<?= e($key) ?>]"
                                  class="f-textarea"
                                  rows="<?= $key === 'map_embed' ? 4 : 3 ?>"
                                  placeholder="<?= e($placeholder) ?>"
                                  <?= $key === 'map_embed' ? 'style="font-family:monospace;direction:ltr;font-size:.8rem"' : '' ?>
                        ><?= e($val) ?></textarea>

                    <?php elseif ($type === 'color'): ?>
                        <div style="display:flex;gap:10px;align-items:center">
                            <input type="color"
                                   name="settings[<?= e($key) ?>]"
                                   class="f-input"
                                   value="<?= e($val ?: $placeholder) ?>"
                                   style="height:48px;padding:4px;width:70px"
                                   onchange="this.nextElementSibling.value=this.value">
                            <input type="text"
                                   class="f-input"
                                   value="<?= e($val ?: $placeholder) ?>"
                                   dir="ltr"
                                   style="flex:1"
                                   oninput="this.previousElementSibling.value=this.value">
                        </div>

                    <?php elseif ($type === 'url'): ?>
                        <input type="url"
                               name="settings[<?= e($key) ?>]"
                               class="f-input"
                               value="<?= e($val) ?>"
                               dir="ltr"
                               placeholder="<?= e($placeholder) ?>">

                    <?php else: ?>
                        <input type="<?= e($type) ?>"
                               name="settings[<?= e($key) ?>]"
                               class="f-input"
                               value="<?= e($val) ?>"
                               placeholder="<?= e($placeholder) ?>"
                               <?= in_array($type, ['email', 'url'], true) ? 'dir="ltr"' : '' ?>>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>

<!-- شريط الحفظ -->
<div class="save-bar">
    <div class="status">
        <i class="fa-solid fa-circle-check"></i>
        <span id="saveStatus">كل التغييرات محفوظة</span>
    </div>
    <button type="submit" class="btn-save">
        <i class="fa-solid fa-floppy-disk"></i> حفظ الإعدادات
    </button>
</div>
</form>

<script>
// Dirty state
let isDirty = false;
document.querySelectorAll('#settingsForm input, #settingsForm textarea').forEach(el => {
    el.addEventListener('input', () => {
        isDirty = true;
        const s = document.getElementById('saveStatus');
        if (s) {
            s.textContent = 'هناك تغييرات غير محفوظة';
            s.parentElement.querySelector('i').style.color = 'var(--color-jasmine-glow)';
        }
    });
});
window.addEventListener('beforeunload', e => {
    if (isDirty) { e.preventDefault(); e.returnValue = ''; }
});
document.getElementById('settingsForm').addEventListener('submit', () => isDirty = false);
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>