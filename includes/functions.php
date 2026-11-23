<?php
/**
 * دوال مساعدة عامة
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

/* =========================================================
 *  Session
 * ========================================================= */
function startSecureSession(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) return;

    session_name(SESSION_NAME);
    session_set_cookie_params([
        'lifetime' => SESSION_LIFETIME,
        'path'     => '/',
        'domain'   => '',
        'secure'   => (APP_URL && str_starts_with(APP_URL, 'https://')),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();

    // تدوير الـ session كل 30 دقيقة
    if (!isset($_SESSION['_created'])) {
        $_SESSION['_created'] = time();
    } elseif (time() - $_SESSION['_created'] > 1800) {
        session_regenerate_id(true);
        $_SESSION['_created'] = time();
    }
}

/* =========================================================
 *  CSRF
 * ========================================================= */
function csrfToken(): string
{
    startSecureSession();
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function csrfField(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrfToken()) . '">';
}

function verifyCsrf(?string $token = null): bool
{
    startSecureSession();
    $token ??= $_POST['_csrf'] ?? '';
    return !empty($_SESSION['_csrf'])
        && is_string($token)
        && hash_equals($_SESSION['_csrf'], $token);
}

function requireCsrf(): void
{
    if (!verifyCsrf()) {
        http_response_code(419);
        die('انتهت الجلسة أو طلب غير صالح. يرجى إعادة المحاولة.');
    }
}

/* =========================================================
 *  ESCAPE
 * ========================================================= */
function e(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/* =========================================================
 *  Settings (cached)
 * ========================================================= */
function setting(string $key, string $default = ''): string
{
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        try {
            $rows = db()->query('SELECT setting_key, setting_value FROM site_settings')->fetchAll();
            foreach ($rows as $r) {
                $cache[$r['setting_key']] = $r['setting_value'];
            }
        } catch (Throwable $e) {
            error_log('Settings load failed: ' . $e->getMessage());
        }
    }
    return $cache[$key] ?? $default;
}

/* =========================================================
 *  Flash messages
 * ========================================================= */
function flash(string $type, string $message): void
{
    startSecureSession();
    $_SESSION['_flash'][] = ['type' => $type, 'message' => $message];
}

function getFlashes(): array
{
    startSecureSession();
    $f = $_SESSION['_flash'] ?? [];
    unset($_SESSION['_flash']);
    return $f;
}

/* =========================================================
 *  Redirect
 * ========================================================= */
function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}

/* =========================================================
 *  Sanitize input
 * ========================================================= */
function post(string $key, string $default = ''): string
{
    return trim((string)($_POST[$key] ?? $default));
}

function get(string $key, string $default = ''): string
{
    return trim((string)($_GET[$key] ?? $default));
}

function postInt(string $key, int $default = 0): int
{
    return (int)($_POST[$key] ?? $default);
}