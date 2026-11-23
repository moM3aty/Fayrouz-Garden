<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';

header('Content-Type: application/xml; charset=UTF-8');

$base = rtrim(APP_URL, '/');
$sections = [];
try {
    $sections = db()->query('SELECT href FROM navigation_links WHERE is_active=1 AND href LIKE "#%" ORDER BY sort_order')->fetchAll(PDO::FETCH_COLUMN);
} catch (Throwable $e) {}

$today = date('Y-m-d');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= htmlspecialchars($base) ?>/</loc>
        <lastmod><?= $today ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    <?php foreach ($sections as $s): ?>
    <url>
        <loc><?= htmlspecialchars($base . '/' . $s) ?></loc>
        <lastmod><?= $today ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>
</urlset>