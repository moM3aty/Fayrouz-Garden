<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'قسم الإلهام';
$activeMenu = 'inspiration';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();
    $current = db()->query('SELECT * FROM inspiration_content LIMIT 1')->fetch() ?: [];
    $image = post('background_image', $current['background_image'] ?? 'css/1.jpg');
    if (!empty($_FILES['bg_image_file']['name'])) {
        $up = handleImageUpload($_FILES['bg_image_file'], 'inspiration', $current['background_image'] ?? null);
        if (!empty($up['error'])) { flash('danger', $up['error']); redirect('/admin/inspiration.php'); }
        if (!empty($up['path']))  $image = $up['path'];
    }
    $data = [
        'badge' => post('badge'),
        'title' => post('title'),
        'description' => post('description'),
        'btn1_text' => post('btn1_text'), 'btn1_link' => post('btn1_link'),
        'btn2_text' => post('btn2_text'), 'btn2_link' => post('btn2_link'),
        'background_image' => $image,
    ];
    try {
        if (!empty($current['id'])) {
            $sets = implode(',', array_map(fn($k) => "`$k`=:$k", array_keys($data)));
            $data['id'] = $current['id'];
            db()->prepare("UPDATE inspiration_content SET $sets WHERE id=:id")->execute($data);
        } else {
            $cols = implode(',', array_map(fn($k) => "`$k`", array_keys($data)));
            $phs = implode(',', array_map(fn($k) => ":$k", array_keys($data)));
            db()->prepare("INSERT INTO inspiration_content ($cols) VALUES ($phs)")->execute($data);
        }
        flash('success', 'تم تحديث قسم الإلهام ✅');
    } catch (Throwable $e) { error_log('insp: ' . $e->getMessage()); flash('danger', 'خطأ في الحفظ.'); }
    redirect('/admin/inspiration.php');
}

$data = db()->query('SELECT * FROM inspiration_content LIMIT 1')->fetch() ?: [
    'badge'=>'لمسة سحرية','title'=>'','description'=>'',
    'btn1_text'=>'','btn1_link'=>'','btn2_text'=>'','btn2_link'=>'','background_image'=>'css/1.jpg',
];

include __DIR__ . '/includes/head.php';
?>
<form method="post" enctype="multipart/form-data" autocomplete="off">
<?= csrfField() ?>
<div class="h-card">
    <h3><i class="fa-solid fa-wand-magic"></i> النصوص الرئيسية</h3>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="f-label">نص البادج</label>
            <input type="text" name="badge" class="f-input" value="<?= e($data['badge']) ?>">
        </div>
        <div class="col-md-6">
            <label class="f-label">العنوان</label>
            <input type="text" name="title" class="f-input" value="<?= e($data['title']) ?>">
        </div>
        <div class="col-12">
            <label class="f-label">الوصف</label>
            <textarea name="description" class="f-textarea" rows="4"><?= e($data['description']) ?></textarea>
        </div>
    </div>
</div>

<div class="h-card">
    <h3><i class="fa-solid fa-bullhorn"></i> الأزرار</h3>
    <div class="row g-3">
        <div class="col-md-3">
            <label class="f-label">نص الزر الأول</label>
            <input type="text" name="btn1_text" class="f-input" value="<?= e($data['btn1_text']) ?>">
        </div>
        <div class="col-md-3">
            <label class="f-label">رابط الزر الأول</label>
            <input type="text" name="btn1_link" class="f-input" value="<?= e($data['btn1_link']) ?>" dir="ltr">
        </div>
        <div class="col-md-3">
            <label class="f-label">نص الزر الثاني</label>
            <input type="text" name="btn2_text" class="f-input" value="<?= e($data['btn2_text']) ?>">
        </div>
        <div class="col-md-3">
            <label class="f-label">رابط الزر الثاني</label>
            <input type="text" name="btn2_link" class="f-input" value="<?= e($data['btn2_link']) ?>" dir="ltr">
        </div>
    </div>
</div>

<div class="h-card">
    <h3><i class="fa-solid fa-image"></i> صورة الخلفية</h3>
    <?php $cid = 'insp-img-' . uniqid(); $iid = 'insp-input-' . uniqid(); $hasImg = !empty($data['background_image']); ?>
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
            <div class="uploader-drop" onclick="document.getElementById('<?= $iid ?>').click()">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <p>اسحب صورة هنا أو اضغط للاختيار</p>
                <small>JPG / PNG / WEBP</small>
            </div>
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