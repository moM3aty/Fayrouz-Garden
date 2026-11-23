<?php
/**
 * نظام المصادقة
 */
declare(strict_types=1);

require_once __DIR__ . '/functions.php';

/* =========================================================
 *  هل المستخدم مسجل دخول؟
 * ========================================================= */
function isLoggedIn(): bool
{
    startSecureSession();
    if (empty($_SESSION['admin_id'])) return false;

    // فحص انتهاء الجلسة
    if (!empty($_SESSION['last_activity'])
        && (time() - (int)$_SESSION['last_activity']) > SESSION_LIFETIME) {
        logoutAdmin();
        return false;
    }
    $_SESSION['last_activity'] = time();
    return true;
}

/* =========================================================
 *  بيانات المستخدم الحالي
 * ========================================================= */
function currentAdmin(): ?array
{
    if (!isLoggedIn()) return null;
    static $cache = null;
    if ($cache !== null) return $cache;

    $stmt = db()->prepare('SELECT id, username, full_name, email, role, last_login FROM admin_users WHERE id = ? LIMIT 1');
    $stmt->execute([$_SESSION['admin_id']]);
    $u = $stmt->fetch();
    return $cache = $u ?: null;
}

/* =========================================================
 *  حماية الصفحات الإدارية
 * ========================================================= */
function requireLogin(): void
{
    if (!isLoggedIn()) {
        flash('warning', 'يجب تسجيل الدخول أولاً.');
        redirect('/admin/login.php');
    }
}

/* =========================================================
 *  محاولات الدخول
 * ========================================================= */
function loginAttemptsKey(string $username): string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    return 'login_attempts_' . md5(strtolower($username) . '|' . $ip);
}

function isLockedOut(string $username): bool
{
    startSecureSession();
    $data = $_SESSION[loginAttemptsKey($username)] ?? null;
    if (!$data) return false;
    if ($data['count'] < MAX_LOGIN_ATTEMPTS) return false;
    if (time() > $data['until']) {
        unset($_SESSION[loginAttemptsKey($username)]);
        return false;
    }
    return true;
}

function recordFailedAttempt(string $username): void
{
    startSecureSession();
    $key = loginAttemptsKey($username);
    $data = $_SESSION[$key] ?? ['count' => 0, 'until' => 0];
    $data['count']++;
    if ($data['count'] >= MAX_LOGIN_ATTEMPTS) {
        $data['until'] = time() + LOCKOUT_SECONDS;
    }
    $_SESSION[$key] = $data;
}

function clearFailedAttempts(string $username): void
{
    startSecureSession();
    unset($_SESSION[loginAttemptsKey($username)]);
}

/* =========================================================
 *  تسجيل الدخول
 * ========================================================= */
function attemptLogin(string $username, string $password): array
{
    if ($username === '' || $password === '') {
        return ['ok' => false, 'message' => 'يرجى إدخال اسم المستخدم وكلمة المرور.'];
    }
    if (isLockedOut($username)) {
        return ['ok' => false, 'message' => 'تم قفل الحساب مؤقتاً بسبب محاولات خاطئة متكررة. حاول بعد ' . (LOCKOUT_SECONDS / 60) . ' دقيقة.'];
    }

    $stmt = db()->prepare('SELECT * FROM admin_users WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        recordFailedAttempt($username);
        return ['ok' => false, 'message' => 'اسم المستخدم أو كلمة المرور غير صحيحة.'];
    }

    // إعادة تجزئة الباسورد لو تغيرت الخوارزمية
    if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        db()->prepare('UPDATE admin_users SET password_hash = ? WHERE id = ?')
            ->execute([$newHash, $user['id']]);
    }

    // تحديث آخر دخول
    db()->prepare('UPDATE admin_users SET last_login = NOW() WHERE id = ?')
        ->execute([$user['id']]);

    // تدوير الجلسة
    startSecureSession();
    session_regenerate_id(true);
    clearFailedAttempts($username);

    $_SESSION['admin_id']      = (int)$user['id'];
    $_SESSION['admin_name']    = $user['full_name'] ?: $user['username'];
    $_SESSION['admin_role']    = $user['role'];
    $_SESSION['last_activity'] = time();
    $_SESSION['_created']      = time();

    return ['ok' => true, 'message' => 'تم تسجيل الدخول بنجاح.'];
}

/* =========================================================
 *  تسجيل الخروج
 * ========================================================= */
function logoutAdmin(): void
{
    startSecureSession();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}