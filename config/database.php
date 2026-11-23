<?php
/**
 * اتصال قاعدة البيانات + دالة db() مشتركة
 */
declare(strict_types=1);

require_once __DIR__ . '/config.php';

// ---------- بيانات الاعتماد ----------
define('DB_HOST', 'localhost');
define('DB_NAME', 'u315614949_fayrouz');
define('DB_USER', 'u315614949_fayrouz');
define('DB_PASS', 'l46LywGM&A');
define('DB_CHARSET', 'utf8mb4');

/**
 * إرجاع اتصال PDO واحد (Singleton)
 */
function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET);
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
    ];

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        if (APP_DEBUG) {
            die('DB Error: ' . $e->getMessage());
        }
        error_log('DB connection failed: ' . $e->getMessage());
        http_response_code(500);
        die('حدث خطأ في الاتصال بقاعدة البيانات. يرجى المحاولة لاحقاً.');
    }

    return $pdo;
}