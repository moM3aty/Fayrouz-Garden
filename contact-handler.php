<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/#contact');
}

// Honeypot — bots fill it, real users don't
if (!empty($_POST['website'])) {
    redirect('/?sent=1#contact');
}

startSecureSession();

// Rate limit: 60 seconds between submissions
$last = $_SESSION['last_contact'] ?? 0;
if (time() - $last < 60) {
    flash('warning', 'يرجى الانتظار دقيقة قبل إرسال رسالة جديدة.');
    $_SESSION['contact_old'] = ['name'=>post('name'),'phone'=>post('phone'),'email'=>post('email'),'district'=>post('district'),'message'=>post('message')];
    redirect('/#contact');
}

$name     = post('name');
$phone    = post('phone');
$email    = post('email');
$district = post('district');
$message  = post('message');

$errors = [];
if (mb_strlen($name) < 2)         $errors[] = 'الاسم مطلوب (حرفان على الأقل).';
if (mb_strlen($phone) < 9)        $errors[] = 'رقم الجوال غير صالح (9 أرقام على الأقل).';
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'البريد الإلكتروني غير صالح.';
if (mb_strlen($message) < 10)     $errors[] = 'الرسالة قصيرة جداً (10 أحرف على الأقل).';
if (mb_strlen($message) > 2000)   $errors[] = 'الرسالة طويلة جداً (2000 حرف كحد أقصى).';

if ($errors) {
    $_SESSION['contact_old'] = ['name'=>$name,'phone'=>$phone,'email'=>$email,'district'=>$district,'message'=>$message];
    flash('danger', implode(' ', $errors));
    redirect('/#contact');
}

try {
    db()->prepare('INSERT INTO contact_messages (name, phone, email, district, message) VALUES (?,?,?,?,?)')
        ->execute([$name, $phone, $email, $district, $message]);
    $_SESSION['last_contact'] = time();
    unset($_SESSION['contact_old']);
    flash('success', '✅ تم استلام رسالتك بنجاح! سيتواصل معك مهندس المشتل خلال 24 ساعة.');
} catch (Throwable $e) {
    error_log('contact insert: ' . $e->getMessage());
    flash('danger', 'حدث خطأ أثناء الإرسال. يرجى المحاولة لاحقاً أو الاتصال مباشرة.');
}

redirect('/?sent=1#contact');