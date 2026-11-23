<?php
// admin/logout.php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';

// إذا كان الطلب POST، قم بتسجيل الخروج
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    logoutAdmin();
    flash('success', 'تم تسجيل الخروج بنجاح.');
    redirect('/admin/login.php');
}

// إذا كان الطلب GET، اعرض صفحة تأكيد
$pageTitle  = 'تسجيل الخروج';
$activeMenu = '';
include __DIR__ . '/includes/head.php';
?>

<style>
    .logout-wrap {
        min-height: 70vh; display: flex; align-items: center; justify-content: center;
        padding: 20px;
    }
    .logout-card {
        background: var(--bg-white); border-radius: var(--radius-lg); padding: 40px;
        text-align: center; max-width: 440px; width: 100%;
        box-shadow: var(--shadow-lg); border: 1px solid var(--border-soft);
        animation: modalIn .4s cubic-bezier(.34,1.56,.64,1);
    }
    .logout-icon {
        width: 80px; height: 80px; border-radius: 50%; background: var(--color-soft-pink);
        color: var(--color-pink); display: grid; place-items: center; font-size: 2rem;
        margin: 0 auto 24px; animation: pulseBadge 2s infinite;
    }
    .logout-card h2 { font-size: 1.5rem; color: var(--color-green-dark); margin: 0 0 12px; font-weight: 900; }
    .logout-card p { color: var(--text-muted); font-size: .95rem; font-weight: 600; margin: 0 0 32px; line-height: 1.6; }
    .logout-actions { display: flex; gap: 12px; justify-content: center; }
    .btn-logout-cancel {
        padding: 12px 28px; border-radius: 12px; background: var(--bg-light); color: var(--text-muted);
        border: 1px solid var(--border-soft); font-family: 'Cairo'; font-weight: 800; font-size: .95rem;
        text-decoration: none; transition: var(--transition-smooth);
    }
    .btn-logout-cancel:hover { background: #fff; border-color: var(--color-green-bright); color: var(--color-green-dark); }
    .btn-logout-confirm {
        padding: 12px 28px; border-radius: 12px; background: linear-gradient(135deg, var(--color-pink), var(--color-wardy));
        color: #000; border: none; font-family: 'Cairo'; font-weight: 800; font-size: .95rem;
        cursor: pointer; transition: var(--transition-smooth); box-shadow: 0 6px 18px rgba(224,73,107,.3);
        display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-logout-confirm:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(224,73,107,.4); }
</style>

<div class="logout-wrap">
    <div class="logout-card">
        <div class="logout-icon"><i class="fa-solid fa-arrow-right-from-bracket"></i></div>
        <h2>تسجيل الخروج</h2>
        <p>هل أنت متأكد أنك تريد تسجيل الخروج من لوحة تحكم مشتل الفيروز؟</p>
        
        <div class="logout-actions">
            <a href="/admin/index.php" class="btn-logout-cancel">إلغاء</a>
            <form method="post" style="display:inline">
                <button type="submit" class="btn-logout-confirm">
                    <i class="fa-solid fa-sign-out-alt"></i> نعم، اخرج
                </button>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>