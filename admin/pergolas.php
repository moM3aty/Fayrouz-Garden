<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'المظلات والبرجولات';
$activeMenu = 'pergolas';

$fields = ['badge','title','description','feature_1_title','feature_1_text','feature_2_title','feature_2_text','stat_title','stat_text','cta_text','cta_link'];
$imgField = 'background_image'; $imgFolder = 'pergolas'; $defaultImg = 'css/5.jpg';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();
    $current = db()->query('SELECT * FROM pergolas_section LIMIT 1')->fetch() ?: [];
    $image = post($imgField, $current[$imgField] ?? $defaultImg);
    if (!empty($_FILES['bg_image_file']['name'])) {
        $up = handleImageUpload($_FILES['bg_image_file'], $imgFolder, $current[$imgField] ?? null);
        if (!empty($up['error'])) { flash('danger', $up['error']); redirect('/admin/pergolas.php'); }
        if (!empty($up['path']))  $image = $up['path'];
    }
    $data = []; foreach ($fields as $f) $data[$f] = post($f);
    $data[$imgField] = $image;
    try {
        if (!empty($current['id'])) {
            $sets = implode(',', array_map(fn($k) => "`$k`=:$k", array_keys($data)));
            $data['id'] = $current['id'];
            db()->prepare("UPDATE pergolas_section SET $sets WHERE id=:id")->execute($data);
        } else {
            $cols = implode(',', array_map(fn($k) => "`$k`", array_keys($data)));
            $phs = implode(',', array_map(fn($k) => ":$k", array_keys($data)));
            db()->prepare("INSERT INTO pergolas_section ($cols) VALUES ($phs)")->execute($data);
        }
        flash('success', 'تم تحديث قسم المظلات والبرجولات ✅');
    } catch (Throwable $e) { error_log('pergolas: ' . $e->getMessage()); flash('danger', 'حدث خطأ.'); }
    redirect('/admin/pergolas.php');
}

$data = db()->query('SELECT * FROM pergolas_section LIMIT 1')->fetch() ?: array_fill_keys(array_merge($fields, [$imgField]), '');

include __DIR__ . '/includes/head.php';
?>
<form method="post" enctype="multipart/form-data" autocomplete="off">
<?= csrfField() ?>
<div class="h-card">
    <h3><i class="fa-solid fa-umbrella-beach"></i> النصوص الأساسية</h3>
    <div class="row g-3">
        <div class="col-md-6"><label class="f-label">البادج</label><input type="text" name="badge" class="f-input" value="<?= e($data['badge']) ?>"></div>
        <div class="col-md-6"><label class="f-label">العنوان الرئيسي</label><input type="text" name="title" class="f-input" value="<?= e($data['title']) ?>"></div>
        <div class="col-12"><label class="f-label">الوصف</label><textarea name="description" class="f-textarea" rows="3"><?= e($data['description']) ?></textarea></div>
    </div>
</div>

<div class="h-card">
    <h3><i class="fa-solid fa-star"></i> الميزتان</h3>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="f-label">ميزة 1 (العنوان)</label>
            <input type="text" name="feature_1_title" class="f-input" value="<?= e($data['feature_1_title']) ?>">
        </div>
        <div class="col-md-6">
            <label class="f-label">ميزة 1 (الوصف)</label>
            <input type="text" name="feature_1_text" class="f-input" value="<?= e($data['feature_1_text']) ?>">
        </div>
        <div class="col-md-6">
            <label class="f-label">ميزة 2 (العنوان)</label>
            <input type="text" name="feature_2_title" class="f-input" value="<?= e($data['feature_2_title']) ?>">
        </div>
        <div class="col-md-6">
            <label class="f-label">ميزة 2 (الوصف)</label>
            <input type="text" name="feature_2_text" class="f-input" value="<?= e($data['feature_2_text']) ?>">
        </div>
    </div>
</div>

<div class="h-card">
    <h3><i class="fa-solid fa-chart-simple"></i> صندوق الإحصائية</h3>
    <div class="row g-3">
        <div class="col-md-6"><label class="f-label">العنوان</label><input type="text" name="stat_title" class="f-input" value="<?= e($data['stat_title']) ?>"></div>
        <div class="col-md-6"><label class="f-label">الوصف</label><input type="text" name="stat_text" class="f-input" value="<?= e($data['stat_text']) ?>"></div>
        <div class="col-md-6"><label class="f-label">نص الزر (CTA)</label><input type="text" name="cta_text" class="f-input" value="<?= e($data['cta_text']) ?>"></div>
        <div class="col-md-6"><label class="f-label">رابط الزر</label><input type="text" name="cta_link" class="f-input" value="<?= e($data['cta_link']) ?>" dir="ltr"></div>
    </div>
</div>

<div class="h-card">
    <h3><i class="fa-solid fa-image"></i> صورة الخلفية</h3>
    <?php $cid = 'pg-img-' . uniqid(); $iid = 'pg-input-' . uniqid(); $hasImg = !empty($data['background_image']); ?>
    <div class="img-uploader <?= $hasImg ? 'has-image' : '' ?>" id="<?= $cid ?>">
        <?php if ($hasImg): ?>
            <div class="uploader-preview">
                <img src="<?= e(adminImg($data['background_image'])) ?>" alt="">
                <div class="uploader-meta">
                    <strong>الصورة الحالية</strong>
                    <code><?= e($data['background_image']) ?></code>
                    <div class="uploader-actions">
                        <button type="button" class="uploader-btn uploader-btn-change" onclick="document.getElementById('<?= $iid ?>').click()"><i class="fa-solid fa-arrows-rotate"></i> تغيير</button>
                        <button type="button" class="uploader-btn uploader-btn-remove" onclick="removeImage('<?= $iid ?>', '<?= $cid ?>', 'background_image')"><i class="fa-solid fa-trash"></i> حذف</button>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="uploader-drop" onclick="document.getElementById('<?= $iid ?>').click()"><i class="fa-solid fa-cloud-arrow-up"></i><p>اسحب صورة هنا أو اضغط للاختيار</p><small>JPG / PNG / WEBP</small></div>
        <?php endif; ?>
    </div>
    <input type="file" name="bg_image_file" id="<?= $iid ?>" accept="image/*" style="display:none" onchange="handleImageUpload(this, '<?= $cid ?>')">
    <input type="hidden" name="background_image" value="<?= e($data['background_image']) ?>">
    <script>setupImageDrop('<?= $cid ?>', '<?= $iid ?>');</script>
</div>

<div class="save-bar">
    <span class="status"><i class="fa-solid fa-circle-check"></i> كل التغييرات محفوظة</span>
    <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> حفظ التعديلات</button>
</div>
</form>
<?php include __DIR__ . '/includes/footer.php'; ?>