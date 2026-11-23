<?php
// admin/about.php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';

requireLogin();

$pageTitle  = 'من نحن';
$activeMenu = 'about';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();

    $current = db()->query('SELECT * FROM about_content LIMIT 1')->fetch() ?: [];

    $image = post('image_path', $current['image'] ?? 'css/1.jpg');
    $up = handleImageUpload($_FILES['image_file'] ?? [], 'about', $current['image'] ?? null);
    if (!empty($up['error'])) { flash('danger', $up['error']); redirect('/admin/about.php'); }
    if (!empty($up['path']))  { $image = $up['path']; }

    $data = [
        'badge'            => post('badge'),
        'title'            => post('title'),
        'paragraph_1'      => post('paragraph_1'),
        'paragraph_2'      => post('paragraph_2'),
        'image'            => $image,
        'feature_1_title'  => post('feature_1_title'),
        'feature_1_text'   => post('feature_1_text'),
        'feature_1_icon'   => post('feature_1_icon', 'fa-shield-halved'),
        'feature_2_title'  => post('feature_2_title'),
        'feature_2_text'   => post('feature_2_text'),
        'feature_2_icon'   => post('feature_2_icon', 'fa-clock'),
        'cta_text'         => post('cta_text'),
        'cta_link'         => post('cta_link'),
    ];

    try {
        if (!empty($current['id'])) {
            $sql = "UPDATE about_content SET
                badge=:badge,title=:title,paragraph_1=:paragraph_1,paragraph_2=:paragraph_2,
                image=:image,feature_1_title=:feature_1_title,feature_1_text=:feature_1_text,
                feature_1_icon=:feature_1_icon,feature_2_title=:feature_2_title,
                feature_2_text=:feature_2_text,feature_2_icon=:feature_2_icon,
                cta_text=:cta_text,cta_link=:cta_link WHERE id=:id";
            $data['id'] = $current['id'];
        } else {
            $sql = "INSERT INTO about_content
                (badge,title,paragraph_1,paragraph_2,image,feature_1_title,feature_1_text,feature_1_icon,
                 feature_2_title,feature_2_text,feature_2_icon,cta_text,cta_link)
                VALUES (:badge,:title,:paragraph_1,:paragraph_2,:image,:feature_1_title,:feature_1_text,
                 :feature_1_icon,:feature_2_title,:feature_2_text,:feature_2_icon,:cta_text,:cta_link)";
        }
        db()->prepare($sql)->execute($data);
        flash('success', 'تم تحديث قسم "من نحن" ✅');
    } catch (Throwable $e) {
        error_log('about save: ' . $e->getMessage());
        flash('danger', 'حدث خطأ أثناء الحفظ.');
    }
    redirect('/admin/about.php');
}

$about = db()->query('SELECT * FROM about_content LIMIT 1')->fetch() ?: [
    'badge'=>'','title'=>'','paragraph_1'=>'','paragraph_2'=>'','image'=>'css/1.jpg',
    'feature_1_title'=>'','feature_1_text'=>'','feature_1_icon'=>'fa-shield-halved',
    'feature_2_title'=>'','feature_2_text'=>'','feature_2_icon'=>'fa-clock',
    'cta_text'=>'','cta_link'=>'',
];

$iconOptions = [
    'fa-shield-halved' => ['label'=>'درع (جودة وأمان)', 'color'=>'#1fa861'],
    'fa-clock'         => ['label'=>'ساعة (التزام بالوقت)', 'color'=>'#116da6'],
    'fa-star'          => ['label'=>'نجمة (تميز)', 'color'=>'#d9a50a'],
    'fa-award'         => ['label'=>'جائزة (تفوق)', 'color'=>'#e0496b'],
    'fa-thumbs-up'     => ['label'=>'إعجاب (رضا)', 'color'=>'#0d9d76'],
    'fa-bolt'          => ['label'=>'برق (سرعة)', 'color'=>'#f97316'],
    'fa-handshake'     => ['label'=>'مصافحة (ثقة)', 'color'=>'#a855f7'],
    'fa-certificate'   => ['label'=>'شهادة (اعتماد)', 'color'=>'#147a4b'],
    'fa-leaf'          => ['label'=>'ورقة (طبيعة)', 'color'=>'#65a30d'],
    'fa-heart'         => ['label'=>'قلب (شغف)', 'color'=>'#ec8093'],
    'fa-seedling'      => ['label'=>'شتلة (نمو)', 'color'=>'#3f6212'],
    'fa-tree'          => ['label'=>'شجرة (أصالة)', 'color'=>'#0f3d28'],
];

include __DIR__ . '/includes/head.php';
?>

<style>
    /* ====== About Layout ====== */
    .about-layout { display: grid; grid-template-columns: 1fr 400px; gap: 20px; align-items: start; }
    @media(max-width: 1200px) { .about-layout { grid-template-columns: 1fr; } }

    .form-card {
        background: var(--bg-white); border-radius: var(--radius-md);
        border: 1px solid var(--border-soft); padding: 24px; margin-bottom: 20px;
        box-shadow: var(--shadow-fayrouz); transition: var(--transition-smooth);
    }
    .form-card:hover { border-color: rgba(31,168,97,.3); }
    .form-card h3 {
        font-size: 1.05rem; font-weight: 900; color: var(--color-green-dark);
        margin: 0 0 18px; padding-bottom: 12px; border-bottom: 2px solid var(--color-soft-rayhan);
        display: flex; align-items: center; gap: 10px;
    }
    .form-card h3 i {
        width: 32px; height: 32px; border-radius: 9px;
        background: linear-gradient(135deg, var(--color-green-mid), var(--color-green-bright));
        color: #fff; display: grid; place-items: center; font-size: .85rem;
    }
    .form-card h3 .num {
        background: rgba(31,168,97,.1); color: var(--color-green-mid);
        padding: 2px 10px; border-radius: 20px; font-size: .7rem; font-weight: 900; margin-right: auto;
    }

    /* ====== Feature Card Editor ====== */
    .feature-block {
        background: linear-gradient(135deg, var(--color-soft-rayhan), #fff);
        border: 2px solid var(--border-soft); border-radius: 14px; padding: 18px;
        margin-bottom: 14px; transition: var(--transition-smooth);
    }
    .feature-block:hover { border-color: var(--color-green-bright); box-shadow: 0 8px 24px rgba(31,168,97,.1); }
    .feature-header {
        display: flex; align-items: center; gap: 12px; margin-bottom: 14px;
        padding-bottom: 12px; border-bottom: 1px dashed var(--border-soft);
    }
    .feature-icon-preview {
        width: 44px; height: 44px; border-radius: 12px; display: grid; place-items: center;
        color: #fff; font-size: 1.15rem; box-shadow: 0 6px 16px rgba(0,0,0,.15);
        transition: var(--transition-smooth); flex-shrink: 0;
    }
    .feature-header strong { font-size: .92rem; font-weight: 900; color: var(--color-green-dark); }
    .feature-header small { display: block; color: var(--text-muted); font-size: .72rem; font-weight: 700; }

    /* ====== Icon Selector Grid ====== */
    .icon-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(48px, 1fr)); gap: 8px;
        padding: 12px; background: var(--bg-light); border-radius: 12px; border: 1px solid var(--border-soft);
    }
    .icon-option {
        aspect-ratio: 1; border-radius: 10px; background: #fff; border: 2px solid transparent;
        display: grid; place-items: center; cursor: pointer; transition: var(--transition-smooth);
        color: var(--text-muted); font-size: 1.1rem;
    }
    .icon-option:hover { transform: scale(1.08); border-color: var(--color-green-bright); color: var(--color-green-dark); }
    .icon-option.active { background: linear-gradient(135deg, var(--color-green-mid), var(--color-green-bright)); color: #fff; border-color: transparent; box-shadow: 0 4px 12px rgba(31,168,97,.3); }

    /* ====== Image Upload ====== */
    .img-upload-zone {
        border: 2px dashed var(--border-soft); border-radius: 12px; padding: 20px;
        text-align: center; cursor: pointer; transition: var(--transition-smooth);
        background: var(--bg-light);
    }
    .img-upload-zone:hover, .img-upload-zone.dragover { border-color: var(--color-green-bright); background: var(--color-soft-rayhan); }
    .img-upload-zone i { font-size: 2rem; color: var(--color-green-bright); margin-bottom: 8px; display: block; }
    .img-upload-zone p { margin: 0; font-weight: 800; color: var(--color-green-dark); font-size: .88rem; }
    .img-upload-zone small { color: var(--text-muted); font-size: .75rem; }
    .img-current-preview {
        display: flex; gap: 14px; align-items: center; padding: 14px;
        background: var(--bg-light); border-radius: 12px; margin-bottom: 14px; border: 1px solid var(--border-soft);
    }
    .img-current-preview img { width: 80px; height: 80px; border-radius: 10px; object-fit: cover; box-shadow: 0 4px 12px rgba(0,0,0,.1); border: 2px solid #fff; }
    .img-current-preview .meta { flex: 1; min-width: 0; }
    .img-current-preview .meta strong { display: block; font-size: .82rem; color: var(--color-green-dark); font-weight: 900; margin-bottom: 3px; }
    .img-current-preview .meta code { font-size: .7rem; color: var(--text-muted); background: #fff; padding: 3px 8px; border-radius: 6px; word-break: break-all; display: inline-block; direction: ltr; }

    /* ====== Preview ====== */
    .preview-panel {
        position: sticky; top: 100px;
        background: var(--bg-white); border-radius: var(--radius-md);
        border: 1px solid var(--border-soft); overflow: hidden; box-shadow: var(--shadow-fayrouz);
    }
    .preview-head {
        padding: 14px 18px; background: linear-gradient(135deg, var(--color-green-dark), var(--color-green-mid));
        color: #fff; display: flex; justify-content: space-between; align-items: center;
    }
    .preview-head h4 { margin: 0; font-size: .92rem; font-weight: 900; color: #fff; display: flex; align-items: center; gap: 8px; }
    .preview-head span { font-size: .72rem; background: rgba(255,255,255,.2); padding: 3px 10px; border-radius: 20px; font-weight: 800; }
    .preview-body { padding: 20px; background: var(--bg-light); }
    .preview-about {
        background: #fff; border-radius: 14px; padding: 20px; box-shadow: 0 8px 24px rgba(15,61,40,.06);
    }
    .preview-badge {
        display: inline-block; background: linear-gradient(135deg, var(--color-green-mid), var(--color-green-bright));
        color: #fff; padding: 5px 14px; border-radius: 50px; font-size: .72rem; font-weight: 900;
        margin-bottom: 12px; box-shadow: 0 4px 12px rgba(31,168,97,.3);
    }
    .preview-title-about {
        font-family: 'Cairo', sans-serif; font-weight: 900; font-size: 1.1rem;
        color: var(--color-green-dark); line-height: 1.4; margin: 0 0 12px;
    }
    .preview-title-about * { color: var(--color-green-dark) !important; }
    .preview-img-about { width: 100%; border-radius: 12px; margin-bottom: 12px; aspect-ratio: 4/3; object-fit: cover; box-shadow: 0 6px 18px rgba(0,0,0,.1); }
    .preview-paras { font-size: .78rem; color: var(--text-muted); line-height: 1.8; margin-bottom: 14px; }
    .preview-paras * { color: var(--text-muted) !important; margin: 0 0 8px; }
    .preview-features { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 14px; }
    .preview-feature {
        padding: 10px; border-radius: 10px; background: var(--bg-light);
        border: 1px solid var(--border-soft);
    }
    .preview-feature i { font-size: 1rem; margin-bottom: 6px; display: block; }
    .preview-feature strong { display: block; font-size: .72rem; font-weight: 900; color: var(--color-green-dark); margin-bottom: 2px; }
    .preview-feature small { font-size: .65rem; color: var(--text-muted); font-weight: 600; line-height: 1.4; display: block; }
    .preview-cta {
        display: inline-flex; align-items: center; gap: 6px;
        background: linear-gradient(135deg, var(--color-green-mid), var(--color-green-bright));
        color: #fff; padding: 8px 18px; border-radius: 50px; font-size: .75rem; font-weight: 900;
        box-shadow: 0 4px 14px rgba(31,168,97,.3);
    }
    .preview-tip {
        padding: 12px 18px; background: var(--color-soft-rayhan); border-top: 1px solid var(--color-fol-border);
        font-size: .78rem; font-weight: 700; color: var(--color-rayhan); display: flex; align-items: center; gap: 8px;
    }

    /* ====== Save Bar ====== */
    .save-bar {
        position: sticky; bottom: 0; background: rgba(255,255,255,.95); backdrop-filter: blur(16px);
        border-top: 2px solid var(--border-soft); padding: 16px 32px; margin: 20px -32px -32px;
        display: flex; justify-content: space-between; align-items: center; gap: 12px;
        box-shadow: 0 -8px 24px rgba(15,61,40,.08); z-index: 100; flex-wrap: wrap;
    }
    .save-bar .status { font-size: .82rem; color: var(--text-muted); font-weight: 700; display: flex; align-items: center; gap: 8px; }
    .save-bar .status i { color: var(--color-green-bright); }
    .btn-save {
        background: linear-gradient(135deg, var(--color-green-mid), var(--color-green-bright));
        color: #fff; border: none; padding: 13px 32px; border-radius: 12px;
        font-family: 'Cairo'; font-weight: 900; font-size: 1rem; cursor: pointer;
        box-shadow: 0 8px 22px rgba(31,168,97,.35); transition: var(--transition-smooth);
        display: inline-flex; align-items: center; gap: 10px;
    }
    .btn-save:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(31,168,97,.45); }
</style>

<form method="post" enctype="multipart/form-data" autocomplete="off" id="aboutForm">
<?= csrfField() ?>

<div class="about-layout">
    <!-- العمود الأيسر: الفورم -->
    <div>
        <!-- البادج والعنوان -->
        <div class="form-card">
            <h3><i class="fa-solid fa-tag"></i> البادج والعنوان <span class="num">1</span></h3>

            <div style="margin-bottom: 16px">
                <label class="f-label">نص البادج</label>
                <input type="text" name="badge" id="badgeInput" class="f-input"
                       value="<?= e($about['badge']) ?>"
                       placeholder="رؤيتنا وفلسفتنا"
                       oninput="updatePreview()">
                <small style="color:var(--text-muted);font-size:.75rem;margin-top:6px;display:block">
                    <i class="fa-solid fa-lightbulb" style="color:var(--color-jasmine-glow)"></i>
                    كلمة قصيرة تظهر أعلى العنوان بستايل مميز
                </small>
            </div>

            <div>
                <label class="f-label">
                    <i class="fa-solid fa-h2" style="color:var(--color-green-bright);margin-left:4px"></i>
                    العنوان الرئيسي (H2) — محرر غني
                </label>
                <textarea name="title" id="titleEditor" class="rich-editor"><?= e($about['title']) ?></textarea>
            </div>
        </div>

        <!-- الفقرات -->
        <div class="form-card">
            <h3><i class="fa-solid fa-align-right"></i> الفقرات <span class="num">2</span></h3>

            <div style="margin-bottom: 16px">
                <label class="f-label">
                    <i class="fa-solid fa-paragraph" style="color:var(--color-baby-blue);margin-left:4px"></i>
                    الفقرة الأولى — محرر غني
                </label>
                <textarea name="paragraph_1" id="para1Editor" class="rich-editor"><?= e($about['paragraph_1']) ?></textarea>
                <small style="color:var(--text-muted);font-size:.75rem;margin-top:6px;display:block">
                    يدعم HTML كامل: <code>&lt;strong&gt;</code>, <code>&lt;em&gt;</code>, القوائم، الروابط...
                </small>
            </div>

            <div>
                <label class="f-label">
                    <i class="fa-solid fa-paragraph" style="color:var(--color-baby-blue);margin-left:4px"></i>
                    الفقرة الثانية — محرر غني
                </label>
                <textarea name="paragraph_2" id="para2Editor" class="rich-editor"><?= e($about['paragraph_2']) ?></textarea>
            </div>
        </div>

        <!-- الصورة -->
        <div class="form-card">
            <h3><i class="fa-solid fa-image"></i> الصورة <span class="num">3</span></h3>

            <?php if (!empty($about['image'])): ?>
                <div class="img-current-preview">
                    <img src="<?= e(adminImg($about['image'])) ?>" alt="preview" onerror="this.style.opacity='.3'">
                    <div class="meta">
                        <strong>الصورة الحالية</strong>
                        <code><?= e($about['image']) ?></code>
                    </div>
                </div>
            <?php endif; ?>

            <div class="img-upload-zone" id="dropZone" onclick="document.getElementById('imageInput').click()">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <p>اسحب صورة هنا أو اضغط للاختيار</p>
                <small>JPG / PNG / WEBP — حتى <?= MAX_UPLOAD_MB ?>MB</small>
            </div>
            <input type="file" name="image_file" id="imageInput" accept="image/jpeg,image/png,image/webp,image/gif"
                   style="display:none" onchange="previewImage(this)">

            <div style="margin-top: 14px">
                <label class="f-label">أو عدّل المسار يدوياً</label>
                <input type="text" name="image_path" class="f-input"
                       value="<?= e($about['image']) ?>" dir="ltr"
                       oninput="updatePreviewImage(this.value)">
            </div>
        </div>

        <!-- الميزات -->
        <div class="form-card">
            <h3><i class="fa-solid fa-star"></i> الميزات (بطاقتين) <span class="num">4</span></h3>

            <?php foreach ([1, 2] as $i):
                $icon = $about['feature_'.$i.'_icon'] ?? 'fa-shield-halved';
                $color = $iconOptions[$icon]['color'] ?? '#1fa861';
            ?>
                <div class="feature-block" data-feature="<?= $i ?>">
                    <div class="feature-header">
                        <div class="feature-icon-preview"
                             data-icon-preview="<?= $i ?>"
                             style="background:linear-gradient(135deg, <?= e($color) ?>, <?= e($color) ?>cc)">
                            <i class="fa-solid <?= e($icon) ?>"></i>
                        </div>
                        <div>
                            <strong>الميزة <?= $i ?></strong>
                            <small><?= e($iconOptions[$icon]['label'] ?? 'درع') ?></small>
                        </div>
                    </div>

                    <div class="row g-3" style="margin-bottom: 14px">
                        <div class="col-md-6">
                            <label class="f-label" style="font-size:.78rem">العنوان</label>
                            <input type="text" name="feature_<?= $i ?>_title" id="feat<?= $i ?>Title"
                                   class="f-input" value="<?= e($about['feature_'.$i.'_title']) ?>"
                                   placeholder="جودة مضمونة"
                                   oninput="updatePreview()">
                        </div>
                        <div class="col-md-6">
                            <label class="f-label" style="font-size:.78rem">الوصف المختصر</label>
                            <input type="text" name="feature_<?= $i ?>_text" id="feat<?= $i ?>Text"
                                   class="f-input" value="<?= e($about['feature_'.$i.'_text']) ?>"
                                   placeholder="نلتزم بأعلى المعايير"
                                   oninput="updatePreview()">
                        </div>
                    </div>

                    <label class="f-label" style="font-size:.78rem">اختر الأيقونة</label>
                    <input type="hidden" name="feature_<?= $i ?>_icon" id="feat<?= $i ?>Icon" value="<?= e($icon) ?>">
                    <div class="icon-grid" data-icons="<?= $i ?>">
                        <?php foreach ($iconOptions as $val => $conf): ?>
                            <button type="button"
                                    class="icon-option <?= $icon === $val ? 'active' : '' ?>"
                                    data-icon="<?= e($val) ?>"
                                    data-color="<?= e($conf['color']) ?>"
                                    title="<?= e($conf['label']) ?>"
                                    onclick="selectIcon(<?= $i ?>, this)">
                                <i class="fa-solid <?= e($val) ?>"></i>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- CTA -->
        <div class="form-card">
            <h3><i class="fa-solid fa-phone"></i> زر التواصل (CTA) <span class="num">5</span></h3>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="f-label">نص الزر</label>
                    <input type="text" name="cta_text" id="ctaTextInput" class="f-input"
                           value="<?= e($about['cta_text']) ?>"
                           placeholder="تواصل معنا الآن"
                           oninput="updatePreview()">
                </div>
                <div class="col-md-6">
                    <label class="f-label">رابط الزر</label>
                    <input type="text" name="cta_link" class="f-input"
                           value="<?= e($about['cta_link']) ?>" dir="ltr"
                           placeholder="https://wa.me/96650...">
                </div>
            </div>
        </div>
    </div>

    <!-- العمود الأيمن: Preview -->
    <div>
        <div class="preview-panel">
            <div class="preview-head">
                <h4><i class="fa-solid fa-eye"></i> معاينة حية</h4>
                <span><i class="fa-solid fa-circle" style="font-size:.4rem;color:#4ade80;margin-left:4px"></i> LIVE</span>
            </div>
            <div class="preview-body">
                <div class="preview-about">
                    <div class="preview-badge" id="previewBadge"><?= e($about['badge']) ?: 'البادج' ?></div>
                    <div class="preview-title-about" id="previewTitle"><?= $about['title'] ?: 'العنوان الرئيسي' ?></div>
                    <img class="preview-img-about" id="previewImg" src="<?= e(adminImg($about['image'])) ?>" alt="" onerror="this.style.opacity='.3'">
                    <div class="preview-paras" id="previewPara1"><?= $about['paragraph_1'] ?: 'الفقرة الأولى...' ?></div>
                    <div class="preview-paras" id="previewPara2"><?= $about['paragraph_2'] ?: 'الفقرة الثانية...' ?></div>

                    <div class="preview-features">
                        <div class="preview-feature">
                            <i class="fa-solid <?= e($about['feature_1_icon']) ?>" style="color:<?= e($iconOptions[$about['feature_1_icon']]['color'] ?? '#1fa861') ?>" id="previewFeat1Icon"></i>
                            <strong id="previewFeat1Title"><?= e($about['feature_1_title']) ?: 'الميزة 1' ?></strong>
                            <small id="previewFeat1Text"><?= e($about['feature_1_text']) ?: 'الوصف' ?></small>
                        </div>
                        <div class="preview-feature">
                            <i class="fa-solid <?= e($about['feature_2_icon']) ?>" style="color:<?= e($iconOptions[$about['feature_2_icon']]['color'] ?? '#116da6') ?>" id="previewFeat2Icon"></i>
                            <strong id="previewFeat2Title"><?= e($about['feature_2_title']) ?: 'الميزة 2' ?></strong>
                            <small id="previewFeat2Text"><?= e($about['feature_2_text']) ?: 'الوصف' ?></small>
                        </div>
                    </div>

                    <div class="preview-cta">
                        <i class="fa-solid fa-phone"></i>
                        <span id="previewCta"><?= e($about['cta_text']) ?: 'تواصل معنا' ?></span>
                    </div>
                </div>
            </div>
            <div class="preview-tip">
                <i class="fa-solid fa-lightbulb"></i>
                <span>المعاينة تقريبية — تُظهر على الموقع بدقة أعلى</span>
            </div>
        </div>
    </div>
</div>

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
// ====== تحديث المعاينة ======
function updatePreview() {
    const badge = document.getElementById('badgeInput');
    if (badge) document.getElementById('previewBadge').textContent = badge.value || 'البادج';

    const f1T = document.getElementById('feat1Title');
    const f1X = document.getElementById('feat1Text');
    const f2T = document.getElementById('feat2Title');
    const f2X = document.getElementById('feat2Text');
    if (f1T) document.getElementById('previewFeat1Title').textContent = f1T.value || 'الميزة 1';
    if (f1X) document.getElementById('previewFeat1Text').textContent = f1X.value || 'الوصف';
    if (f2T) document.getElementById('previewFeat2Title').textContent = f2T.value || 'الميزة 2';
    if (f2X) document.getElementById('previewFeat2Text').textContent = f2X.value || 'الوصف';

    const cta = document.getElementById('ctaTextInput');
    if (cta) document.getElementById('previewCta').textContent = cta.value || 'تواصل معنا';

    // إشارة "غير محفوظ"
    const status = document.getElementById('saveStatus');
    if (status) {
        status.textContent = 'هناك تغييرات غير محفوظة';
        status.parentElement.querySelector('i').style.color = 'var(--color-jasmine-glow)';
    }
}

// ====== مزامنة Rich Text مع Preview ======
function syncRichText() {
    if (!window.tinymce) return;
    const t = tinymce.get('titleEditor');
    const p1 = tinymce.get('para1Editor');
    const p2 = tinymce.get('para2Editor');
    if (t) document.getElementById('previewTitle').innerHTML = t.getContent() || 'العنوان الرئيسي';
    if (p1) document.getElementById('previewPara1').innerHTML = p1.getContent() || 'الفقرة الأولى...';
    if (p2) document.getElementById('previewPara2').innerHTML = p2.getContent() || 'الفقرة الثانية...';
    updatePreview();
}

// ====== اختيار أيقونة ميزة ======
function selectIcon(num, btn) {
    const iconClass = btn.dataset.icon;
    const color = btn.dataset.color;

    // تحديث الحقل المخفي
    document.getElementById('feat' + num + 'Icon').value = iconClass;

    // تحديث الـ grid
    document.querySelectorAll('[data-icons="' + num + '"] .icon-option').forEach(el => el.classList.remove('active'));
    btn.classList.add('active');

    // تحديث preview الميزة في الفورم
    const preview = document.querySelector('[data-icon-preview="' + num + '"]');
    if (preview) {
        preview.style.background = `linear-gradient(135deg, ${color}, ${color}cc)`;
        preview.querySelector('i').className = 'fa-solid ' + iconClass;
    }

    // تحديث preview الجانبي
    const sideIcon = document.getElementById('previewFeat' + num + 'Icon');
    if (sideIcon) {
        sideIcon.className = 'fa-solid ' + iconClass;
        sideIcon.style.color = color;
    }
    updatePreview();
}

// ====== رفع صورة ======
function previewImage(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        const img = document.getElementById('previewImg');
        img.src = e.target.result;
        img.style.opacity = '1';
    };
    reader.readAsDataURL(input.files[0]);
}

function updatePreviewImage(path) {
    const img = document.getElementById('previewImg');
    img.src = path ? '../' + path : '';
}

// ====== Drag & Drop للصورة ======
const dz = document.getElementById('dropZone');
if (dz) {
    ['dragenter','dragover'].forEach(ev => dz.addEventListener(ev, e => { e.preventDefault(); dz.classList.add('dragover'); }));
    ['dragleave','drop'].forEach(ev => dz.addEventListener(ev, e => { e.preventDefault(); dz.classList.remove('dragover'); }));
    dz.addEventListener('drop', e => {
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            const input = document.getElementById('imageInput');
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;
            previewImage(input);
        }
    });
}

// ====== Init ======
document.addEventListener('DOMContentLoaded', () => {
    // راقب تغييرات TinyMCE
    setTimeout(() => {
        if (window.tinymce) {
            ['titleEditor', 'para1Editor', 'para2Editor'].forEach(id => {
                const ed = tinymce.get(id);
                if (ed) ed.on('input change keyup undo redo', syncRichText);
            });
        }
        syncRichText();
    }, 500);

    // تحذير قبل المغادرة
    let isDirty = false;
    document.querySelectorAll('#aboutForm input, #aboutForm textarea').forEach(el => {
        el.addEventListener('input', () => { isDirty = true; updatePreview(); });
    });

    window.addEventListener('beforeunload', e => {
        if (isDirty) { e.preventDefault(); e.returnValue = ''; }
    });

    document.getElementById('aboutForm').addEventListener('submit', () => { isDirty = false; });
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>