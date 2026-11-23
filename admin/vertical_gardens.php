<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'الحدائق الجدارية';
$activeMenu = 'vertical-gardens';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();
    $current = db()->query('SELECT * FROM vertical_gardens LIMIT 1')->fetch() ?: [];
    
    $image = post('image', $current['image'] ?? 'css/10.jpg');
    if (!empty($_FILES['image_file']['name'])) {
        $up = handleImageUpload($_FILES['image_file'], 'vertical', $current['image'] ?? null);
        if (!empty($up['error'])) { flash('danger', $up['error']); redirect('/admin/vertical_gardens.php'); }
        if (!empty($up['path']))  $image = $up['path'];
    }
    
    $data = [
        'badge'       => post('badge'),
        'title'       => post('title'),
        'paragraph_1' => post('paragraph_1'),
        'paragraph_2' => post('paragraph_2'),
        'feature_1'   => post('feature_1'),
        'feature_2'   => post('feature_2'),
        'feature_3'   => post('feature_3'),
        'cta_text'    => post('cta_text'),
        'cta_link'    => post('cta_link'),
        'image'       => $image,
    ];
    try {
        if (!empty($current['id'])) {
            $sets = implode(',', array_map(fn($k) => "`$k`=:$k", array_keys($data)));
            $data['id'] = $current['id'];
            db()->prepare("UPDATE vertical_gardens SET $sets WHERE id=:id")->execute($data);
        } else {
            $cols = implode(',', array_map(fn($k) => "`$k`", array_keys($data)));
            $phs = implode(',', array_map(fn($k) => ":$k", array_keys($data)));
            db()->prepare("INSERT INTO vertical_gardens ($cols) VALUES ($phs)")->execute($data);
        }
        flash('success', 'تم تحديث قسم الحدائق الجدارية ✅');
    } catch (Throwable $e) {
        error_log('vertical_gardens: ' . $e->getMessage());
        flash('danger', 'حدث خطأ أثناء الحفظ.');
    }
    redirect('/admin/vertical_gardens.php');
}

$vg = db()->query('SELECT * FROM vertical_gardens LIMIT 1')->fetch() ?: [
    'badge'=>'استغلال المساحات','title'=>'','paragraph_1'=>'','paragraph_2'=>'',
    'feature_1'=>'','feature_2'=>'','feature_3'=>'',
    'cta_text'=>'','cta_link'=>'','image'=>'css/10.jpg',
];

include __DIR__ . '/includes/head.php';
?>
<form method="post" enctype="multipart/form-data" autocomplete="off">
<?= csrfField() ?>
<div class="h-card">
    <h3><i class="fa-solid fa-leaf"></i> قسم الحدائق الجدارية</h3>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="f-label">نص البادج</label>
            <input type="text" name="badge" class="f-input" value="<?= e($vg['badge']) ?>">
        </div>
        <div class="col-md-6">
            <label class="f-label">العنوان الرئيسي</label>
            <input type="text" name="title" class="f-input" value="<?= e($vg['title']) ?>">
        </div>
        <div class="col-12">
            <label class="f-label">الفقرة الأولى</label>
            <textarea name="paragraph_1" class="f-textarea" rows="3"><?= e($vg['paragraph_1']) ?></textarea>
        </div>
        <div class="col-12">
            <label class="f-label">الفقرة الثانية</label>
            <textarea name="paragraph_2" class="f-textarea" rows="3"><?= e($vg['paragraph_2']) ?></textarea>
        </div>
        <div class="col-md-4">
            <label class="f-label">ميزة 1</label>
            <input type="text" name="feature_1" class="f-input" value="<?= e($vg['feature_1']) ?>">
        </div>
        <div class="col-md-4">
            <label class="f-label">ميزة 2</label>
            <input type="text" name="feature_2" class="f-input" value="<?= e($vg['feature_2']) ?>">
        </div>
        <div class="col-md-4">
            <label class="f-label">ميزة 3</label>
            <input type="text" name="feature_3" class="f-input" value="<?= e($vg['feature_3']) ?>">
        </div>
        <div class="col-md-6">
            <label class="f-label">نص الزر (CTA)</label>
            <input type="text" name="cta_text" class="f-input" value="<?= e($vg['cta_text']) ?>">
        </div>
        <div class="col-md-6">
            <label class="f-label">رابط الزر (CTA)</label>
            <input type="text" name="cta_link" class="f-input" value="<?= e($vg['cta_link']) ?>" dir="ltr">
        </div>
        <div class="col-12">
            <label class="f-label">الصورة</label>
            <?php if (!empty($vg['image'])): ?>
                <div class="img-current-preview">
                    <img src="<?= e(adminImg($vg['image'])) ?>" alt="">
                    <div class="meta"><strong>الصورة الحالية</strong><code><?= e($vg['image']) ?></code></div>
                </div>
            <?php endif; ?>
            <div class="img-upload-zone" onclick="this.nextElementSibling.click()">
                <i class="fa-solid fa-cloud-arrow-up"></i><p>اسحب صورة أو اضغط للاختيار</p>
            </div>
            <input type="file" name="image_file" accept="image/*" style="display:none" onchange="previewFile(this)">
            <input type="text" name="image" class="f-input mt-2" value="<?= e($vg['image']) ?>" dir="ltr">
        </div>
    </div>
</div>
<div class="save-bar">
    <span style="font-size:.82rem;color:var(--text-muted);font-weight:700">
        <i class="fa-solid fa-circle-check" style="color:var(--color-green-bright)"></i> كل التغييرات محفوظة
    </span>
    <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> حفظ التعديلات</button>
</div>
</form>
<?php include __DIR__ . '/includes/footer.php'; ?>