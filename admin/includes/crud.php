<?php
declare(strict_types=1);

/**
 * AdminCrud — محرّك CRUD موحّد لكل الجداول البسيطة
 *
 * الاستخدام:
 *   require_once __DIR__ . '/includes/crud.php';
 *   $crud = new AdminCrud('services', [
 *       'singular' => 'خدمة',
 *       'plural'   => 'الخدمات',
 *       'search'   => ['title','description'],
 *       'fields'   => [...]
 *   ]);
 *   $crud->run();
 *   include __DIR__ . '/includes/head.php';
 *   $crud->render();
 *   include __DIR__ . '/includes/footer.php';
 */
class AdminCrud
{
    public string $table;
    public array  $cfg;
    public PDO    $db;

    public function __construct(string $table, array $cfg)
    {
        $this->table = $table;
        $this->db    = db();
        $this->cfg   = array_merge([
            'singular'     => 'عنصر',
            'plural'       => 'العناصر',
            'search'       => [],
            'order_by'     => 'sort_order ASC, id DESC',
            'has_active'   => true,
            'has_image'    => false,
            'image_field'  => 'image',
            'image_folder' => 'uploads',
            'page_action'  => basename($_SERVER['PHP_SELF']),
        ], $cfg);

        // لو مفيش حقل is_active في الـ fields، نضيفه تلقائياً لو has_active
        if ($this->cfg['has_active'] && !isset($this->cfg['fields']['is_active'])) {
            $this->cfg['fields']['is_active'] = [
                'label'   => 'مفعّل',
                'type'    => 'toggle',
                'default' => 1,
                'col'     => 'col-md-6',
            ];
        }
    }

    /* ==============================
     *  1) معالجة الإجراءات (POST)
     * ============================== */
    public function run(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        requireCsrf();

        $action = $_POST['action'] ?? '';

        try {
            switch ($action) {
                case 'save':   $this->handleSave();   break;
                case 'delete': $this->handleDelete(); break;
                case 'toggle': $this->handleToggle(); break;
            }
        } catch (Throwable $e) {
            error_log($this->table . ' CRUD: ' . $e->getMessage());
            flash('danger', 'حدث خطأ: ' . $e->getMessage());
        }
        redirect($this->cfg['page_action']);
    }

    /* ---------- حفظ (إضافة أو تعديل) ---------- */
    private function handleSave(): void
    {
        $id   = (int)($_POST['id'] ?? 0);
        $data = $this->collectPost();

        // رفع الصورة لو الجدول فيه صورة
        if ($this->cfg['has_image']) {
            $this->handleImage($data, $id);
        }

        if ($id > 0) {
            // UPDATE
            $sets = implode(',', array_map(fn($k) => "`$k`=:$k", array_keys($data)));
            $data['id'] = $id;
            $this->db->prepare("UPDATE {$this->table} SET $sets WHERE id=:id")
                     ->execute($data);
            flash('success', "تم تحديث {$this->cfg['singular']} ✅");
        } else {
            // INSERT
            $cols = implode(',', array_map(fn($k) => "`$k`", array_keys($data)));
            $phs  = implode(',', array_map(fn($k) => ":$k", array_keys($data)));
            $this->db->prepare("INSERT INTO {$this->table} ($cols) VALUES ($phs)")
                     ->execute($data);
            flash('success', "تم إضافة {$this->cfg['singular']} ✅");
        }
    }

    /* ---------- حذف ---------- */
    private function handleDelete(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $this->db->prepare("DELETE FROM {$this->table} WHERE id=?")
                     ->execute([$id]);
            flash('success', 'تم الحذف 🗑️');
        }
    }

    /* ---------- تفعيل / إيقاف ---------- */
    private function handleToggle(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $this->db->prepare("UPDATE {$this->table} SET is_active = 1 - is_active WHERE id=?")
                     ->execute([$id]);
        }
    }

    /* ---------- تجميع بيانات POST حسب الـ fields ---------- */
    private function collectPost(): array
    {
        $data = [];
        foreach ($this->cfg['fields'] as $name => $f) {
            if (in_array($f['type'], ['toggle', 'checkbox'], true)) {
                $data[$name] = isset($_POST[$name]) ? 1 : 0;
            } else {
                $data[$name] = post($name, (string)($f['default'] ?? ''));
            }
        }
        return $data;
    }

    /* ---------- رفع الصورة ---------- */
    private function handleImage(array &$data, int $id): void
    {
        $field   = $this->cfg['image_field'];
        $current = '';

        if ($id > 0) {
            $s = $this->db->prepare("SELECT `$field` FROM {$this->table} WHERE id=?");
            $s->execute([$id]);
            $current = (string)$s->fetchColumn();
        }

        // نبدأ بالمسار اليدوي لو موجود
        $data[$field] = post($field, $current);

        // نشوف لو في ملف مرفوع
        if (!empty($_FILES[$field . '_file']['name'])) {
            $up = handleImageUpload(
                $_FILES[$field . '_file'],
                $this->cfg['image_folder'],
                $current ?: null
            );
            if (!empty($up['error'])) {
                throw new RuntimeException($up['error']);
            }
            if (!empty($up['path'])) {
                $data[$field] = $up['path'];
            }
        }
    }

    /* ==============================
     *  2) جلب البيانات
     * ============================== */
    public function fetchAll(): array
    {
        return $this->db
            ->query("SELECT * FROM {$this->table} ORDER BY {$this->cfg['order_by']}")
            ->fetchAll();
    }

    public function fetchOne(int $id): ?array
    {
        $s = $this->db->prepare("SELECT * FROM {$this->table} WHERE id=?");
        $s->execute([$id]);
        return $s->fetch() ?: null;
    }

    /* ==============================
     *  3) الريندر (List + Form)
     * ============================== */
    public function render(): void
    {
        $search  = trim($_GET['q'] ?? '');
        $rows    = $this->fetchAll();

        // فلترة البحث
        if ($search !== '' && !empty($this->cfg['search'])) {
            $rows = array_values(array_filter($rows, function ($r) use ($search) {
                foreach ($this->cfg['search'] as $col) {
                    if (stripos((string)($r[$col] ?? ''), $search) !== false) return true;
                }
                return false;
            }));
        }

        $editId  = (int)($_GET['edit'] ?? 0);
        $editing = null;
        if (isset($_GET['edit']) && $_GET['edit'] === 'new') {
            $editing = null; // إضافة جديدة
        } elseif ($editId > 0) {
            $editing = $this->fetchOne($editId);
        }

        $showForm = isset($_GET['edit']);
        $A        = $this->cfg['page_action'];
        ?>

        <!-- ==== شريط البحث والإضافة ==== -->
        <div class="f-filter-bar">
            <form class="f-search" method="get" action="<?= e($A) ?>">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="q" value="<?= e($search) ?>"
                       placeholder="ابحث في <?= e($this->cfg['plural']) ?>...">
            </form>
            <span class="f-chip active">
                <i class="fa-solid fa-list"></i>
                <?= e($this->cfg['plural']) ?>
                <span class="count"><?= count($rows) ?></span>
            </span>
            <a href="<?= e($A) ?>?edit=new" class="btn-primary-c">
                <i class="fa-solid fa-plus"></i>
                إضافة <?= e($this->cfg['singular']) ?>
            </a>
        </div>

        <!-- ==== فورم الإضافة / التعديل ==== -->
        <?php if ($showForm): ?>
            <div class="f-panel">
                <div class="panel-head">
                    <h2>
                        <i class="fa-solid <?= $editing ? 'fa-pen-to-square' : 'fa-plus' ?>"></i>
                        <?= $editing ? 'تعديل' : 'إضافة' ?> <?= e($this->cfg['singular']) ?>
                    </h2>
                    <a href="<?= e($A) ?>" class="btn-icon btn-edit" title="إغلاق">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                </div>
                <div style="padding:24px">
                    <?php $this->renderForm($editing, $A); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- ==== جدول القائمة ==== -->
        <div class="f-panel">
            <div class="panel-head">
                <h2>
                    <i class="fa-solid fa-table-list"></i>
                    قائمة <?= e($this->cfg['plural']) ?>
                </h2>
            </div>

            <?php if (empty($rows)): ?>
                <div class="empty-state">
                    <i class="fa-solid fa-inbox"></i>
                    <h4>لا توجد <?= e($this->cfg['plural']) ?> بعد</h4>
                </div>
            <?php else: ?>
                <div style="overflow-x:auto">
                    <table class="f-table">
                        <thead>
                            <tr>
                                <th style="width:60px">#</th>
                                <?php foreach ($this->cfg['fields'] as $n => $f):
                                    if (!empty($f['hide_in_list'])) continue;
                                    if (in_array($f['type'], ['color', 'toggle', 'textarea', 'richtext'], true) && empty($f['in_list'])) continue;
                                ?>
                                    <th><?= e($f['label']) ?></th>
                                <?php endforeach; ?>
                                <th style="width:170px">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $i => $r): ?>
                                <tr>
                                    <td><strong><?= $i + 1 ?></strong></td>
                                    <?php foreach ($this->cfg['fields'] as $n => $f):
                                        if (!empty($f['hide_in_list'])) continue;
                                        if (in_array($f['type'], ['color', 'toggle', 'textarea', 'richtext'], true) && empty($f['in_list'])) continue;
                                    ?>
                                        <td><?php $this->renderCell($n, $f, $r); ?></td>
                                    <?php endforeach; ?>
                                    <td>
                                        <div style="display:flex;gap:6px;flex-wrap:wrap">
                                            <a href="<?= e($A) ?>?edit=<?= (int)$r['id'] ?>"
                                               class="btn-icon btn-edit" title="تعديل">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <?php if ($this->cfg['has_active']): ?>
                                                <form method="post" style="display:inline">
                                                    <?= csrfField() ?>
                                                    <input type="hidden" name="action" value="toggle">
                                                    <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                                                    <button type="submit"
                                                            class="btn-icon <?= !empty($r['is_active']) ? 'btn-toggle-on' : 'btn-toggle-off' ?>"
                                                            title="تفعيل / إيقاف">
                                                        <i class="fa-solid <?= !empty($r['is_active']) ? 'fa-eye' : 'fa-eye-slash' ?>"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <form method="post" id="del-<?= $this->table ?>-<?= (int)$r['id'] ?>" style="display:inline">
                                                <?= csrfField() ?>
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                                                <button type="button" class="btn-icon btn-del"
                                                        onclick="confirmDelete('del-<?= $this->table ?>-<?= (int)$r['id'] ?>')"
                                                        title="حذف">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <?php
    }

    /* ---------- رسم خلية الجدول ---------- */
    private function renderCell(string $n, array $f, array $r): void
    {
        $val = $r[$n] ?? '';

        switch ($f['type']) {
                       case 'image':
                $containerId = 'img-uploader-' . $n . '-' . uniqid();
                $inputId     = 'img-input-' . $n . '-' . uniqid();
                $hasImage    = !empty($val);
                ?>
                <div class="img-uploader <?= $hasImage ? 'has-image' : '' ?>" id="<?= $containerId ?>">
                    <?php if ($hasImage): ?>
                        <div class="uploader-preview">
                            <img src="<?= e(adminImg($val)) ?>" alt="preview">
                            <div class="uploader-meta">
                                <strong>الصورة الحالية</strong>
                                <code><?= e($val) ?></code>
                                <div class="uploader-actions">
                                    <button type="button" class="uploader-btn uploader-btn-change" onclick="document.getElementById('<?= $inputId ?>').click()">
                                        <i class="fa-solid fa-arrows-rotate"></i> تغيير الصورة
                                    </button>
                                    <button type="button" class="uploader-btn uploader-btn-remove" onclick="removeImage('<?= $inputId ?>', '<?= $containerId ?>', '<?= e($n) ?>')">
                                        <i class="fa-solid fa-trash"></i> حذف
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="uploader-drop" onclick="document.getElementById('<?= $inputId ?>').click()">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <p>اسحب صورة هنا أو اضغط للاختيار</p>
                            <small>JPG / PNG / WEBP — حتى 5 ميجا</small>
                        </div>
                    <?php endif; ?>
                </div>
                <input type="file" name="<?= e($n) ?>_file" id="<?= $inputId ?>" accept="image/*" style="display:none" onchange="handleImageUpload(this, '<?= $containerId ?>')">
                <input type="hidden" name="<?= e($n) ?>" value="<?= e((string)$val) ?>">
                <script>setupImageDrop('<?= $containerId ?>', '<?= $inputId ?>');</script>
                <?php
                break;

            case 'toggle':
                // يظهر كـ switch صغير داخل الجدول
                $checked = !empty($val) ? 'checked' : '';
                echo '<form method="post" style="display:inline">' . csrfField()
                   . '<input type="hidden" name="action" value="toggle">'
                   . '<input type="hidden" name="id" value="' . (int)$r['id'] . '">'
                   . '<label class="switch"><input type="checkbox" ' . $checked
                   . ' onchange="this.form.submit()"><span class="slider"></span></label></form>';
                break;

            case 'color':
                if (!empty($val)) {
                    echo '<span style="display:inline-flex;align-items:center;gap:6px">'
                       . '<span style="width:18px;height:18px;border-radius:5px;display:inline-block;'
                       . 'background:' . e($val) . ';border:1px solid #e2e8f0"></span>'
                       . '<code style="font-size:.75rem">' . e($val) . '</code></span>';
                } else {
                    echo '<span style="color:#cbd5e1">—</span>';
                }
                break;

            default:
                $text = strip_tags((string)$val);
                echo e(mb_substr($text, 0, 70)) . (mb_strlen($text) > 70 ? '…' : '');
        }
    }

    /* ---------- رسم الفورم ---------- */
    private function renderForm(?array $row, string $A): void
    {
        ?>
        <form method="post" enctype="multipart/form-data" autocomplete="off">
            <?= csrfField() ?>
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" value="<?= (int)($row['id'] ?? 0) ?>">

            <div class="row g-3">
                <?php foreach ($this->cfg['fields'] as $n => $f):
                    $val = $row[$n] ?? ($f['default'] ?? '');
                    $col = $f['col'] ?? 'col-md-6';
                ?>
                    <div class="<?= e($col) ?>">
                        <label class="f-label">
                            <?= e($f['label']) ?>
                            <?php if (!empty($f['required'])): ?>
                                <span style="color:var(--color-pink)">*</span>
                            <?php endif; ?>
                        </label>
                        <?php $this->renderInput($n, $f, $val); ?>
                        <?php if (!empty($f['hint'])): ?>
                            <small style="display:block;margin-top:6px;color:var(--text-muted);font-size:.75rem">
                                <i class="fa-solid fa-lightbulb" style="color:var(--color-jasmine-glow)"></i>
                                <?= e($f['hint']) ?>
                            </small>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div style="display:flex;gap:12px;margin-top:22px;padding-top:20px;border-top:1px solid var(--border-soft)">
                <button type="submit" class="btn-primary-c">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <?= $row ? 'حفظ التعديلات' : 'إضافة' ?>
                </button>
                <a href="<?= e($A) ?>" class="f-chip">إلغاء</a>
            </div>
        </form>
        <?php
    }

    /* ---------- رسم حقل واحد حسب نوعه ---------- */
    private function renderInput(string $n, array $f, $val): void
    {
        $req = !empty($f['required']) ? 'required' : '';
        $ph  = e((string)($f['placeholder'] ?? ''));

        switch ($f['type']) {
            case 'textarea':
                echo '<textarea name="' . e($n) . '" class="f-textarea" rows="'
                   . (int)($f['rows'] ?? 4) . '" ' . $req
                   . ' placeholder="' . $ph . '">' . e((string)$val) . '</textarea>';
                break;

            case 'richtext':
                echo '<textarea name="' . e($n) . '" class="rich-editor">' . e((string)$val) . '</textarea>';
                break;

            case 'number':
                echo '<input type="number" name="' . e($n) . '" class="f-input" value="'
                   . e((string)$val) . '" ' . $req . '>';
                break;

            case 'color':
                echo '<input type="color" name="' . e($n) . '" class="f-input" value="'
                   . e((string)($val ?: '#1d7168')) . '" style="height:46px;padding:4px">';
                break;

            case 'toggle':
                $checked = !empty($val) ? 'checked' : '';
                echo '<div style="padding-top:6px">'
                   . '<label class="switch"><input type="checkbox" name="' . e($n) . '" '
                   . $checked . '><span class="slider"></span></label></div>';
                break;

            case 'select':
                echo '<select name="' . e($n) . '" class="f-select">';
                foreach ($f['options'] as $k => $lbl) {
                    $sel = ((string)$val === (string)$k) ? 'selected' : '';
                    echo '<option value="' . e((string)$k) . '" ' . $sel . '>' . e($lbl) . '</option>';
                }
                echo '</select>';
                break;

            case 'icon':
                $icons = $f['icons'] ?? self::defaultIcons();
                echo '<div class="icon-grid">';
                foreach ($icons as $ic) {
                    $active = ($val === $ic) ? 'active' : '';
                    echo '<button type="button" class="icon-option ' . $active . '" '
                       . 'data-icon="' . e($ic) . '" onclick="pickIcon(this)" '
                       . 'title="' . e($ic) . '">'
                       . '<i class="fa-solid ' . e($ic) . '"></i></button>';
                }
                echo '</div>';
                echo '<input type="hidden" name="' . e($n) . '" value="' . e((string)$val) . '">';
                break;

            case 'image':
                if (!empty($val)) {
                    echo '<div class="img-current-preview">'
                       . '<img src="' . e(adminImg($val)) . '" alt="">'
                       . '<div class="meta"><strong>الصورة الحالية</strong>'
                       . '<code>' . e($val) . '</code></div></div>';
                }
                echo '<div class="img-upload-zone" onclick="this.nextElementSibling.click()">'
                   . '<i class="fa-solid fa-cloud-arrow-up"></i>'
                   . '<p>اسحب صورة هنا أو اضغط للاختيار</p>'
                   . '<small style="color:var(--text-muted)">JPG / PNG / WEBP</small></div>';
                echo '<input type="file" name="' . e($n) . '_file" accept="image/*" '
                   . 'style="display:none" onchange="previewFile(this)">';
                echo '<input type="text" name="' . e($n) . '" class="f-input mt-2" value="'
                   . e((string)$val) . '" dir="ltr" placeholder="المسار اليدوي">';
                break;

            default: // text, email, url...
                $type = in_array($f['type'], ['text','email','url','password'], true) ? $f['type'] : 'text';
                echo '<input type="' . e($type) . '" name="' . e($n) . '" class="f-input" value="'
                   . e((string)$val) . '" ' . $req . ' placeholder="' . $ph . '" '
                   . ($type === 'url' ? 'dir="ltr"' : '') . '>';
        }
    }

    /* ---------- أيقونات Font Awesome الافتراضية ---------- */
    private static function defaultIcons(): array
{
    return [
        // نباتات وزراعة
        'fa-leaf','fa-seedling','fa-tree','fa-spa','fa-sun','fa-water','fa-fan','fa-lemon',
        // إنجازات
        'fa-star','fa-heart','fa-award','fa-certificate','fa-trophy','fa-gift',
        // وقت
        'fa-clock','fa-stopwatch','fa-calendar-check','fa-calendar-days',
        // حماية
        'fa-shield-halved','fa-bolt','fa-thumbs-up','fa-handshake',
        // تنسيق
        'fa-compass-drafting','fa-faucet-drip','fa-umbrella-beach','fa-chair','fa-couch',
        // زراعة
        'fa-scissors','fa-spray-can-sparkles','fa-shapes','fa-route','fa-road','fa-flask',
        // تواصل
        'fa-phone','fa-envelope','fa-message','fa-comment','fa-headset','fa-user-gear',
        // عناصر
        'fa-images','fa-camera','fa-circle-question','fa-clipboard-question',
        'fa-house','fa-location-dot','fa-map-location-dot','fa-shapes','fa-moon',
        'fa-lightbulb','fa-wand-magic-sparkles','fa-wand-magic','fa-align-right','fa-heading',
        // إدارة
        'fa-hand-holding-heart','fa-inbox','fa-chart-pie','fa-sliders','fa-link',
        'fa-user-shield','fa-truck-fast','fa-basket-shopping','fa-cart-shopping',
        // ماء
        'fa-droplet','fa-faucet','fa-gauge-high','fa-hand-holding-droplet',
        // مواسم
        'fa-wind','fa-cloud-sun','fa-snowflake','fa-leaf',
        // مشاريع
        'fa-diagram-project','fa-cubes','fa-building','fa-home',
    ];
}
}