<?php
// admin/account.php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';

requireLogin();

$pageTitle  = 'حسابي';
$activeMenu = 'account';

$admin = currentAdmin();
$errors = [];

// ---------- إجراءات ----------
$action = $_POST['action'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action) {
    requireCsrf();

    // 1) تحديث البيانات
    if ($action === 'update_profile') {
        $fullName = post('full_name');
        $email    = post('email');
        $username = post('username');

        if (mb_strlen($username) < 3) {
            flash('danger', 'اسم المستخدم قصير جداً (3 أحرف على الأقل).');
            redirect('/admin/account.php');
        }
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            flash('danger', 'البريد الإلكتروني غير صالح.');
            redirect('/admin/account.php');
        }
        $check = db()->prepare('SELECT COUNT(*) FROM admin_users WHERE username = ? AND id != ?');
        $check->execute([$username, $admin['id']]);
        if ((int)$check->fetchColumn() > 0) {
            flash('danger', 'اسم المستخدم مستخدم بالفعل.');
            redirect('/admin/account.php');
        }

        try {
            db()->prepare('UPDATE admin_users SET username = ?, full_name = ?, email = ? WHERE id = ?')
                ->execute([$username, $fullName, $email, $admin['id']]);
            $_SESSION['admin_name'] = $fullName ?: $username;
            flash('success', 'تم تحديث البيانات ✅');
        } catch (Throwable $e) {
            error_log('account update: ' . $e->getMessage());
            flash('danger', 'حدث خطأ أثناء التحديث.');
        }
        redirect('/admin/account.php');
    }

    // 2) تغيير كلمة المرور
    if ($action === 'change_password') {
        $current = post('current_password');
        $new     = post('new_password');
        $confirm = post('confirm_password');

        if ($current === '' || $new === '' || $confirm === '') {
            flash('danger', 'يرجى ملء جميع الحقول.');
            redirect('/admin/account.php');
        }
        if (mb_strlen($new) < PASSWORD_MIN_LEN) {
            flash('danger', 'كلمة المرور الجديدة يجب أن تكون ' . PASSWORD_MIN_LEN . ' أحرف على الأقل.');
            redirect('/admin/account.php');
        }
        if ($new !== $confirm) {
            flash('danger', 'كلمتا المرور الجديدتان غير متطابقتين.');
            redirect('/admin/account.php');
        }
        $stmt = db()->prepare('SELECT password_hash FROM admin_users WHERE id = ?');
        $stmt->execute([$admin['id']]);
        $hash = $stmt->fetchColumn();

        if (!$hash || !password_verify($current, $hash)) {
            flash('danger', 'كلمة المرور الحالية غير صحيحة.');
            redirect('/admin/account.php');
        }
        if ($current === $new) {
            flash('warning', 'كلمة المرور الجديدة مطابقة للقديمة، اختر كلمة أخرى.');
            redirect('/admin/account.php');
        }

        try {
            $newHash = password_hash($new, PASSWORD_DEFAULT);
            db()->prepare('UPDATE admin_users SET password_hash = ? WHERE id = ?')
                ->execute([$newHash, $admin['id']]);
            session_regenerate_id(true);
            flash('success', 'تم تغيير كلمة المرور بنجاح ✅');
        } catch (Throwable $e) {
            error_log('password change: ' . $e->getMessage());
            flash('danger', 'حدث خطأ أثناء تغيير كلمة المرور.');
        }
        redirect('/admin/account.php');
    }
}

$stmt = db()->prepare('SELECT * FROM admin_users WHERE id = ?');
$stmt->execute([$admin['id']]);
$user = $stmt->fetch();

include __DIR__ . '/includes/head.php';
?>

<style>
    .account-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: start; }
    @media(max-width: 991px) { .account-grid { grid-template-columns: 1fr; } }

    /* Welcome Card */
    .welcome-card {
        background: linear-gradient(135deg, var(--color-green-dark) 0%, var(--color-green-mid) 50%, var(--color-green-bright) 100%);
        color: #fff; border-radius: var(--radius-lg); padding: 28px; margin-bottom: 28px;
        display: flex; align-items: center; gap: 24px; position: relative; overflow: hidden;
        box-shadow: 0 20px 40px rgba(15,61,40,.2);
    }
    .welcome-card::before { content: ""; position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,.08); border-radius: 50%; }
    .welcome-card::after { content: ""; position: absolute; bottom: -70px; left: -50px; width: 220px; height: 220px; background: rgba(255,255,255,.06); border-radius: 50%; }
    
    .welcome-avatar {
        width: 80px; height: 80px; border-radius: 20px; background: rgba(255,255,255,.15); backdrop-filter: blur(10px);
        display: grid; place-items: center; font-size: 2rem; font-weight: 900; border: 3px solid rgba(255,255,255,.3);
        flex-shrink: 0; position: relative; z-index: 1; box-shadow: 0 8px 24px rgba(0,0,0,.2);
    }
    .welcome-info { position: relative; z-index: 1; flex: 1; min-width: 0; }
    .welcome-info h2 { margin: 0 0 6px; font-size: 1.5rem; font-weight: 900; color: #fff; }
    .welcome-info p { margin: 0; color: rgba(255,255,255,.85); font-size: .95rem; font-weight: 700; display: flex; align-items: center; gap: 8px; }
    .welcome-meta { display: flex; gap: 12px; margin-top: 14px; flex-wrap: wrap; }
    .welcome-meta span { background: rgba(255,255,255,.15); padding: 6px 14px; border-radius: 20px; font-size: .8rem; font-weight: 800; display: inline-flex; align-items: center; gap: 6px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,.1); }

    /* Form Cards */
    .form-card {
        background: var(--bg-white); border-radius: var(--radius-md);
        border: 1px solid var(--border-soft); padding: 28px;
        box-shadow: var(--shadow-fayrouz); transition: var(--transition-smooth); height: 100%;
    }
    .form-card:hover { border-color: rgba(31,168,97,.3); box-shadow: var(--shadow-hover); }
    .form-card h3 { font-size: 1.1rem; font-weight: 900; color: var(--color-green-dark); margin: 0 0 20px; padding-bottom: 14px; border-bottom: 2px solid var(--color-soft-rayhan); display: flex; align-items: center; gap: 10px; }
    .form-card h3 i { width: 34px; height: 34px; border-radius: 10px; background: linear-gradient(135deg, var(--color-green-mid), var(--color-green-bright)); color: #fff; display: grid; place-items: center; font-size: .9rem; }

    /* Password Strength */
    .password-strength { margin-top: 8px; display: flex; gap: 4px; height: 6px; }
    .strength-bar { flex: 1; background: #e2e8f0; border-radius: 4px; transition: var(--transition-smooth); }
    .strength-bar.weak { background: var(--color-pink); }
    .strength-bar.medium { background: var(--color-jasmine-glow); }
    .strength-bar.strong { background: var(--color-green-bright); }
    .strength-text { font-size: .75rem; font-weight: 800; margin-top: 6px; display: block; }
    .strength-text.weak { color: var(--color-pink); }
    .strength-text.medium { color: var(--color-jasmine-glow); }
    .strength-text.strong { color: var(--color-green-bright); }

    /* Inputs */
    .f-input { padding-right: 44px !important; } /* لتعويض مساحة الأيقونة */
    .input-icon-wrap { position: relative; }
    .input-icon-wrap i.icon { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); opacity: .6; font-size: .9rem; pointer-events: none; }
    .input-icon-wrap i.toggle-pass { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); cursor: pointer; font-size: .9rem; transition: var(--transition-smooth); }
    .input-icon-wrap i.toggle-pass:hover { color: var(--color-green-bright); }

    /* Security Tip */
    .security-tip { background: var(--color-soft-blue); border: 1px solid var(--color-sky-blue); color: var(--color-baby-blue); padding: 16px; border-radius: 12px; font-size: .85rem; font-weight: 700; line-height: 1.7; margin-top: 20px; display: flex; gap: 12px; }
    .security-tip i { font-size: 1.2rem; flex-shrink: 0; margin-top: 2px; }

    /* Info Rows */
    .info-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px dashed var(--border-soft); font-size: .9rem; }
    .info-row:last-child { border-bottom: none; }
    .info-row .k { color: var(--text-muted); font-weight: 700; }
    .info-row .v { color: var(--color-green-dark); font-weight: 900; }
</style>

<!-- Welcome -->
<div class="welcome-card">
    <div class="welcome-avatar"><?= e(mb_substr($user['full_name'] ?: $user['username'], 0, 1)) ?></div>
    <div class="welcome-info">
        <h2><?= e($user['full_name'] ?: $user['username']) ?></h2>
        <p><i class="fa-solid fa-user-shield"></i> <?= $user['role'] === 'admin' ? 'مدير النظام' : 'محرر' ?> — @<?= e($user['username']) ?></p>
        <div class="welcome-meta">
            <span><i class="fa-solid fa-calendar-check"></i> عضو منذ <?= e(date('Y-m-d', strtotime($user['created_at']))) ?></span>
            <?php if ($user['last_login']): ?>
                <span><i class="fa-solid fa-clock"></i> آخر دخول <?= e(date('Y-m-d H:i', strtotime($user['last_login']))) ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="account-grid">
    <!-- Profile Form -->
    <div class="form-card">
        <h3><i class="fa-solid fa-user-pen"></i> بيانات الحساب</h3>
        <form method="post" autocomplete="off">
            <?= csrfField() ?>
            <input type="hidden" name="action" value="update_profile">
            
            <div style="margin-bottom: 16px">
                <label class="f-label">الاسم الكامل</label>
                <div class="input-icon-wrap">
                    <i class="fa-solid fa-user icon"></i>
                    <input type="text" name="full_name" class="f-input" value="<?= e($user['full_name']) ?>" maxlength="100">
                </div>
            </div>

            <div style="margin-bottom: 16px">
                <label class="f-label">اسم المستخدم *</label>
                <div class="input-icon-wrap">
                    <i class="fa-solid fa-at icon"></i>
                    <input type="text" name="username" class="f-input" value="<?= e($user['username']) ?>" required minlength="3" maxlength="50" dir="ltr">
                </div>
                <p class="help" style="font-size:.78rem;color:var(--text-muted);margin-top:4px;">يستخدم لتسجيل الدخول — يجب أن يكون فريداً.</p>
            </div>

            <div style="margin-bottom: 16px">
                <label class="f-label">البريد الإلكتروني</label>
                <div class="input-icon-wrap">
                    <i class="fa-solid fa-envelope icon"></i>
                    <input type="email" name="email" class="f-input" value="<?= e($user['email']) ?>" maxlength="100" dir="ltr">
                </div>
            </div>

            <div style="margin-bottom: 20px; background:var(--bg-light); padding:16px; border-radius:12px; border:1px solid var(--border-soft)">
                <div class="info-row"><span class="k">الدور</span><span class="v"><?= $user['role'] === 'admin' ? 'مدير النظام' : 'محرر' ?></span></div>
                <div class="info-row"><span class="k">تاريخ التسجيل</span><span class="v"><?= e(date('Y-m-d', strtotime($user['created_at']))) ?></span></div>
            </div>

            <button type="submit" class="btn-save" style="width:100%">
                <i class="fa-solid fa-floppy-disk"></i> حفظ البيانات
            </button>
        </form>
    </div>

    <!-- Password Form -->
    <div class="form-card">
        <h3><i class="fa-solid fa-lock"></i> تغيير كلمة المرور</h3>
        <form method="post" autocomplete="new-password" id="passwordForm">
            <?= csrfField() ?>
            <input type="hidden" name="action" value="change_password">
            
            <div style="margin-bottom: 16px">
                <label class="f-label">كلمة المرور الحالية *</label>
                <div class="input-icon-wrap">
                    <i class="fa-solid fa-key icon"></i>
                    <input type="password" name="current_password" class="f-input" required autocomplete="current-password">
                    <i class="fa-solid fa-eye toggle-pass" onclick="togglePass(this)"></i>
                </div>
            </div>

            <div style="margin-bottom: 16px">
                <label class="f-label">كلمة المرور الجديدة *</label>
                <div class="input-icon-wrap">
                    <i class="fa-solid fa-lock icon"></i>
                    <input type="password" name="new_password" id="newPassword" class="f-input" required minlength="<?= PASSWORD_MIN_LEN ?>" autocomplete="new-password" oninput="checkStrength(this.value)">
                    <i class="fa-solid fa-eye toggle-pass" onclick="togglePass(this)"></i>
                </div>
                <div class="password-strength">
                    <div class="strength-bar" id="bar1"></div>
                    <div class="strength-bar" id="bar2"></div>
                    <div class="strength-bar" id="bar3"></div>
                    <div class="strength-bar" id="bar4"></div>
                </div>
                <span class="strength-text" id="strengthText">أدخل كلمة المرور لمعرفة قوتها</span>
                <p class="help" style="font-size:.78rem;color:var(--text-muted);margin-top:4px;">على الأقل <?= PASSWORD_MIN_LEN ?> أحرف — يُنصح بمزيج من أحرف كبيرة وصغيرة وأرقام ورموز.</p>
            </div>

            <div style="margin-bottom: 16px">
                <label class="f-label">تأكيد كلمة المرور الجديدة *</label>
                <div class="input-icon-wrap">
                    <i class="fa-solid fa-check-double icon"></i>
                    <input type="password" name="confirm_password" class="f-input" required minlength="<?= PASSWORD_MIN_LEN ?>" autocomplete="new-password">
                    <i class="fa-solid fa-eye toggle-pass" onclick="togglePass(this)"></i>
                </div>
            </div>

            <div class="security-tip">
                <i class="fa-solid fa-shield-halved"></i>
                <div>
                    <strong>نصيحة أمان:</strong> استخدم كلمة مرور قوية وفريدة، لا تشاركها مع أحد، وغيّرها كل 3-6 أشهر. سيتم تسجيل خروجك من أي جلسات أخرى بعد التغيير.
                </div>
            </div>

            <button type="submit" class="btn-save" style="width:100%; margin-top:16px">
                <i class="fa-solid fa-key"></i> تغيير كلمة المرور
            </button>
        </form>
    </div>
</div>

<script>
// إظهار/إخفاء كلمة المرور
function togglePass(icon) {
    const input = icon.previousElementSibling;
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// مقياس قوة كلمة المرور
function checkStrength(val) {
    const bars = [
        document.getElementById('bar1'),
        document.getElementById('bar2'),
        document.getElementById('bar3'),
        document.getElementById('bar4')
    ];
    const text = document.getElementById('strengthText');
    
    // إعادة تعيين
    bars.forEach(b => b.className = 'strength-bar');
    text.className = 'strength-text';
    
    if (!val) {
        text.textContent = 'أدخل كلمة المرور لمعرفة قوتها';
        return;
    }

    let score = 0;
    if (val.length >= 8) score++;
    if (val.match(/[A-Z]/) && val.match(/[a-z]/)) score++;
    if (val.match(/\d/)) score++;
    if (val.match(/[^A-Za-z0-9]/)) score++;

    // القوة
    if (score <= 1) {
        text.textContent = 'ضعيفة جداً';
        text.classList.add('weak');
        bars[0].classList.add('weak');
    } else if (score === 2) {
        text.textContent = 'ضعيفة';
        text.classList.add('weak');
        bars[0].classList.add('weak');
        bars[1].classList.add('weak');
    } else if (score === 3) {
        text.textContent = 'متوسطة';
        text.classList.add('medium');
        bars[0].classList.add('medium');
        bars[1].classList.add('medium');
        bars[2].classList.add('medium');
    } else {
        text.textContent = 'قوية جداً';
        text.classList.add('strong');
        bars.forEach(b => b.classList.add('strong'));
    }
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>