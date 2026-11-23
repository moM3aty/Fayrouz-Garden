<?php
/**
 * إعدادات التطبيق العامة
 */
declare(strict_types=1);

// ---------- بيئة التطوير ----------
// على السيرفر خلّيها false
define('APP_DEBUG', false);

// ---------- المسارات ----------
define('BASE_PATH', dirname(__DIR__));
define('ADMIN_PATH', BASE_PATH . '/admin');
define('UPLOADS_PATH', BASE_PATH . '/assets/uploads');
define('UPLOADS_URL', '/assets/uploads');

// ---------- اسم الموقع ----------
define('APP_NAME', 'مشتل الفيروز');
define('APP_URL',  'https://fayrouzgarden.online');

// ---------- المنطقة الزمنية ----------
date_default_timezone_set('Asia/Riyadh');

// ---------- إعدادات الأمان ----------
define('SESSION_NAME',      'FAYROUZ_SESS');
define('SESSION_LIFETIME',  60 * 60 * 4);   // 4 ساعات
define('PASSWORD_MIN_LEN',  8);
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_SECONDS',   15 * 60);        // 15 دقيقة

// ---------- إعدادات الرفع ----------
define('MAX_UPLOAD_MB',    5);
define('ALLOWED_IMAGE_EXT', ['jpg','jpeg','png','webp','gif']);

// ---------- عرض الأخطاء ----------
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
}