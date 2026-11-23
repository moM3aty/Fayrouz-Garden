<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';
http_response_code(404);
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="noindex,follow">
<title>الصفحة غير موجودة | <?= e(setting('site_name', 'مشتل الفيروز')) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;800;900&display=swap" rel="stylesheet">
<style>
body{font-family:'Cairo',sans-serif;background:linear-gradient(135deg,#123f3e,#1d7168 60%,#33948a);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:30px;color:#fff;margin:0;text-align:center}
.box{max-width:520px;width:100%}
h1{font-size:6rem;font-weight:900;line-height:1;margin:0;color:rgba(255,255,255,.15);letter-spacing:-.05em}
h2{font-size:1.8rem;font-weight:900;margin:10px 0 16px}
p{color:rgba(255,255,255,.85);line-height:1.9;margin-bottom:28px}
a.btn-home{background:#fff;color:#123f3e;padding:14px 30px;border-radius:50px;font-weight:900;text-decoration:none;display:inline-flex;align-items:center;gap:10px;box-shadow:0 10px 30px rgba(0,0,0,.25);transition:.2s}
a.btn-home:hover{transform:translateY(-3px);background:#f0fdf4;color:#123f3e}
</style>
</head>
<body>
<div class="box">
<div style="font-size:5rem;margin-bottom:20px">🌿</div>
<h1>404</h1>
<h2>الصفحة غير موجودة</h2>
<p>عذراً، الصفحة التي تبحث عنها غير متوفرة أو تم نقلها.<br>يمكنك العودة للصفحة الرئيسية أو التواصل معنا مباشرة.</p>
<a href="/" class="btn-home"><i class="fa-solid fa-house"></i> العودة للرئيسية</a>
</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</body>
</html>