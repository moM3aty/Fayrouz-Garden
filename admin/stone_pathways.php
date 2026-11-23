<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'الممرات الحجرية';
$activeMenu = 'stone-pathways';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();
    $current = db()->query('SELECT * FROM stone_pathways LIMIT 1')->fetch() ?: [];
    $data = [
        'badge'             => post('badge'),
        'title'             => post('title'),
        'description'       => post('description'),
        'btn1_text'         => post('btn1_text'),
        'btn1_link'         => post('btn1_link'),
        'btn2_text'         => post('btn2_text'),
        'btn2_link'         => post('btn2_link'),
        'background_image'  => post('background_image', 'css/9.jpg'),
    ];
    try {
        if (!empty($current['id'])) {
            $sets = implode(',', array_map(fn($k) => "`$k`=:$k", array_keys($data)));
            $data['id'] = $current['id'];
            db()->prepare("UPDATE stone_pathways SET $sets WHERE id=:id")->execute($data);
        } else {
            $cols = implode(',', array_map(fn($k) => "`$k`", array_keys($data)));
            $phs = implode(',', array_map(fn($k) => ":$k", array_keys($data)));
            db()->prepare("INSERT INTO stone_pathways ($cols) VALUES ($phs)")->execute($data);
        }
        flash('success', 'تم تحديث قسم الممرات الحجرية ✅');
    } catch (Throwable $e) {
        error_log('stone_pathways: ' . $e->getMessage());
        flash('danger', 'حدث خطأ أثناء الحفظ.');
    }
    redirect('/admin/stone_pathways.php');
}

$stone = db()->query('SELECT * FROM stone_pathways LIMIT 1')->fetch() ?: [
    'badge'=>'هارموني الديكور','title'=>'','description'=>'',
    'btn1_text'=>'','btn1_link'=>'','btn2_text'=>'','btn2_link'=>'',
    'background_image'=>'css/9.jpg',
];

include __DIR__ . '/includes/head.php';
?>
<form method="post" autocomplete="off">
<?= csrfField() ?>
<div class="h-card">
    <h3><i class="fa-solid fa-shapes"></i> قسم الممرات الحجرية</h3>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="f-label">نص البادج</label>
            <input type="text" name="badge" class="f-input" value="<?= e($stone['badge']) ?>">
        </div>
        <div class="col-md-6">
            <label class="f-label">صورة الخلفية (مسار)</label>
            <input type="text" name="background_image" class="f-input" value="<?= e($stone['background_image']) ?>" dir="ltr">
        </div>
        <div class="col-12">
            <label class="f-label">العنوان الرئيسي</label>
            <input type="text" name="title" class="f-input" value="<?= e($stone['title']) ?>">
        </div>
        <div class="col-12">
            <label class="f-label">الوصف</label>
            <textarea name="description" class="f-textarea" rows="4"><?= e($stone['description']) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="f-label">نص الزر الأول</label>
            <input type="text" name="btn1_text" class="f-input" value="<?= e($stone['btn1_text']) ?>">
        </div>
        <div class="col-md-6">
            <label class="f-label">رابط الزر الأول</label>
            <input type="text" name="btn1_link" class="f-input" value="<?= e($stone['btn1_link']) ?>" dir="ltr">
        </div>
        <div class="col-md-6">
            <label class="f-label">نص الزر الثاني</label>
            <input type="text" name="btn2_text" class="f-input" value="<?= e($stone['btn2_text']) ?>">
        </div>
        <div class="col-md-6">
            <label class="f-label">رابط الزر الثاني</label>
            <input type="text" name="btn2_link" class="f-input" value="<?= e($stone['btn2_link']) ?>" dir="ltr">
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