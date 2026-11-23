<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
requireLogin();

$pageTitle  = 'صندوق الوارد';
$activeMenu = 'messages';

/* ==============================
 *  إجراءات
 * ============================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();
    $action = $_POST['action'] ?? '';
    $id     = (int)($_POST['id'] ?? 0);

    try {
        if ($action === 'read' && $id > 0) {
            db()->prepare('UPDATE contact_messages SET is_read=1 WHERE id=?')->execute([$id]);
            flash('success', 'تم تحديد الرسالة كمقروءة');
        } elseif ($action === 'unread' && $id > 0) {
            db()->prepare('UPDATE contact_messages SET is_read=0 WHERE id=?')->execute([$id]);
            flash('success', 'تم تحديد الرسالة كغير مقروءة');
        } elseif ($action === 'delete' && $id > 0) {
            db()->prepare('DELETE FROM contact_messages WHERE id=?')->execute([$id]);
            flash('success', 'تم حذف الرسالة 🗑️');
        } elseif ($action === 'read_all') {
            db()->query('UPDATE contact_messages SET is_read=1');
            flash('success', 'تم تحديد كل الرسائل كمقروءة ✅');
        } elseif ($action === 'delete_all_read') {
            db()->query('DELETE FROM contact_messages WHERE is_read=1');
            flash('success', 'تم حذف كل الرسائل المقروءة 🗑️');
        }
    } catch (Throwable $e) {
        error_log('messages action: ' . $e->getMessage());
        flash('danger', 'حدث خطأ أثناء تنفيذ العملية.');
    }
    redirect('/admin/messages.php' . (($_GET['filter'] ?? '') ? '?filter=' . urlencode($_GET['filter']) : ''));
}

/* ==============================
 *  جلب البيانات
 * ============================== */
$filter = $_GET['filter'] ?? 'all';
$search = trim($_GET['q'] ?? '');

$sql    = 'SELECT * FROM contact_messages WHERE 1=1';
$params = [];

if ($filter === 'unread') {
    $sql .= ' AND is_read=0';
} elseif ($filter === 'read') {
    $sql .= ' AND is_read=1';
}

if ($search !== '') {
    $sql .= ' AND (name LIKE ? OR phone LIKE ? OR email LIKE ? OR message LIKE ?)';
    $like = '%' . $search . '%';
    $params = [$like, $like, $like, $like];
}

$sql .= ' ORDER BY created_at DESC';

$stmt = db()->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();

$unreadCount = (int)db()->query('SELECT COUNT(*) FROM contact_messages WHERE is_read=0')->fetchColumn();
$totalCount  = (int)db()->query('SELECT COUNT(*) FROM contact_messages')->fetchColumn();
$readCount   = $totalCount - $unreadCount;

include __DIR__ . '/includes/head.php';
?>

<!-- ======== شريط الفلترة والبحث ======== -->
<div class="f-filter-bar">
    <form class="f-search" method="get" action="/admin/messages.php">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" name="q" value="<?= e($search) ?>"
               placeholder="ابحث بالاسم أو الجوال أو البريد أو الرسالة...">
        <input type="hidden" name="filter" value="<?= e($filter) ?>">
    </form>

    <a href="?filter=all<?= $search !== '' ? '&q=' . urlencode($search) : '' ?>"
       class="f-chip <?= $filter === 'all' ? 'active' : '' ?>">
        <i class="fa-solid fa-inbox"></i>
        الكل
        <span class="count"><?= $totalCount ?></span>
    </a>

    <a href="?filter=unread<?= $search !== '' ? '&q=' . urlencode($search) : '' ?>"
       class="f-chip <?= $filter === 'unread' ? 'active' : '' ?>">
        <i class="fa-solid fa-envelope"></i>
        غير مقروء
        <span class="count"><?= $unreadCount ?></span>
    </a>

    <a href="?filter=read<?= $search !== '' ? '&q=' . urlencode($search) : '' ?>"
       class="f-chip <?= $filter === 'read' ? 'active' : '' ?>">
        <i class="fa-solid fa-envelope-open"></i>
        مقروء
        <span class="count"><?= $readCount ?></span>
    </a>

    <?php if ($unreadCount > 0): ?>
        <form method="post" style="display:inline">
            <?= csrfField() ?>
            <input type="hidden" name="action" value="read_all">
            <button type="submit" class="f-chip"
                    style="border-color:var(--color-green-bright);color:var(--color-green-mid)">
                <i class="fa-solid fa-check-double"></i>
                تحديد الكل كمقروء
            </button>
        </form>
    <?php endif; ?>

    <?php if ($readCount > 0 && $filter === 'read'): ?>
        <form method="post" style="display:inline" id="deleteAllRead">
            <?= csrfField() ?>
            <input type="hidden" name="action" value="delete_all_read">
            <button type="button" class="f-chip"
                    style="border-color:var(--color-pink);color:var(--color-pink)"
                    onclick="confirmBulkDelete()">
                <i class="fa-solid fa-trash"></i>
                حذف كل المقروء
            </button>
        </form>
    <?php endif; ?>
</div>

<!-- ======== الجدول ======== -->
<div class="f-panel">
    <div class="panel-head">
        <h2><i class="fa-solid fa-inbox"></i> الرسائل (<?= count($rows) ?>)</h2>
    </div>

    <?php if (empty($rows)): ?>
        <div class="empty-state">
            <i class="fa-solid fa-envelope-open"></i>
            <h4>
                <?php if ($filter === 'unread'): ?>
                    لا توجد رسائل غير مقروءة 🎉
                <?php elseif ($filter === 'read'): ?>
                    لا توجد رسائل مقروءة
                <?php else: ?>
                    صندوق الوارد فاضي
                <?php endif; ?>
            </h4>
            <p style="color:var(--text-muted);margin:0">ستظهر هنا رسائل العملاء من صفحة التواصل</p>
        </div>
    <?php else: ?>
        <div style="overflow-x:auto">
            <table class="f-table">
                <thead>
                    <tr>
                        <th style="width:40px"></th>
                        <th>المرسل</th>
                        <th>الجوال</th>
                        <th>المنطقة</th>
                        <th>الرسالة</th>
                        <th>التاريخ</th>
                        <th style="width:160px">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r): ?>
                        <tr style="<?= $r['is_read'] ? '' : 'background:var(--color-soft-rayhan);font-weight:700' ?>">
                            <td>
                                <?php if (!$r['is_read']): ?>
                                    <span style="display:inline-block;width:9px;height:9px;border-radius:50%;
                                                 background:var(--color-pink);
                                                 box-shadow:0 0 0 3px rgba(224,73,107,.2)"></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= e($r['name']) ?></strong>
                                <?php if (!empty($r['email'])): ?>
                                    <br><small style="color:var(--text-muted)" dir="ltr"><?= e($r['email']) ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="tel:<?= e($r['phone']) ?>" dir="ltr"
                                   style="color:var(--color-baby-blue);font-weight:700">
                                    <?= e($r['phone']) ?>
                                </a>
                            </td>
                            <td><?= e($r['district'] ?? '—') ?></td>
                            <td style="max-width:400px">
                                <?= e(mb_substr($r['message'], 0, 90)) ?>
                                <?= mb_strlen($r['message']) > 90 ? '…' : '' ?>
                            </td>
                            <td>
                                <small style="color:var(--text-muted)">
                                    <?= e(date('Y-m-d H:i', strtotime($r['created_at']))) ?>
                                </small>
                            </td>
                            <td>
                                <div style="display:flex;gap:6px;flex-wrap:wrap">
                                    <!-- عرض -->
                                    <button type="button" class="btn-icon btn-edit"
                                            title="عرض الرسالة"
                                            onclick='viewMsg(<?= json_encode($r, JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <!-- تحديد كمقروء -->
                                    <?php if (!$r['is_read']): ?>
                                        <form method="post" style="display:inline">
                                            <?= csrfField() ?>
                                            <input type="hidden" name="action" value="read">
                                            <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                                            <button type="submit" class="btn-icon btn-toggle-on" title="تحديد كمقروء">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <!-- حذف -->
                                    <form method="post" id="msgdel-<?= (int)$r['id'] ?>" style="display:inline">
                                        <?= csrfField() ?>
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                                        <button type="button" class="btn-icon btn-del"
                                                title="حذف"
                                                onclick="confirmDelete('msgdel-<?= (int)$r['id'] ?>', 'هل تريد حذف هذه الرسالة نهائياً؟')">
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

<script>
/* عرض تفاصيل الرسالة */
function viewMsg(r) {
    const emailRow = r.email
        ? `<p style="margin:8px 0"><strong>البريد:</strong> <span dir="ltr">${escapeHtml(r.email)}</span></p>`
        : '';
    const districtRow = r.district
        ? `<p style="margin:8px 0"><strong>المنطقة:</strong> ${escapeHtml(r.district)}</p>`
        : '';

    Swal.fire({
        title: '',
        html: `
            <div style="text-align:right;font-family:'Tajawal',sans-serif;direction:rtl">
                <div style="display:flex;align-items:center;gap:12px;
                            padding-bottom:14px;margin-bottom:14px;
                            border-bottom:2px solid var(--color-soft-rayhan)">
                    <div style="width:50px;height:50px;border-radius:12px;
                                background:linear-gradient(135deg,var(--color-green-mid),var(--color-green-bright));
                                color:#fff;display:grid;place-items:center;font-weight:900;font-size:1.2rem;
                                box-shadow:0 6px 16px rgba(31,168,97,.3)">
                        ${escapeHtml(r.name.charAt(0))}
                    </div>
                    <div>
                        <h3 style="margin:0;color:var(--color-green-dark);font-size:1.15rem">
                            ${escapeHtml(r.name)}
                        </h3>
                        <small style="color:var(--text-muted)">
                            ${new Date(r.created_at).toLocaleString('ar-EG')}
                        </small>
                    </div>
                </div>

                <p style="margin:8px 0">
                    <strong>الجوال:</strong>
                    <a href="tel:${escapeHtml(r.phone)}" dir="ltr"
                       style="color:var(--color-baby-blue);font-weight:800">
                        ${escapeHtml(r.phone)}
                    </a>
                </p>
                ${emailRow}
                ${districtRow}

                <div style="margin-top:18px;padding:16px;background:var(--bg-light);
                            border-radius:12px;border:1px solid var(--border-soft);
                            line-height:1.9;color:var(--text-main);white-space:pre-wrap">
                    ${escapeHtml(r.message)}
                </div>

                <div style="display:flex;gap:8px;margin-top:18px;flex-wrap:wrap">
                    <a href="https://wa.me/${escapeHtml(r.phone.replace(/^0/, '966'))}"
                       target="_blank"
                       style="flex:1;min-width:140px;text-align:center;padding:11px 18px;
                              background:linear-gradient(135deg,#25D366,#128C7E);color:#fff;
                              border-radius:10px;font-weight:800;text-decoration:none">
                        <i class="fa-brands fa-whatsapp"></i> رد واتساب
                    </a>
                    <a href="tel:${escapeHtml(r.phone)}"
                       style="flex:1;min-width:140px;text-align:center;padding:11px 18px;
                              background:linear-gradient(135deg,var(--color-green-mid),var(--color-green-bright));
                              color:#fff;border-radius:10px;font-weight:800;text-decoration:none">
                        <i class="fa-solid fa-phone"></i> اتصال
                    </a>
                </div>
            </div>
        `,
        width: 620,
        showCloseButton: true,
        showConfirmButton: false,
        customClass: { popup: 'swal2-popup' }
    });
}

function escapeHtml(s) {
    if (s === null || s === undefined) return '';
    return String(s)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

function confirmBulkDelete() {
    Swal.fire({
        title: 'حذف كل الرسائل المقروءة؟',
        html: '<p>سيتم حذف جميع الرسائل التي تم قراءتها نهائياً. لا يمكن التراجع.</p>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-trash"></i> نعم، احذف',
        cancelButtonText: 'إلغاء',
        reverseButtons: true,
        confirmButtonColor: '#e0496b',
        cancelButtonColor: '#64748b'
    }).then(r => {
        if (r.isConfirmed) document.getElementById('deleteAllRead').submit();
    });
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>