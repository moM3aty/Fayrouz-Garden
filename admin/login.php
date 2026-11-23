<?php
// admin/login.php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';

if (isLoggedIn()) redirect('/admin/index.php');

$hasAdmin = false;
try { $hasAdmin = (int)db()->query('SELECT COUNT(*) FROM admin_users')->fetchColumn() > 0; } catch (Throwable $e) {}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrf()) { $error = 'انتهت الجلسة. يرجى إعادة المحاولة.'; }
    else {
        $result = attemptLogin(post('username'), post('password'));
        if ($result['ok']) { flash('success', 'أهلاً بك مجدداً '); redirect('/admin/index.php'); }
        $error = $result['message'];
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول | مشتل الفيروز</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --green-dark: #082f20;
            --green-deep: #0d422c;
            --green-main: #147a4b;
            --green-bright: #24b66d;
            --green-light: #e9f8ef;
            --pink: #e0496b;
            --white: #ffffff;
            --text-dark: #153b2b;
            --text-muted: #84948b;
            --border: #e6eee8;

            --transition: all .35s cubic-bezier(.2, .8, .2, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            min-height: 100%;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 35px 18px;
            overflow-x: hidden;
            position: relative;
            isolation: isolate;

            background:
                radial-gradient(ellipse at 15% 15%, rgba(36, 182, 109, .17), transparent 35%),
                radial-gradient(ellipse at 85% 85%, rgba(224, 73, 107, .11), transparent 30%),
                linear-gradient(135deg, #061f17 0%, #0b3826 48%, #092c20 100%);
        }

        /* Animated background lights */
        body::before,
        body::after {
            content: "";
            position: fixed;
            z-index: -1;
            pointer-events: none;
            border-radius: 50%;
            filter: blur(2px);
        }

        body::before {
            width: 600px;
            height: 600px;
            top: -280px;
            right: -160px;
            background: radial-gradient(
                circle,
                rgba(36, 182, 109, .20),
                rgba(36, 182, 109, .04) 45%,
                transparent 70%
            );
            animation: ambientMove 13s ease-in-out infinite alternate;
        }

        body::after {
            width: 550px;
            height: 550px;
            bottom: -300px;
            left: -130px;
            background: radial-gradient(
                circle,
                rgba(224, 73, 107, .14),
                rgba(224, 73, 107, .03) 45%,
                transparent 70%
            );
            animation: ambientMove 16s ease-in-out infinite alternate-reverse;
        }

        /* Subtle background grid */
        .background-grid {
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
            opacity: .12;
            background-image:
                linear-gradient(rgba(255,255,255,.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.07) 1px, transparent 1px);
            background-size: 55px 55px;
            mask-image: linear-gradient(to bottom, black, transparent 85%);
        }

        /* Floating decorative elements */
        .floating-leaf {
            position: fixed;
            z-index: -1;
            color: rgba(112, 218, 154, .13);
            pointer-events: none;
            animation: leafFloat 9s ease-in-out infinite;
        }

        .leaf-one {
            top: 13%;
            left: 12%;
            font-size: 55px;
            transform: rotate(-30deg);
        }

        .leaf-two {
            bottom: 15%;
            right: 10%;
            font-size: 75px;
            animation-delay: -3s;
        }

        .leaf-three {
            top: 65%;
            left: 18%;
            font-size: 35px;
            animation-delay: -5s;
        }

        .leaf-four {
            top: 20%;
            right: 16%;
            font-size: 28px;
            animation-delay: -2s;
        }

        /* Main wrapper */
        .page-wrapper {
            width: 100%;
            max-width: 470px;
            position: relative;
            z-index: 2;
            perspective: 1000px;
        }

        /* Decorative card glow */
        .card-glow {
            position: absolute;
            inset: -2px;
            border-radius: 30px;
            background: linear-gradient(
                135deg,
                rgba(54, 216, 130, .65),
                rgba(255,255,255,.05) 35%,
                rgba(224,73,107,.35) 75%,
                rgba(54,216,130,.45)
            );
            filter: blur(14px);
            opacity: .55;
            z-index: -1;
            animation: glowPulse 5s ease-in-out infinite alternate;
        }

        /* Login card */
        .login-card {
            position: relative;
            width: 100%;
            padding: 43px 40px 35px;
            border-radius: 26px;
            overflow: hidden;

            background: rgba(255, 255, 255, .97);
            border: 1px solid rgba(255,255,255,.75);

            box-shadow:
                0 35px 100px rgba(0,0,0,.32),
                0 10px 30px rgba(0,0,0,.12),
                inset 0 1px 0 rgba(255,255,255,.9);

            animation: cardEntrance .85s cubic-bezier(.16, 1, .3, 1) both;
        }

        /* Top animated line */
        .login-card::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(
                90deg,
                var(--pink),
                var(--green-bright),
                #8ce2ae,
                var(--green-main)
            );
            background-size: 250% 100%;
            animation: gradientMove 6s linear infinite;
        }

        /* Light reflection */
        .login-card::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            top: -150px;
            left: -100px;
            border-radius: 50%;
            background: rgba(36, 182, 109, .06);
            pointer-events: none;
        }

        /* Brand area */
        .brand-area {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .logo-container {
            width: 108px;
            height: 108px;
            margin: 0 auto 20px;
            position: relative;
            display: grid;
            place-items: center;
        }

        .logo-ring {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 1px dashed rgba(20, 122, 75, .4);
            animation: rotateRing 22s linear infinite;
        }

        .logo-ring::before,
        .logo-ring::after {
            content: "";
            position: absolute;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: var(--green-bright);
            box-shadow: 0 0 12px rgba(36,182,109,.65);
        }

        .logo-ring::before {
            top: 10px;
            right: 15px;
        }

        .logo-ring::after {
            bottom: 12px;
            left: 13px;
            background: var(--pink);
            box-shadow: 0 0 12px rgba(224,73,107,.5);
        }

        .brand-logo {
            width: 86px;
            height: 86px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            border: 4px solid #fff;
            background: #f0f8f2;
            box-shadow:
                0 8px 25px rgba(20,122,75,.2),
                0 0 0 5px rgba(36,182,109,.09);
            animation: logoFloat 4s ease-in-out infinite;
        }

        .brand-fallback {
            width: 86px;
            height: 86px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 2.5rem;
            color: white;
            background: linear-gradient(145deg, var(--green-main), var(--green-bright));
            border: 4px solid #fff;
            box-shadow: 0 8px 25px rgba(20,122,75,.25);
            animation: logoFloat 4s ease-in-out infinite;
        }

        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 15px;
            margin-bottom: 15px;
            border-radius: 30px;
            color: #16814d;
            background: #eaf8ef;
            border: 1px solid #d5f0df;
            font-size: .76rem;
            font-weight: 800;
            letter-spacing: .3px;
        }

        .security-badge i {
            font-size: .75rem;
            animation: shieldPulse 2s ease-in-out infinite;
        }

        h1 {
            font-family: 'Cairo', sans-serif;
            color: var(--green-dark);
            font-size: 1.75rem;
            font-weight: 900;
            margin: 0 0 8px;
            letter-spacing: -.5px;
        }

        .sub {
            color: #829188;
            font-size: .98rem;
            font-weight: 600;
            margin-bottom: 32px;
        }

        .title-decoration {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 0 auto 27px;
        }

        .title-decoration span {
            height: 2px;
            width: 35px;
            border-radius: 5px;
            background: linear-gradient(90deg, transparent, #b7dec6);
        }

        .title-decoration i {
            color: var(--green-bright);
            font-size: .75rem;
        }

        /* Form fields */
        .field {
            position: relative;
            margin-bottom: 22px;
            text-align: right;
        }

        .field label {
            display: block;
            margin-bottom: 9px;
            color: #284b39;
            font-size: .92rem;
            font-weight: 800;
            transition: var(--transition);
        }

        .input-wrap {
            position: relative;
        }

        .field input {
            width: 100%;
            height: 57px;
            padding: 12px 48px 12px 16px;
            border: 1.7px solid #e5ece7;
            border-radius: 13px;
            outline: none;
            background: #f8faf9;
            color: #193c2b;
            font-family: 'Tajawal', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            transition: var(--transition);
            direction: rtl;
        }

        .field input::placeholder {
            color: #a6b3aa;
            font-size: .91rem;
            font-weight: 500;
        }

        .field input:hover {
            border-color: #c5dece;
            background: #fff;
        }

        .field input:focus {
            border-color: var(--green-bright);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(36,182,109,.10);
        }

        .field i {
            position: absolute;
            right: 17px;
            top: 50%;
            transform: translateY(-50%);
            color: #91a69a;
            font-size: 1rem;
            transition: var(--transition);
            pointer-events: none;
        }

        .field input:focus ~ i {
            color: var(--green-bright);
            transform: translateY(-50%) scale(1.12);
        }

        /* Login button */
        .btn-login {
            width: 100%;
            min-height: 58px;
            border: none;
            border-radius: 13px;
            position: relative;
            overflow: hidden;

            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;

            color: #fff;
            background: linear-gradient(120deg, #11643c, #1b9c5c, #27b96e);
            background-size: 200% 200%;

            font-family: 'Cairo', sans-serif;
            font-size: 1.04rem;
            font-weight: 900;

            cursor: pointer;
            box-shadow: 0 9px 22px rgba(20,122,75,.24);
            transition: var(--transition);
            animation: buttonGradient 5s ease infinite;
        }

        .btn-login::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 65%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255,255,255,.25),
                transparent
            );
            transform: skewX(-20deg);
            transition: .65s ease;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 30px rgba(20,122,75,.34);
            background-position: 100% 50%;
        }

        .btn-login:hover::before {
            left: 150%;
        }

        .btn-login:active {
            transform: translateY(-1px) scale(.99);
        }

        .btn-login i {
            font-size: 1.05rem;
            transition: transform .35s ease;
        }

        .btn-login:hover i {
            transform: translateX(-5px);
        }

        /* No admin message */
        .install-notice {
            background: linear-gradient(135deg, #eff6ff, #f5f9ff);
            border: 1px solid #cbdffb;
            color: #1e40af;
            padding: 17px;
            border-radius: 14px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
            line-height: 1.9;
            animation: noticeEntrance .5s ease both;
        }

        .install-notice i {
            margin-left: 5px;
        }

        .install-notice a {
            color: #1e40af;
            font-weight: 900;
            text-decoration: none;
            border-bottom: 1px dashed currentColor;
            transition: var(--transition);
        }

        .install-notice a:hover {
            color: #2563eb;
            border-bottom-style: solid;
        }

        /* Footer */
        .footer-note {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #edf1ee;
            font-size: .9rem;
            color: #9aa89f;
            font-weight: 600;
        }

        .footer-note a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--green-main);
            text-decoration: none;
            font-weight: 800;
            transition: var(--transition);
        }

        .footer-note a:hover {
            color: var(--green-bright);
            gap: 12px;
        }

        .footer-note a i {
            font-size: .85rem;
        }

        .copyright {
            margin-top: 17px;
            text-align: center;
            color: rgba(255,255,255,.48);
            font-size: .78rem;
            font-weight: 600;
            animation: fadeIn 1.5s ease both;
        }

        /* Animations */
        @keyframes cardEntrance {
            from {
                opacity: 0;
                transform: translateY(45px) scale(.96);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes ambientMove {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(-45px, 35px) scale(1.13); }
        }

        @keyframes leafFloat {
            0%, 100% { translate: 0 0; rotate: 0deg; }
            50% { translate: 12px -22px; rotate: 12deg; }
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        @keyframes rotateRing {
            from { transform: rotate(0); }
            to { transform: rotate(360deg); }
        }

        @keyframes glowPulse {
            from { opacity: .35; }
            to { opacity: .75; }
        }

        @keyframes shieldPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.18); }
        }

        @keyframes gradientMove {
            from { background-position: 0% 50%; }
            to { background-position: 250% 50%; }
        }

        @keyframes buttonGradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes noticeEntrance {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Responsive */
        @media (max-width: 576px) {
            body {
                padding: 22px 15px;
            }

            .page-wrapper {
                max-width: 430px;
            }

            .login-card {
                padding: 35px 24px 27px;
                border-radius: 22px;
            }

            .logo-container {
                width: 98px;
                height: 98px;
            }

            .brand-logo,
            .brand-fallback {
                width: 78px;
                height: 78px;
            }

            h1 {
                font-size: 1.5rem;
            }

            .sub {
                font-size: .9rem;
                margin-bottom: 27px;
            }

            .field input {
                height: 54px;
            }

            .btn-login {
                min-height: 55px;
            }

            .leaf-one {
                font-size: 35px;
                left: 5%;
            }

            .leaf-two {
                font-size: 45px;
                right: 4%;
            }
        }

        @media (max-width: 360px) {
            .login-card {
                padding: 30px 19px 24px;
            }

            h1 {
                font-size: 1.35rem;
            }
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>

    <div class="background-grid" aria-hidden="true"></div>

    <div class="floating-leaf leaf-one" aria-hidden="true">
        <i class="fa-solid fa-leaf"></i>
    </div>

    <div class="floating-leaf leaf-two" aria-hidden="true">
        <i class="fa-solid fa-seedling"></i>
    </div>

    <div class="floating-leaf leaf-three" aria-hidden="true">
        <i class="fa-solid fa-leaf"></i>
    </div>

    <div class="floating-leaf leaf-four" aria-hidden="true">
        <i class="fa-solid fa-spa"></i>
    </div>

    <main class="page-wrapper">

        <div class="card-glow"></div>

        <div class="login-card">

            <div class="brand-area">

                <?php if (file_exists(BASE_PATH . '/css/logo.jpeg')): ?>
                    <div class="logo-container">
                        <div class="logo-ring"></div>
                        <img src="../css/logo.jpeg" alt="شعار مشتل الفيروز" class="brand-logo">
                    </div>
                <?php else: ?>
                    <div class="logo-container">
                        <div class="logo-ring"></div>
                        <div class="brand-fallback">🌿</div>
                    </div>
                <?php endif; ?>

                <div class="security-badge">
                    <i class="fa-solid fa-shield-halved"></i>
                    بوابة الإدارة الآمنة
                </div>

                <h1>لوحة التحكم</h1>

                <p class="sub">
                    مشتل الفيروز — أبو محمد لتنسيق الحدائق
                </p>

                <div class="title-decoration">
                    <span></span>
                    <i class="fa-solid fa-leaf"></i>
                    <span></span>
                </div>

            </div>

            <?php if (!$hasAdmin): ?>

                <div class="install-notice">
                    <i class="fa-solid fa-circle-info"></i>
                    يجب <a href="install.php">تثبيت حساب الأدمن</a> أولاً.
                </div>

            <?php else: ?>

                <form method="post" autocomplete="off" novalidate>

                    <?= csrfField() ?>

                    <div class="field">
                        <label for="username">اسم المستخدم</label>

                        <div class="input-wrap">
                            <input
                                type="text"
                                id="username"
                                name="username"
                                required
                                autofocus
                                placeholder="أدخل اسم المستخدم"
                            >
                            <i class="fa-solid fa-user"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label for="password">كلمة المرور</label>

                        <div class="input-wrap">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                placeholder="أدخل كلمة المرور"
                            >
                            <i class="fa-solid fa-lock"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        دخول إلى لوحة التحكم
                    </button>

                </form>

                <div class="footer-note">
                    <a href="<?= APP_URL ?>" target="_blank">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        زيارة الموقع
                    </a>
                </div>

            <?php endif; ?>

        </div>

        <div class="copyright">
            <i class="fa-regular fa-copyright"></i>
            مشتل الفيروز — جميع الحقوق محفوظة
        </div>

    </main>

    <?php if ($error): ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: 'error',
                title: 'تعذر الدخول',
                text: '<?= addslashes($error) ?>',
                confirmButtonText: 'حسناً',
                confirmButtonColor: '#1fa861',
                background: '#ffffff',
                color: '#153b2b',
                customClass: {
                    popup: 'rounded-4'
                }
            });
        });
    </script>
    <?php endif; ?>

</body>
</html>