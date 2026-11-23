<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();
$pageTitle = 'شبكات الري'; $activeMenu = 'smart-irrigation';
$fields = ['badge','title','description','feature_1_title','feature_1_text','feature_2_title','feature_2_text','stat_title','stat_text','cta_text','cta_link'];
$imgField = 'background_image'; $imgFolder = 'irrigation'; $defaultImg = 'css/3.jpg';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();
    $current = db()->query('SELECT * FROM smart_irrigation LIMIT 1')->fetch() ?: [];
    $image = post($imgField, $current[$imgField] ?? $defaultImg);
    if (!empty($_FILES['bg_image_file']['name'])) {
        $up = handleImageUpload($_FILES['bg_image_file'], $imgFolder, $current[$imgField] ?? null);
        if (empty($up['error']) && !empty($up['path'])) $image = $up['path'];
    }
    $data = []; foreach ($fields as $f) $data[$f] = post($f);
    $data[$imgField] = $image;
    try {
        if (!empty($current['id'])) {
            $sets = implode(',', array_map(fn($k) => "`$k`=:$k", array_keys($data)));
            $data['id'] = $current['id'];
            db()->prepare("UPDATE smart_irrigation SET $sets WHERE id=:id")->execute($data);
        } else {
            $cols = implode(',', array_map(fn($k) => "`$k`", array_keys($data)));
            $phs = implode(',', array_map(fn($k) => ":$k", array_keys($data)));
            db()->prepare("INSERT INTO smart_irrigation ($cols) VALUES ($phs)")->execute($data);
        }
        flash('success', 'تم التحديث ✅');
    } catch (Throwable $e) { flash('danger', 'خطأ.'); }
    redirect('/admin/smart_irrigation.php');
}
$data = db()->query('SELECT * FROM smart_irrigation LIMIT 1')->fetch() ?: array_fill_keys(array_merge($fields,[$imgField]), '');
include __DIR__ . '/includes/head.php';
?>
<form method="post" enctype="multipart/form-data">
<?= csrfField() ?>
<div class="h-card">
    <h3><i class="fa-solid fa-faucet-drip"></i> قسم شبكات الري</h3>
    <div class="row g-3">
        <div class="col-md-6"><label class="f-label">البادج</label><input type="text" name="badge" class="f-input" value="<?= e($data['badge']) ?>"></div>
        <div class="col-md-6"><label class="f-label">العنوان</label><input type="text" name="title" class="f-input" value="<?= e($data['title']) ?>"></div>
        <div class="col-12"><label class="f-label">الوصف</label><textarea name="description" class="f-textarea" rows="3"><?= e($data['description']) ?></textarea></div>
        <div class="col-md-6"><label class="f-label">ميزة 1 (عنوان)</label><input type="text" name="feature_1_title" class="f-input" value="<?= e($data['feature_1_title']) ?>"></div>
        <div class="col-md-6"><label class="f-label">ميزة 1 (وصف)</label><input type="text" name="feature_1_text" class="f-input" value="<?= e($data['feature_1_text']) ?>"></div>
        <div class="col-md-6"><label class="f-label">ميزة 2 (عنوان)</label><input type="text" name="feature_2_title" class="f-input" value="<?= e($data['feature_2_title']) ?>"></div>
        <div class="col-md-6"><label class="f-label">ميزة 2 (وصف)</label><input type="text" name="feature_2_text" class="f-input" value="<?= e($data['feature_2_text']) ?>"></div>
        <div class="col-md-6"><label class="f-label">الإحصائية (عنوان)</label><input type="text" name="stat_title" class="f-input" value="<?= e($data['stat_title']) ?>"></div>
        <div class="col-md-6"><label class="f-label">الإحصائية (وصف)</label><input type="text" name="stat_text" class="f-input" value="<?= e($data['stat_text']) ?>"></div>
        <div class="col-md-6"><label class="f-label">نص الزر (CTA)</label><input type="text" name="cta_text" class="f-input" value="<?= e($data['cta_text']) ?>"></div>
        <div class="col-md-6"><label class="f-label">رابط الزر</label><input type="text" name="cta_link" class="f-input" value="<?= e($data['cta_link']) ?>" dir="ltr"></div>
    </div>
</div>

<div class="h-card">
    <h3><i class="fa-solid fa-image"></i> صورة الخلفية</h3>
    <?php $cid = 'irr-img-' . uniqid(); $iid = 'irr-input-' . uniqid(); $hasImg = !empty($data['background_image']); ?>
    <div class="img-uploader <?= $hasImg ? 'has-image' : '' ?>" id="<?= $cid ?>">
        <?php if ($hasImg): ?>
            <div class="uploader-preview">
                <img src="<?= e(adminImg($data['background_image'])) ?>">
                <div class="uploader-meta"><strong>الصورة الحالية</strong><code><?= e($data['background_image']) ?></code>
                <div class="uploader-actions">
                    <button type="button" class="uploader-btn uploader-btn-change" onclick="document.getElementById('<?= $iid ?>').click()"><i class="fa-solid fa-arrows-rotate"></i> تغيير</button>
                </div></div>
            </div>
        <?php else: ?>
            <div class="uploader-drop" onclick="document.getElementById('<?= $iid ?>').click()"><i class="fa-solid fa-cloud-arrow-up"></i><p>اسحب صورة</p></div>
        <?php endif; ?>
    </div>
    <input type="file" name="bg_image_file" id="<?= $iid ?>" accept="image/*" style="display:none" onchange="handleImageUpload(this, '<?= $cid ?>')">
    <input type="hidden" name="background_image" value="<?= e($data['background_image']) ?>">
    <script>setupImageDrop('<?= $cid ?>', '<?= $iid ?>');</script>
</div>
<div class="save-bar"><span class="status"><i class="fa-solid fa-circle-check"></i> محفوظ</span><button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> حفظ</button></div>
</form>
<?php include __DIR__ . '/includes/footer.php'; ?>