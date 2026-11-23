<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';

requireLogin();

$pageTitle  = 'الواجهة الرئيسية';
$activeMenu = 'hero';

/* ==============================
 *  حفظ التعديلات
 * ============================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();

    $current = db()->query('SELECT * FROM hero_content LIMIT 1')->fetch() ?: [];

    // رفع الصورة (لو موجودة)
    $image = post('image', $current['image'] ?? 'css/hero.jpeg');
    if (!empty($_FILES['image_file']['name'])) {
        $up = handleImageUpload(
            $_FILES['image_file'],
            'hero',
            $current['image'] ?? null
        );
        if (!empty($up['error'])) {
            flash('danger', $up['error']);
            redirect('/admin/hero.php');
        }
        if (!empty($up['path'])) {
            $image = $up['path'];
        }
    }

    $data = [
        'title'       => post('title'),
        'lead'        => post('lead'),
        'body'        => post('body'),
        'areas'       => post('areas'),
        'image'       => $image,
        'btn1_text'   => post('btn1_text'),
        'btn1_link'   => post('btn1_link'),
        'btn1_style'  => post('btn1_style', 'btn-hero-wa'),
        'btn2_text'   => post('btn2_text'),
        'btn2_link'   => post('btn2_link'),
        'btn2_style'  => post('btn2_style', 'btn-hero-call'),
        'btn3_text'   => post('btn3_text'),
        'btn3_link'   => post('btn3_link'),
        'btn3_style'  => post('btn3_style', 'btn-hero-outline'),
    ];

    try {
        if (!empty($current['id'])) {
            $sets = implode(',', array_map(fn($k) => "`$k`=:$k", array_keys($data)));
            $data['id'] = $current['id'];
            db()->prepare("UPDATE hero_content SET $sets WHERE id=:id")
                ->execute($data);
        } else {
            $cols = implode(',', array_map(fn($k) => "`$k`", array_keys($data)));
            $phs  = implode(',', array_map(fn($k) => ":$k", array_keys($data)));
            db()->prepare("INSERT INTO hero_content ($cols) VALUES ($phs)")
                ->execute($data);
        }
        flash('success', 'تم تحديث الواجهة الرئيسية ✅');
    } catch (Throwable $e) {
        error_log('hero save: ' . $e->getMessage());
        flash('danger', 'حدث خطأ أثناء الحفظ.');
    }
    redirect('/admin/hero.php');
}

/* ==============================
 *  جلب البيانات
 * ============================== */
$hero = db()->query('SELECT * FROM hero_content LIMIT 1')->fetch() ?: [
    'title' => '', 'lead' => '', 'body' => '', 'areas' => '',
    'image' => 'css/hero.jpeg',
    'btn1_text' => '', 'btn1_link' => '', 'btn1_style' => 'btn-hero-wa',
    'btn2_text' => '', 'btn2_link' => '', 'btn2_style' => 'btn-hero-call',
    'btn3_text' => '', 'btn3_link' => '', 'btn3_style' => 'btn-hero-outline',
];

$btnStyles = [
    'btn-hero-wa'      => 'واتساب (أخضر أساسي)',
    'btn-hero-call'    => 'اتصال (أزرق)',
    'btn-hero-outline' => 'شفاف (Outline)',
];

include __DIR__ . '/includes/head.php';
?>

<form method="post" enctype="multipart/form-data" autocomplete="off" id="heroForm">
<?= csrfField() ?>

<!-- ======== النصوص الأساسية ======== -->
<div class="h-card">
    <h3><i class="fa-solid fa-heading"></i> النصوص الأساسية</h3>

    <div style="margin-bottom:16px">
        <label class="f-label">
            <i class="fa-solid fa-h1" style="color:var(--color-green-bright);margin-left:4px"></i>
            العنوان الرئيسي (H1) — محرر غني
        </label>
        <textarea name="title" class="rich-editor"><?= e($hero['title']) ?></textarea>
    </div>

    <div style="margin-bottom:16px">
        <label class="f-label">
            <i class="fa-solid fa-quote-right" style="color:var(--color-baby-blue);margin-left:4px"></i>
            العنوان الفرعي (Lead)
        </label>
        <input type="text" name="lead" class="f-input"
               value="<?= e($hero['lead']) ?>"
               placeholder="مشتل الفيروز | أبو محمد لتنسيق الحدائق في الرياض">
    </div>

    <div style="margin-bottom:16px">
        <label class="f-label">
            <i class="fa-solid fa-align-right" style="color:var(--color-green-bright);margin-left:4px"></i>
            الوصف (Body) — محرر غني
        </label>
        <textarea name="body" class="rich-editor"><?= e($hero['body']) ?></textarea>
    </div>

    <div>
        <label class="f-label">
            <i class="fa-solid fa-location-dot" style="color:var(--color-pink);margin-left:4px"></i>
            مناطق التغطية
        </label>
        <input type="text" name="areas" class="f-input"
               value="<?= e($hero['areas']) ?>"
               placeholder="الملقا والنرجس والياسمين والقيروان والعارض والصحافة">
        <small style="display:block;margin-top:6px;color:var(--text-muted);font-size:.75rem">
            <i class="fa-solid fa-lightbulb" style="color:var(--color-jasmine-glow)"></i>
            اكتب المناطق مفصولة بـ "و" أو فاصلة
        </small>
    </div>
</div>

<!-- ======== الصورة ======== -->
<div class="h-card">
    <h3><i class="fa-solid fa-image"></i> صورة الواجهة</h3>

    <?php if (!empty($hero['image'])): ?>
        <div class="img-current-preview">
            <img src="<?= e(adminImg($hero['image'])) ?>" alt="preview" onerror="this.style.opacity='.3'">
            <div class="meta">
                <strong>الصورة الحالية</strong>
                <code><?= e($hero['image']) ?></code>
            </div>
        </div>
    <?php endif; ?>

    <div class="img-upload-zone" id="heroDropZone"
         onclick="document.getElementById('heroImageInput').click()">
        <i class="fa-solid fa-cloud-arrow-up"></i>
        <p>اسحب صورة هنا أو اضغط للاختيار</p>
        <small style="color:var(--text-muted)">JPG / PNG / WEBP</small>
    </div>
    <input type="file" name="image_file" id="heroImageInput"
           accept="image/*" style="display:none"
           onchange="previewHeroImage(this)">

    <div style="margin-top:14px">
        <label class="f-label">أو عدّل المسار يدوياً</label>
        <input type="text" name="image" class="f-input"
               value="<?= e($hero['image']) ?>" dir="ltr"
               placeholder="css/hero.jpeg">
    </div>
</div>

<!-- ======== الأزرار (CTA) ======== -->
<div class="h-card">
    <h3><i class="fa-solid fa-bullhorn"></i> أزرار الدعوة (CTA)</h3>

    <?php for ($n = 1; $n <= 3; $n++): ?>
        <div style="background:linear-gradient(135deg,var(--color-soft-rayhan),#fff);
                    padding:18px;border-radius:12px;border:2px solid var(--border-soft);
                    margin-bottom:14px;transition:var(--transition-smooth)"
             onmouseover="this.style.borderColor='var(--color-green-bright)'"
             onmouseout="this.style.borderColor='var(--border-soft)'">

            <h4 style="font-size:.95rem;color:var(--color-green-dark);font-weight:900;
                       margin:0 0 14px;display:flex;align-items:center;gap:10px;
                       padding-bottom:10px;border-bottom:1px dashed var(--border-soft)">
                <span style="width:26px;height:26px;border-radius:50%;
                             background:linear-gradient(135deg,var(--color-green-mid),var(--color-green-bright));
                             color:#fff;display:grid;place-items:center;font-size:.8rem">
                    <?= $n ?>
                </span>
                الزر <?= $n ?>
            </h4>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="f-label" style="font-size:.78rem">النص الظاهر</label>
                    <input type="text"
                           name="btn<?= $n ?>_text"
                           class="f-input"
                           value="<?= e($hero['btn' . $n . '_text']) ?>"
                           placeholder="<?= $n === 1 ? 'تواصل واتساب' : ($n === 2 ? 'اتصل فوري' : 'تصفح أعمالنا') ?>">
                </div>
                <div class="col-md-5">
                    <label class="f-label" style="font-size:.78rem">الرابط</label>
                    <input type="text"
                           name="btn<?= $n ?>_link"
                           class="f-input"
                           value="<?= e($hero['btn' . $n . '_link']) ?>"
                           dir="ltr"
                           placeholder="<?= $n === 1 ? 'https://wa.me/966...' : ($n === 2 ? 'tel:05...' : '#portfolio') ?>">
                </div>
                <div class="col-md-3">
                    <label class="f-label" style="font-size:.78rem">الستايل</label>
                    <select name="btn<?= $n ?>_style" class="f-select">
                        <?php foreach ($btnStyles as $k => $lbl): ?>
                            <option value="<?= e($k) ?>"
                                <?= $hero['btn' . $n . '_style'] === $k ? 'selected' : '' ?>>
                                <?= e($lbl) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    <?php endfor; ?>
</div>

<!-- ======== شريط الحفظ ======== -->
<div class="save-bar">
    <div class="status">
        <i class="fa-solid fa-circle-check"></i>
        <span id="saveStatus">كل التغييرات محفوظة</span>
    </div>
    <button type="submit" class="btn-save">
        <i class="fa-solid fa-floppy-disk"></i> حفظ التعديلات
    </button>
</div>
</form>

<script>
function previewHeroImage(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        const existing = document.querySelector('.img-current-preview img');
        if (existing) {
            existing.src = e.target.result;
            existing.style.opacity = '1';
        } else {
            const preview = document.createElement('div');
            preview.className = 'img-current-preview';
            preview.innerHTML = '<img src="' + e.target.result + '" alt="">' +
                '<div class="meta"><strong>الصورة الجديدة</strong><code>سيتم الرفع عند الحفظ</code></div>';
            input.closest('.h-card').querySelector('.img-current-preview') ||
                input.closest('.h-card').insertBefore(preview, document.getElementById('heroDropZone'));
        }
    };
    reader.readAsDataURL(input.files[0]);
}

// Drag & Drop
const dz = document.getElementById('heroDropZone');
if (dz) {
    ['dragenter', 'dragover'].forEach(ev =>
        dz.addEventListener(ev, e => { e.preventDefault(); dz.classList.add('dragover'); })
    );
    ['dragleave', 'drop'].forEach(ev =>
        dz.addEventListener(ev, e => { e.preventDefault(); dz.classList.remove('dragover'); })
    );
    dz.addEventListener('drop', e => {
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            const input = document.getElementById('heroImageInput');
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;
            previewHeroImage(input);
        }
    });
}

// Dirty state
let isDirty = false;
document.querySelectorAll('#heroForm input, #heroForm textarea, #heroForm select').forEach(el => {
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
document.getElementById('heroForm').addEventListener('submit', () => isDirty = false);
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>