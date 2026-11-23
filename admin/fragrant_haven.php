<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'الفل والياسمين';
$activeMenu = 'fragrant-haven';

$fields = ['badge','title','paragraph_1','paragraph_2','box_title','box_text','cta_text','cta_link'];
$imgField = 'image'; $imgFolder = 'fragrant'; $defaultImg = 'css/6.jpg';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();
    $current = db()->query('SELECT * FROM fragrant_haven LIMIT 1')->fetch() ?: [];
    $image = post($imgField, $current[$imgField] ?? $defaultImg);
    if (!empty($_FILES['image_file']['name'])) {
        $up = handleImageUpload($_FILES['image_file'], $imgFolder, $current[$imgField] ?? null);
        if (!empty($up['error'])) { flash('danger', $up['error']); redirect('/admin/fragrant_haven.php'); }
        if (!empty($up['path']))  $image = $up['path'];
    }
    $data = []; foreach ($fields as $f) $data[$f] = post($f);
    $data[$imgField] = $image;
    try {
        if (!empty($current['id'])) {
            $sets = implode(',', array_map(fn($k) => "`$k`=:$k", array_keys($data)));
            $data['id'] = $current['id'];
            db()->prepare("UPDATE fragrant_haven SET $sets WHERE id=:id")->execute($data);
        } else {
            $cols = implode(',', array_map(fn($k) => "`$k`", array_keys($data)));
            $phs = implode(',', array_map(fn($k) => ":$k", array_keys($data)));
            db()->prepare("INSERT INTO fragrant_haven ($cols) VALUES ($phs)")->execute($data);
        }
        flash('success', 'تم تحديث قسم الفل والياسمين ✅');
    } catch (Throwable $e) { error_log('fragrant: ' . $e->getMessage()); flash('danger', 'حدث خطأ.'); }
    redirect('/admin/fragrant_haven.php');
}

$data = db()->query('SELECT * FROM fragrant_haven LIMIT 1')->fetch() ?: array_fill_keys(array_merge($fields, [$imgField]), '');

include __DIR__ . '/includes/head.php';
?>
<form method="post" enctype="multipart/form-data" autocomplete="off">
<?= csrfField() ?>
<div class="h-card">
    <h3><i class="fa-solid fa-fan"></i> النصوص الأساسية</h3>
    <div class="row g-3">
        <div class="col-md-6"><label class="f-label">البادج</label><input type="text" name="badge" class="f-input" value="<?= e($data['badge']) ?>"></div>
        <div class="col-md-6"><label class="f-label">العنوان الرئيسي</label><input type="text" name="title" class="f-input" value="<?= e($data['title']) ?>"></div>
        <div class="col-12"><label class="f-label">الفقرة الأولى</label><textarea name="paragraph_1" class="f-textarea" rows="3"><?= e($data['paragraph_1']) ?></textarea></div>
        <div class="col-12"><label class="f-label">الفقرة الثانية</label><textarea name="paragraph_2" class="f-textarea" rows="3"><?= e($data['paragraph_2']) ?></textarea></div>
    </div>
</div>

<div class="h-card">
    <h3><i class="fa-solid fa-mug-hot"></i> صندوق ركن القهوة</h3>
    <div class="row g-3">
        <div class="col-md-6"><label class="f-label">عنوان الصندوق</label><input type="text" name="box_title" class="f-input" value="<?= e($data['box_title']) ?>"></div>
        <div class="col-md-6"><label class="f-label">وصف الصندوق</label><input type="text" name="box_text" class="f-input" value="<?= e($data['box_text']) ?>"></div>
        <div class="col-md-6"><label class="f-label">نص الزر (CTA)</label><input type="text" name="cta_text" class="f-input" value="<?= e($data['cta_text']) ?>"></div>
        <div class="col-md-6"><label class="f-label">رابط الزر</label><input type="text" name="cta_link" class="f-input" value="<?= e($data['cta_link']) ?>" dir="ltr"></div>
    </div>
</div>

<div class="h-card">
    <h3><i class="fa-solid fa-image"></i> الصورة</h3>
    <?php $cid = 'fh-img-' . uniqid(); $iid = 'fh-input-' . uniqid(); $hasImg = !empty($data['image']); ?>
    <div class="img-uploader <?= $hasImg ? 'has-image' : '' ?>" id="<?= $cid ?>">
        <?php if ($hasImg): ?>
            <div class="uploader-preview">
                <img src="<?= e(adminImg($data['image'])) ?>" alt="">
                <div class="uploader-meta">
                    <strong>الصورة الحالية</strong>
                    <code><?= e($data['image']) ?></code>
                    <div class="uploader-actions">
                        <button type="button" class="uploader-btn uploader-btn-change" onclick="document.getElementById('<?= $iid ?>').click()"><i class="fa-solid fa-arrows-rotate"></i> تغيير</button>
                        <button type="button" class="uploader-btn uploader-btn-remove" onclick="removeImage('<?= $iid ?>', '<?= $cid ?>', 'image')"><i class="fa-solid fa-trash"></i> حذف</button>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="uploader-drop" onclick="document.getElementById('<?= $iid ?>').click()"><i class="fa-solid fa-cloud-arrow-up"></i><p>اسحب صورة هنا أو اضغط للاختيار</p><small>JPG / PNG / WEBP</small></div>
        <?php endif; ?>
    </div>
    <input type="file" name="image_file" id="<?= $iid ?>" accept="image/*" style="display:none" onchange="handleImageUpload(this, '<?= $cid ?>')">
    <input type="hidden" name="image" value="<?= e($data['image']) ?>">
    <script>setupImageDrop('<?= $cid ?>', '<?= $iid ?>');</script>
</div>

<div class="save-bar">
    <span class="status"><i class="fa-solid fa-circle-check"></i> كل التغييرات محفوظة</span>
    <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> حفظ التعديلات</button>
</div>
</form>
<?php include __DIR__ . '/includes/footer.php'; ?>