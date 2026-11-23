<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?= !empty($settings['site_title']) ? e($settings['site_title']) : 'تنسيق حدائق بالرياض | ' . e($siteName) . ' - أبو محمد | ' . e($phone) ?></title>
<meta content="<?= e(s('site_description', 'مشتل الفيروز - أبو محمد لتنسيق الحدائق بالرياض')) ?>" name="description"/>
<meta content="<?= e($siteName) ?> | أبو محمد لتنسيق الحدائق بالرياض | <?= e($phone) ?>" property="og:title"/>
<meta content="أفضل خدمات لاندسكيب وتنسيق حدائق منزلية وفلل واستراحات بأيدي نخبة من المهندسين الزراعيين." property="og:description"/>
<meta content="<?= e($logo) ?>" property="og:image"/>
<meta content="website" property="og:type"/>
<meta content="summary_large_image" name="twitter:card"/>
<meta content="<?= e($siteName) ?> لتنسيق الحدائق المنزلية" name="twitter:title"/>
<meta content="تنسيق حدائق منزلية وفلل واستراحات بالرياض: شبكات ري، مظلات وبرجولات، شلالات ونوافير، زهور الفل والياسمين والريحان." name="twitter:description"/>
<meta content="<?= e($logo) ?>" name="twitter:image"/>
<meta content="index, follow, max-image-preview:large" name="robots"/>
<meta content="<?= e(s('meta_keywords', 'تنسيق حدائق الرياض, مشتل الفيروز')) ?>" name="keywords"/>
<meta content="SA-01" name="geo.region"/>
<meta content="الرياض" name="geo.placename"/>
<meta content="ar_SA" property="og:locale"/>
<meta content="<?= e($siteName) ?>" property="og:site_name"/>
<script type="application/ld+json">{"@context": "https://schema.org", "@type": "LocalBusiness", "name": "<?= e($siteName) ?>", "description": "<?= e(s('site_description', 'تصميم وتنفيذ وصيانة الحدائق المنزلية')) ?>", "telephone": "+<?= e($phoneIntl) ?>", "address": {"@type": "PostalAddress", "addressLocality": "الرياض", "addressCountry": "SA"}}</script>
<link href="<?= e($logo) ?>" rel="icon" type="image/jpeg"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&amp;family=Tajawal:wght@400;500;700;800;900&amp;family=Aref+Ruqaa:wght@700&amp;display=swap" rel="stylesheet"/>
<style>
    :root {
      --bg-white: #ffffff;
      --bg-light: #f5f8f3;
      --color-green-dark: #0f3d28;
      --color-green-mid: #147a4b;
      --color-green-bright: #1fa861;
      --color-green-emerald: #0d9d76;
      --color-pink: #e0496b;
      --color-rose: #e57aa2;
      --color-wardy: #ec8093;
      --color-soft-pink: #fff1f2;
      --color-baby-blue: #116da6;
      --color-sky-blue: #4fa9d6;
      --color-soft-blue: #f0f9ff;
      --color-fol: #fffdf0;
      --color-fol-border: #fef08a;
      --color-jasmine: #fef9c3;
      --color-jasmine-glow: #d9a50a;
      --color-rayhan: #3f6212;
      --color-rayhan-light: #65a30d;
      --color-soft-rayhan: #f7fee7;
      --color-floral-orange: #f97316;
      --color-floral-purple: #a855f7;
      --transition-smooth: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    html {
      scroll-behavior: smooth;
      overflow-x: hidden;
      max-width: 100vw;
      width: 100%;
    }
    body {
      font-family: 'Tajawal', 'Cairo', sans-serif;
      background-color: var(--bg-white);
      color: #1f2937;
      line-height: 1.8;
      overflow-x: hidden;
      max-width: 100vw;
      width: 100%;
      position: relative;
      direction: rtl;
      text-align: right;
    }
    section, footer, nav, header {
      width: 100%;
      max-width: 100vw;
      overflow-x: clip;
    }
    img, video, svg, canvas {
      max-width: 100%;
    }
    h1, h2, h3, h4, h5, h6 {
      font-family: 'Cairo', sans-serif;
      font-weight: 800;
    }
    a {
      text-decoration: none;
      transition: var(--transition-smooth);
    }
    .section-padding {
      padding: 90px 0;
      position: relative;
    }
    .stats-green {
      background: linear-gradient(135deg, var(--color-green-dark) 0%, var(--color-green-mid) 100%);
    }
    .section-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 18px;
      border-radius: 50px;
      font-weight: 700;
      font-size: 0.95rem;
      margin-bottom: 16px;
      letter-spacing: 0.5px;
    }
    .badge-green {
      background: #dcfce7;
      color: var(--color-green-dark);
      border: 1px solid #93dcb0;
    }
    .badge-pink {
      background: #ffe4e6;
      color: #be123c;
      border: 1px solid #fecdd3;
    }
    .badge-blue {
      background: var(--color-soft-blue);
      color: var(--color-baby-blue);
      border: 1px solid #bae6fd;
    }
    .badge-jasmine {
      background: var(--color-jasmine);
      color: #854d0e;
      border: 1px solid #fde047;
    }
    .badge-rayhan {
      background: var(--color-soft-rayhan);
      color: var(--color-rayhan);
      border: 1px solid #bef264;
    }
    .section-title {
      font-size: 2.3rem;
      color: var(--color-green-dark);
      margin-bottom: 20px;
      position: relative;
    }
    .section-subtitle {
      font-size: 1.15rem;
      color: #4b5563;
      max-width: 820px;
      margin: 0 auto 50px auto;
    }
    .bg-section-parallax {
      background-attachment: fixed;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      position: relative;
      color: #ffffff;
      padding: 120px 0;
    }
    .bg-overlay-dark {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(20, 83, 45, 0.88), rgba(6, 78, 59, 0.85), rgba(15, 23, 42, 0.86));
      z-index: 1;
    }
    .bg-overlay-rose {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(190, 24, 93, 0.84), rgba(20, 83, 45, 0.88));
      z-index: 1;
    }
    .bg-overlay-blue {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(2, 132, 199, 0.85), rgba(20, 83, 45, 0.88));
      z-index: 1;
    }
    .bg-overlay-jasmine {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(30, 41, 59, 0.9), rgba(113, 63, 18, 0.85), rgba(20, 83, 45, 0.86));
      z-index: 1;
    }
    .bg-overlay-rayhan {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(63, 98, 18, 0.9), rgba(15, 23, 42, 0.88));
      z-index: 1;
    }
    .bg-section-parallax .container {
      position: relative;
      z-index: 2;
    }
    .text-img-box {
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 20px 45px rgba(0, 0, 0, 0.12);
      transition: var(--transition-smooth);
      position: relative;
    }
    .text-img-box img {
      width: 100%;
      height: 480px;
      object-fit: cover;
      display: block;
      transition: transform 0.7s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .text-img-box:hover img {
      transform: scale(1.08) rotate(1deg);
    }
    .navbar-brand img {
      width: 58px;
      height: 58px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #1fa861;
      box-shadow: 0 4px 15px rgba(34, 197, 94, 0.35);
    }
    .navbar-main {
      background: rgba(255, 255, 255, 0.97);
      backdrop-filter: blur(12px);
      box-shadow: 0 4px 25px rgba(0, 0, 0, 0.06);
      transition: var(--transition-smooth);
      padding: 14px 0;
    }
    .nav-link {
      color: #1f2937 !important;
      font-weight: 700;
      font-size: 1.02rem;
      padding: 8px 14px !important;
      border-radius: 8px;
      transition: var(--transition-smooth);
    }
    .nav-link:hover {
      color: #147a4b !important;
      background-color: #f0fdf4;
      transform: translateY(-2px);
    }
    .nav-btn-call {
      background: linear-gradient(135deg, #147a4b, #1fa861);
      color: #ffffff !important;
      border-radius: 50px;
      padding: 10px 24px !important;
      font-weight: 800;
      box-shadow: 0 6px 20px rgba(34, 197, 94, 0.35);
      border: none;
    }
    .nav-btn-call:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 10px 25px rgba(34, 197, 94, 0.5);
      color: #ffffff !important;
    }
    .side-drawer-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(15, 23, 42, 0.7);
      backdrop-filter: blur(6px);
      z-index: 1050;
      opacity: 0;
      visibility: hidden;
      transition: all 0.4s ease;
    }
    .side-drawer-overlay.active {
      opacity: 1;
      visibility: visible;
    }
    .side-drawer {
      position: fixed;
      top: 0;
      right: 0;
      width: min(320px, 85vw);
      height: 100vh;
      background: #ffffff;
      z-index: 1060;
      box-shadow: -10px 0 40px rgba(0, 0, 0, 0.25);
      transition: transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1), visibility 0.35s ease;
      display: flex;
      flex-direction: column;
      overflow-y: auto;
      padding: 24px 20px;
      transform: translate3d(100%, 0, 0);
      visibility: hidden;
    }
    .side-drawer.active {
      transform: translate3d(0, 0, 0);
      visibility: visible;
    }
    .side-drawer-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 2px solid #f1f5f9;
      padding-bottom: 18px;
      margin-bottom: 24px;
    }
    .drawer-close-btn {
      background: #f1f5f9;
      border: none;
      width: 42px;
      height: 42px;
      border-radius: 50%;
      color: #334155;
      font-size: 1.2rem;
      cursor: pointer;
      transition: var(--transition-smooth);
    }
    .drawer-close-btn:hover {
      background: #fee2e2;
      color: #ef4444;
      transform: rotate(90deg);
    }
    .drawer-nav-list {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .drawer-nav-item a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      color: #1e293b;
      font-weight: 700;
      font-size: 1.05rem;
      border-radius: 12px;
      background: #f8fafc;
      transition: var(--transition-smooth);
    }
    .drawer-nav-item a:hover {
      background: #dcfce7;
      color: #147a4b;
      transform: translateX(-6px);
    }
    .drawer-nav-item a i {
      font-size: 1.2rem;
      color: #147a4b;
      width: 24px;
      text-align: center;
    }
    .drawer-contact-box {
      margin-top: auto;
      padding-top: 24px;
      border-top: 2px solid #f1f5f9;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
    .hero-section {
      --nav-h: 86px;
      --hero-gap: 28px;
      position: relative;
      isolation: isolate;
      background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 40%, #fdf2f8 80%, #f0f9ff 100%);
      padding: calc(var(--nav-h) + var(--hero-gap)) 0 0 0;
      overflow: hidden;
    }
    .hero-split {
      position: relative;
      z-index: 4;
      display: grid;
      grid-template-columns: 1fr;
    }
    .hero-media {
      position: relative;
      grid-column: 1;
      grid-row: 1;
    }
    .hero-media::after {
      content: "";
      position: absolute;
      inset: 0;
      pointer-events: none;
      background: linear-gradient(180deg, rgba(5, 46, 22, 0.12) 0%, rgba(5, 46, 22, 0.08) 45%, rgba(5, 46, 22, 0.36) 100%);
    }
    .hero-media img {
      display: block;
      width: 100%;
      height: auto;
      object-fit: cover;
    }
    .hero-actions {
      grid-column: 1;
      grid-row: 1;
      align-self: end;
      position: relative;
      z-index: 2;
      padding: 0 20px 28px 20px;
    }
    .hero-actions .btn-action-main {
      padding: 12px 26px;
      font-size: 1.02rem;
    }
    @media (min-width: 992px) {
      .hero-media img {
        min-height: 480px;
        max-height: calc(100vh - var(--nav-h) - var(--hero-gap));
      }
    }
    @media (max-width: 991.98px) {
      .hero-media::after {
        background: rgba(5, 46, 22, 0.14);
      }
      .hero-actions {
        grid-row: 2;
        align-self: auto;
        padding: 16px 20px 34px 20px;
      }
    }
    .hero-canvas {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 5;
    }
 .hero-content {
      position: relative;
      z-index: 4;
    }
    .hero-logo-frame {
      position: relative;
      width: 380px;
      max-width: 100%;
      margin: 0 auto;
    }
    .hero-logo-img {
      width: 100%;
      height: 380px;
      object-fit: cover;
      border-radius: 36px;
      box-shadow: 0 25px 60px rgba(22, 101, 52, 0.28);
      border: 8px solid #ffffff;
      position: relative;
      z-index: 2;
      animation: floatHero 6s ease-in-out infinite;
    }
    @keyframes floatHero {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-14px) rotate(1deg); }
    }
    .hero-ring-glow {
      position: absolute;
      top: -20px;
      left: -20px;
      right: -20px;
      bottom: -20px;
      border-radius: 44px;
      background: linear-gradient(135deg, #1fa861, #ec4899, #4fa9d6, #d9a50a);
      filter: blur(28px);
      opacity: 0.55;
      z-index: 1;
      animation: pulseGlow 4s ease-in-out infinite alternate;
    }
    @keyframes pulseGlow {
      0% { opacity: 0.35; transform: scale(0.96); }
      100% { opacity: 0.75; transform: scale(1.04); }
    }
    .floating-badge {
      position: absolute;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(8px);
      padding: 12px 20px;
      border-radius: 20px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
      display: flex;
      align-items: center;
      gap: 12px;
      z-index: 3;
      font-weight: 800;
      color: #1f2937;
    }
    .badge-pos-1 {
      bottom: 20px;
      right: -25px;
      border-right: 4px solid #1fa861;
      animation: floatBadge1 5s ease-in-out infinite;
    }
    .badge-pos-2 {
      top: 30px;
      left: -30px;
      border-left: 4px solid #ec4899;
      animation: floatBadge2 6s ease-in-out infinite;
    }
    @keyframes floatBadge1 {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
    @keyframes floatBadge2 {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(12px); }
    }
    .btn-action-main {
      padding: 15px 34px;
      border-radius: 50px;
      font-weight: 800;
      font-size: 1.15rem;
      display: inline-flex;
      align-items: center;
      gap: 12px;
      transition: var(--transition-smooth);
      border: none;
      cursor: pointer;
    }
    .btn-hero-call {
      background: linear-gradient(135deg, #147a4b, #1fa861);
      color: #ffffff;
      box-shadow: 0 10px 30px rgba(34, 197, 94, 0.4);
    }
    .btn-hero-call:hover {
      background: linear-gradient(135deg, #166534, #147a4b);
      transform: translateY(-4px);
      box-shadow: 0 15px 35px rgba(34, 197, 94, 0.55);
      color: #ffffff;
    }
    .btn-hero-wa {
      background: linear-gradient(135deg, #25d366, #128c7e);
      color: #ffffff;
      box-shadow: 0 10px 30px rgba(37, 211, 102, 0.4);
    }
    .btn-hero-wa:hover {
      background: linear-gradient(135deg, #1eb956, #0d7065);
      transform: translateY(-4px);
      box-shadow: 0 15px 35px rgba(37, 211, 102, 0.55);
      color: #ffffff;
    }
    .btn-hero-outline {
      background: #ffffff;
      color: #147a4b;
      border: 2px solid #1fa861;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    }
    .btn-hero-outline:hover {
      background: #f0fdf4;
      color: #0f3d28;
      transform: translateY(-4px);
      border-color: #147a4b;
    }
    .hover-rose-shift {
      background: #ffffff;
      border-radius: 20px;
      border: 1px solid #ffe4e6;
      transition: var(--transition-smooth);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    }
    .hover-rose-shift:hover {
      background: linear-gradient(145deg, #fff1f2, #ffe4e6) !important;
      transform: translateY(-10px) rotate(-1deg);
      border-color: #e0496b;
      box-shadow: 0 20px 40px rgba(244, 63, 94, 0.22);
    }
    .hover-mint-shift {
      background: #ffffff;
      border-radius: 20px;
      border: 1px solid #dcfce7;
      transition: var(--transition-smooth);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    }
    .hover-mint-shift:hover {
      background: linear-gradient(145deg, #f0fdf4, #dcfce7) !important;
      transform: translateY(-10px) scale(1.03);
      border-color: #1fa861;
      box-shadow: 0 20px 40px rgba(34, 197, 94, 0.22);
    }
    .hover-sky-shift {
      background: #ffffff;
      border-radius: 20px;
      border: 1px solid #e0f2fe;
      transition: var(--transition-smooth);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    }
    .hover-sky-shift:hover {
      background: linear-gradient(145deg, #f0f9ff, #e0f2fe) !important;
      transform: translateY(-10px) rotate(1deg);
      border-color: #4fa9d6;
      box-shadow: 0 20px 40px rgba(56, 189, 248, 0.25);
    }
    .hover-jasmine-shift {
      background: #ffffff;
      border-radius: 20px;
      border: 1px solid #fef9c3;
      transition: var(--transition-smooth);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    }
    .hover-jasmine-shift:hover {
      background: linear-gradient(145deg, #fffdf0, #fef9c3) !important;
      transform: translateY(-12px);
      border-color: #d9a50a;
      box-shadow: 0 20px 45px rgba(234, 179, 8, 0.25);
    }
    .hover-rayhan-shift {
      background: #ffffff;
      border-radius: 20px;
      border: 1px solid #ecfccb;
      transition: var(--transition-smooth);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    }
    .hover-rayhan-shift:hover {
      background: linear-gradient(145deg, #f7fee7, #ecfccb) !important;
      transform: translateY(-10px) scale(1.02);
      border-color: #84cc16;
      box-shadow: 0 20px 40px rgba(132, 204, 22, 0.25);
    }
    .hover-purple-shift {
      background: #ffffff;
      border-radius: 20px;
      border: 1px solid #f3e8ff;
      transition: var(--transition-smooth);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    }
    .hover-purple-shift:hover {
      background: linear-gradient(145deg, #faf5ff, #f3e8ff) !important;
      transform: translateY(-10px) rotate(-1deg);
      border-color: #a855f7;
      box-shadow: 0 20px 40px rgba(168, 85, 247, 0.25);
    }
    .hover-bloom {
      transition: var(--transition-smooth);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
    }
    .hover-bloom:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 20px 45px rgba(244, 114, 182, 0.28);
    }
    .hover-glow-blue {
      background: #ffffff;
      border-radius: 20px;
      overflow: hidden;
      border: 1px solid #e0f2fe;
      transition: var(--transition-smooth);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
    }
    .hover-glow-blue:hover {
      background: #f0f9ff !important;
      border-color: #116da6;
      transform: translateY(-8px);
      box-shadow: 0 20px 45px rgba(2, 132, 199, 0.25);
    }
    .interactive-garden-box {
      background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 50%, #fff1f2 100%);
      border-radius: 36px;
      padding: 50px 40px;
      border: 3px solid #bbf7d0;
      box-shadow: 0 25px 60px rgba(22, 101, 52, 0.12);
      position: relative;
      overflow: hidden;
      max-width: 100%;
    }
    .flower-tree-stage {
      display: flex;
      justify-content: space-around;
      align-items: center;
      min-height: 340px;
      position: relative;
      flex-wrap: wrap;
      gap: 24px;
    }
    .interactive-tree-svg, .interactive-flower-svg {
      transition: transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      filter: drop-shadow(0 12px 24px rgba(0,0,0,0.12));
    }
    .interactive-tree-svg:hover {
      transform: scale(1.08) rotate(-2deg);
    }
    .interactive-flower-svg:hover {
      transform: scale(1.12) rotate(8deg);
    }
    .tree-leaf-cluster {
      transition: fill 0.5s ease, transform 0.5s ease;
      transform-origin: center;
    }
    .flower-petal {
      transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      transform-origin: 150px 150px;
    }
    .bloom-active .flower-petal {
      transform: scale(1.22);
    }
    .water-droplets-container {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
    }
    .droplet {
      position: absolute;
      width: 10px;
      height: 16px;
      background: #4fa9d6;
      border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
      animation: dropWater 1.2s ease-in forwards;
    }
    @keyframes dropWater {
      0% { opacity: 1; transform: translateY(0); }
      100% { opacity: 0; transform: translateY(220px); }
    }
    .garden-ctrl-btn {
      padding: 12px 24px;
      border-radius: 50px;
      font-weight: 800;
      font-size: 1rem;
      border: 2px solid transparent;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      transition: var(--transition-smooth);
    }
    .ctrl-btn-water {
      background: #e0f2fe;
      color: #0369a1;
      border-color: #7dd3fc;
    }
    .ctrl-btn-water:hover {
      background: #116da6;
      color: #ffffff;
      transform: translateY(-3px);
    }
    .ctrl-btn-bloom {
      background: #ffe4e6;
      color: #e11d48;
      border-color: #f0aeb9;
    }
    .ctrl-btn-bloom:hover {
      background: #e0496b;
      color: #ffffff;
      transform: translateY(-3px);
    }
    .ctrl-btn-fol {
      background: #fefce8;
      color: #854d0e;
      border-color: #fde047;
    }
    .ctrl-btn-fol:hover {
      background: #d9a50a;
      color: #ffffff;
      transform: translateY(-3px);
    }
    .ctrl-btn-rayhan {
      background: #f7fee7;
      color: #3f6212;
      border-color: #bef264;
    }
    .ctrl-btn-rayhan:hover {
      background: #65a30d;
      color: #ffffff;
      transform: translateY(-3px);
    }
    .portfolio-card {
      position: relative;
      margin-bottom: 30px;
    }
    .portfolio-thumb {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .portfolio-card:hover .portfolio-thumb {
      transform: scale(1.12);
    }
    .portfolio-lightbox {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(10, 20, 15, 0.95);
      backdrop-filter: blur(10px);
      z-index: 2000;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }
    .portfolio-lightbox.active {
      opacity: 1;
      visibility: visible;
    }
    .lightbox-content-wrapper {
      position: relative;
      max-width: 900px;
      width: 100%;
      text-align: center;
    }
    .lightbox-img {
      max-width: 100%;
      max-height: 80vh;
      border-radius: 20px;
      box-shadow: 0 25px 60px rgba(0,0,0,0.5);
      border: 4px solid #ffffff;
    }
    .lightbox-title {
      color: #ffffff;
      font-size: 1.35rem;
      margin-top: 18px;
      font-weight: 800;
    }
    .lightbox-close {
      position: absolute;
      top: -50px;
      left: 0;
      background: #ffffff;
      border: none;
      width: 44px;
      height: 44px;
      border-radius: 50%;
      color: #0f3d28;
      font-size: 1.3rem;
      cursor: pointer;
      transition: var(--transition-smooth);
    }
    .lightbox-close:hover {
      background: #e0496b;
      color: #ffffff;
      transform: rotate(90deg);
    }
    .faq-accordion .accordion-item {
      border: 2px solid #e2e8f0;
      border-radius: 18px !important;
      margin-bottom: 16px;
      overflow: hidden;
      transition: var(--transition-smooth);
    }
    .faq-accordion .accordion-item:hover {
      border-color: #1fa861;
      background: #f0fdf4;
    }
    .faq-accordion .accordion-button {
      font-size: 1.15rem;
      font-weight: 800;
      color: #0f3d28;
      background: #ffffff;
      padding: 22px 26px;
      box-shadow: none;
    }
    .faq-accordion .accordion-button:not(.collapsed) {
      background: #f0fdf4;
      color: #147a4b;
      border-bottom: 2px solid #bbf7d0;
    }
    .faq-accordion .accordion-button::after {
      margin-left: 0;
      margin-right: auto;
    }
    .faq-accordion .accordion-body {
      padding: 24px 26px;
      font-size: 1.05rem;
      color: #334155;
      background: #ffffff;
      line-height: 1.9;
    }
    .step-badge-number {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: linear-gradient(135deg, #147a4b, #1fa861);
      color: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.6rem;
      font-weight: 900;
      margin-bottom: 20px;
      box-shadow: 0 10px 25px rgba(34, 197, 94, 0.35);
      transition: var(--transition-smooth);
    }
    .hover-step:hover .step-badge-number {
      transform: scale(1.15) rotate(360deg);
      background: linear-gradient(135deg, #ec4899, #e0496b);
    }
    .testimonial-card {
      background: #ffffff;
      border-radius: 24px;
      padding: 34px 28px;
      border: 2px solid #f1f5f9;
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.05);
      transition: var(--transition-smooth);
    }
    .testimonial-card:hover {
      transform: translateY(-8px);
      border-color: #e57aa2;
      background: linear-gradient(145deg, #ffffff, #fff1f2);
      box-shadow: 0 20px 45px rgba(244, 114, 182, 0.2);
    }
    .floating-contact-bar {
      position: fixed;
      bottom: 28px;
      left: 28px;
      display: flex;
      flex-direction: column;
      gap: 14px;
      z-index: 1000;
    }
    .float-circle-btn {
      width: 62px;
      height: 62px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      font-size: 1.6rem;
      box-shadow: 0 12px 30px rgba(0,0,0,0.25);
      transition: var(--transition-smooth);
      position: relative;
    }
    .float-wa {
      background: #25d366;
    }
    .float-wa:hover {
      background: #1eb956;
      transform: scale(1.12) rotate(-10deg);
      color: #ffffff;
    }
    .float-call {
      background: #116da6;
    }
    .float-call:hover {
      background: #0369a1;
      transform: scale(1.12) rotate(10deg);
      color: #ffffff;
    }
    .float-scroll-top {
      background: #0f3d28;
      opacity: 0;
      visibility: hidden;
    }
    .float-scroll-top.show {
      opacity: 1;
      visibility: visible;
    }
    .float-scroll-top:hover {
      background: #147a4b;
      transform: translateY(-5px);
      color: #ffffff;
    }
    .pulse-radar {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      border-radius: 50%;
      border: 3px solid currentColor;
      animation: radarWave 2s ease-out infinite;
      pointer-events: none;
    }
    @keyframes radarWave {
      0% { transform: scale(1); opacity: 0.9; }
      100% { transform: scale(1.6); opacity: 0; }
    }
    .footer-section {
      background: #0b1e13;
      color: #cbd5e1;
      padding: 80px 0 30px 0;
      position: relative;
    }
    .footer-logo img {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #1fa861;
      margin-bottom: 16px;
    }
    .footer-link {
      color: #94a3b8;
      transition: var(--transition-smooth);
      display: inline-block;
      margin-bottom: 10px;
      font-size: 1rem;
    }
    .footer-link:hover {
      color: #1fa861;
      transform: translateX(-6px);
    }
    .designer-credit-box {
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      padding-top: 30px;
      margin-top: 50px;
      text-align: center;
    }
    .designer-credit-link {
      color: #4fa9d6;
      font-weight: 800;
      font-size: 1.15rem;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 18px;
      border-radius: 30px;
      background: rgba(56, 189, 248, 0.12);
      border: 1px solid rgba(56, 189, 248, 0.3);
      transition: var(--transition-smooth);
    }
    .designer-credit-link:hover {
      background: #4fa9d6;
      color: #0b1e13 !important;
      transform: translateY(-3px) scale(1.05);
      box-shadow: 0 10px 25px rgba(56, 189, 248, 0.4);
    }
    @media (max-width: 1199.98px) {
      .section-padding {
        padding: 75px 0;
      }
      .hero-logo-frame {
        width: 330px;
      }
      .hero-logo-img {
        height: 330px;
      }
    }
    @media (max-width: 991.98px) {
      .navbar-collapse {
        display: none !important;
      }
      .mobile-toggle-btn {
        display: block !important;
      }
      .section-padding {
        padding: 60px 0;
      }
      .section-title {
        font-size: 1.85rem;
      }
      .section-subtitle {
        font-size: 1.05rem;
        margin-bottom: 35px;
      }
      .bg-section-parallax {
        background-attachment: scroll !important;
        padding: 75px 0;
      }
      .hero-logo-frame {
        width: 290px;
        margin-top: 35px;
      }
      .hero-logo-img {
        height: 290px;
      }
      .text-img-box img {
        height: 320px;
      }
      .floating-contact-bar {
        bottom: 18px;
        left: 18px;
        gap: 10px;
      }
      .float-circle-btn {
        width: 52px;
        height: 52px;
        font-size: 1.35rem;
      }
      .badge-pos-1 {
        right: 0;
        bottom: -10px;
      }
      .badge-pos-2 {
        left: 0;
        top: -10px;
      }
      .floating-badge {
        padding: 8px 14px;
        font-size: 0.82rem;
        gap: 8px;
      }
    }
    @media (max-width: 767.98px) {
      .section-padding {
        padding: 48px 0;
      }
      .section-title {
        font-size: 1.6rem;
      }
      .hero-section {
        padding: 95px 0 45px 0;
      }
      .hero-logo-frame {
        width: 260px;
      }
      .hero-logo-img {
        height: 260px;
        border-width: 6px;
      }
      .btn-action-main {
        width: 100%;
        justify-content: center;
        padding: 12px 20px;
        font-size: 1rem;
      }
      .interactive-garden-box {
        padding: 28px 14px;
      }
      .flower-tree-stage {
        flex-direction: column;
        align-items: center;
      }
      .interactive-tree-svg, .interactive-flower-svg {
        width: 170px;
        height: 200px;
      }
      .garden-ctrl-btn {
        width: 100%;
        justify-content: center;
      }
      .text-img-box img {
        height: 260px;
      }
      .step-badge-number {
        width: 52px;
        height: 52px;
        font-size: 1.35rem;
      }
      .lightbox-close {
        top: -42px;
        left: 5px;
        width: 38px;
        height: 38px;
        font-size: 1.1rem;
      }
    }
    @media (max-width: 575.98px) {
      .section-padding {
        padding: 40px 0;
      }
      .section-title {
        font-size: 1.4rem;
      }
      .display-4 {
        font-size: 1.75rem !important;
      }
      .display-5 {
        font-size: 1.55rem !important;
      }
      .display-6 {
        font-size: 1.35rem !important;
      }
      .lead {
        font-size: 1rem !important;
      }
      .container {
        padding-right: 12px;
        padding-left: 12px;
      }
      .hero-logo-frame {
        width: 220px;
      }
      .hero-logo-img {
        height: 220px;
        border-radius: 26px;
      }
      .floating-contact-bar {
        bottom: 12px;
        left: 12px;
        gap: 8px;
      }
      .float-circle-btn {
        width: 46px;
        height: 46px;
        font-size: 1.18rem;
      }
      .faq-accordion .accordion-button {
        font-size: 0.98rem;
        padding: 15px 16px;
      }
      .faq-accordion .accordion-body {
        padding: 15px 16px;
        font-size: 0.92rem;
      }
      .footer-section {
        padding: 50px 0 25px 0;
      }
    }
    @media (max-width: 375.98px) {
      .hero-logo-frame {
        width: 190px;
      }
      .hero-logo-img {
        height: 190px;
      }
      .interactive-tree-svg, .interactive-flower-svg {
        width: 145px;
        height: 175px;
      }
    }
    @media (min-width: 992px) {
      .mobile-toggle-btn {
        display: none !important;
      }
    }

    /* تحسينات ألوان مشتل الفيروز */
    .btn-success {
      --bs-btn-bg: var(--color-green-mid);
      --bs-btn-border-color: var(--color-green-mid);
      --bs-btn-hover-bg: var(--color-green-dark);
      --bs-btn-hover-border-color: var(--color-green-dark);
      --bs-btn-active-bg: var(--color-green-dark);
      --bs-btn-active-border-color: var(--color-green-dark);
      --bs-btn-disabled-bg: var(--color-green-mid);
      --bs-btn-disabled-border-color: var(--color-green-mid);
    }
    .text-success { color: var(--color-green-mid) !important; }
    .bg-success { background-color: var(--color-green-mid) !important; }
    .btn-outline-success {
      --bs-btn-color: var(--color-green-mid);
      --bs-btn-border-color: var(--color-green-mid);
      --bs-btn-hover-bg: var(--color-green-mid);
      --bs-btn-hover-border-color: var(--color-green-mid);
      --bs-btn-active-bg: var(--color-green-mid);
      --bs-btn-active-border-color: var(--color-green-mid);
    }

    /* الأقسام التفاعلية الجديدة */
    .quiz-question {
      background: #ffffff;
      border: 1px solid #e5efe7;
      border-radius: 18px;
      padding: 24px;
      height: 100%;
      box-shadow: 0 6px 20px rgba(15, 61, 40, 0.05);
    }
    .quiz-chip {
      display: inline-block;
      margin: 4px 2px;
      padding: 9px 18px;
      border-radius: 999px;
      border: 2px solid var(--color-green-mid);
      background: #ffffff;
      color: var(--color-green-dark);
      font-weight: 700;
      font-size: 0.95rem;
      cursor: pointer;
      transition: var(--transition-smooth);
    }
    .quiz-chip:hover { transform: translateY(-2px); }
    .quiz-chip.active {
      background: var(--color-green-mid);
      color: #ffffff;
      box-shadow: 0 6px 16px rgba(20, 122, 75, 0.3);
    }
    .quiz-result {
      display: none;
      max-width: 760px;
      margin: 28px auto 0;
      background: linear-gradient(135deg, var(--color-green-dark), var(--color-green-emerald));
      color: #ffffff;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 15px 40px rgba(15, 61, 40, 0.25);
    }
    .quiz-result.show { display: block; animation: fayrouzFadeUp 0.5s ease; }
    .quiz-result h4 { color: #ffffff; }
    .quiz-result p { color: rgba(255,255,255,0.92); line-height: 2; }
    .quiz-result a { color: #ffffff; }
    @keyframes fayrouzFadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .checkup-item {
      background: #ffffff;
      border: 1px solid #e5efe7;
      border-radius: 14px;
      padding: 14px 16px;
      display: flex;
      align-items: center;
      gap: 12px;
      cursor: pointer;
      transition: var(--transition-smooth);
      height: 100%;
      font-weight: 600;
      color: var(--color-green-dark);
    }
    .checkup-item:hover { border-color: var(--color-green-mid); box-shadow: 0 6px 18px rgba(15, 61, 40, 0.08); }
    .checkup-item input { width: 20px; height: 20px; accent-color: var(--color-green-mid); flex-shrink: 0; }
    .tip-card { perspective: 1100px; height: 240px; cursor: pointer; }
    .tip-card-inner {
      position: relative;
      width: 100%;
      height: 100%;
      transition: transform 0.7s;
      transform-style: preserve-3d;
    }
    .tip-card.flipped .tip-card-inner { transform: rotateY(180deg); }
    .tip-face {
      position: absolute;
      inset: 0;
      backface-visibility: hidden;
      -webkit-backface-visibility: hidden;
      border-radius: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 26px;
      text-align: center;
    }
    .tip-front {
      background: linear-gradient(135deg, var(--color-green-mid), var(--color-green-emerald));
      color: #ffffff;
      box-shadow: 0 12px 30px rgba(15, 61, 40, 0.18);
    }
    .tip-front small { opacity: 0.85; }
    .tip-back {
      background: var(--color-soft-blue);
      color: var(--color-green-dark);
      transform: rotateY(180deg);
      border: 1px solid #d7e9f7;
    }
    .tip-back p { line-height: 1.9; font-size: 0.98rem; }

    /* قسم الخريطة */
    .map-frame-wrapper {
      border-radius: 22px;
      overflow: hidden;
      border: 6px solid #ffffff;
    }
    .map-frame-wrapper iframe {
      display: block;
      width: 100%;
      height: 430px;
    }
    @media (max-width: 576px) {
      .map-frame-wrapper iframe { height: 320px; }
      .tip-card { height: 260px; }
    }

    /* شريحة الأحياء */
    .district-chip {
      background: var(--color-soft-rayhan);
      color: var(--color-rayhan);
      border: 1px solid #d9f99d;
      border-radius: 999px;
      padding: 5px 14px;
      font-weight: 700;
      font-size: 0.85rem;
    }
  </style>
<style>
:root{--color-green-dark:#123f3e;--color-green-mid:#1d7168;--color-green-bright:#33948a;--color-green-emerald:#277f75;--color-pink:#a7714b;--color-rose:#bd9476;--color-wardy:#b6815e;--color-soft-pink:#f5eee6;--color-baby-blue:#327e87;--color-sky-blue:#79a7ac;--color-soft-blue:#edf4f3;--color-jasmine:#f1e6cd;--color-jasmine-glow:#b08949}
body{background:#fafbf7;color:#203d39}.section-padding{padding-top:76px;padding-bottom:76px}section{scroll-margin-top:105px}.section-title{color:#153f3c!important}.section-badge{letter-spacing:0;background:#e8f1eb!important;color:#215f56!important}.bg-light{background:#f4f6f0!important}.text-danger,.text-primary,.text-warning{color:#8a613d!important}.bg-section-parallax{background-color:#163e39;background-blend-mode:multiply}.hover-rose-shift,.hover-sky-shift,.hover-jasmine-shift{border-color:#dbe7dd!important}.hero-media{min-height:380px;background:linear-gradient(120deg,#113e3b,#2f7161)}.hero-media img{min-height:380px;object-fit:cover}.hero-copy{position:absolute;z-index:2;inset:20% 7% auto;max-width:660px;color:white;text-shadow:0 2px 15px #102d26}.hero-copy h1{font-size:clamp(2rem,5vw,4.2rem);font-weight:900;line-height:1.5}.hero-copy p{font-size:1.15rem;line-height:1.9}.hero-media:after{background:linear-gradient(90deg,rgba(5,35,29,.3),rgba(5,35,29,.78))}.hero-actions{z-index:3}.hero-canvas{display:none}.missing-image{display:flex;align-items:center;justify-content:center;min-height:220px;background:#e6ece3;color:#355d50;text-align:center;padding:24px;font-weight:700}.media-note{font-size:.85rem;background:#edf2e8;border-radius:10px;padding:12px 18px;color:#355443;margin:16px 0}.quiz-result:focus{outline:2px solid #b08949;outline-offset:4px}:focus-visible{outline:3px solid #b08949!important;outline-offset:4px}.tip-front{background:linear-gradient(130deg,#184e47,#30786a)}.tip-card{border:0}.tip-back{background:#edf3e9}.footer-section .text-secondary{color:#b7c7bd!important}.footer-section .text-success{color:#a8cdbc!important}.floating-contact-bar{bottom:18px;left:14px}.float-circle-btn{width:48px;height:48px}.pulse-radar{display:none}
@media(max-width:575px){.section-padding{padding-top:50px;padding-bottom:50px}.hero-media,.hero-media img{min-height:350px}.hero-copy{inset:14% 7% auto}.hero-copy p{font-size:1rem}.hero-actions .btn-action-main{font-size:.9rem;padding:11px 16px}.section-title{font-size:1.7rem!important}.quiz-question{padding:20px}.quiz-result{padding:22px}.navbar-brand{gap:8px!important}.navbar-brand img{width:42px;height:42px}.navbar-brand .fs-5{font-size:1.05rem!important}.floating-contact-bar{left:9px}.float-circle-btn{width:43px;height:43px}}
@media(prefers-reduced-motion:reduce){*,*:before,*:after{animation:none!important;transition:none!important;scroll-behavior:auto!important}}
</style><style>.navbar-main .nav-link{font-size:.92rem;padding:8px 9px!important;white-space:nowrap}.nav-btn-call{padding:10px 16px!important;white-space:nowrap}.navbar-brand{margin-left:16px}.hero-media>.missing-image{display:none}.text-img-box>.missing-image{height:480px}.hero-media img{position:relative}.hero-copy{pointer-events:none}.tip-back{overflow:auto}.quiz-chip{transition:background .2s,color .2s}.district-chip{background:#eaf1e5;border-color:#cdddc4;color:#31593c}</style><style>.navbar-brand>.missing-image,.footer-logo>.missing-image,.side-drawer-header .missing-image{display:none!important}.navbar-main{min-height:78px}.navbar-main .container{flex-wrap:nowrap}.navbar-brand{flex-shrink:1;min-width:0}.navbar-brand>div{min-width:0}.navbar-main .mobile-toggle-btn{flex-shrink:0}.hero-section{padding-top:100px}@media(max-width:991px){.navbar-main{min-height:78px}.hero-section{padding-top:92px}}</style><style>
/* navbar */
.navbar-main{background:linear-gradient(100deg,#0f3d28 0%,#147a4b 28%,#0b7a6a 58%,#116da6 100%);box-shadow:0 4px 22px rgba(8,32,24,.28)}
.navbar-main .navbar-brand span,.navbar-main .navbar-brand small{color:#fff!important}
.navbar-main .navbar-brand small{opacity:.85}
.navbar-main .navbar-brand img{border-color:#fff;box-shadow:0 2px 10px rgba(0,0,0,.25)}
.navbar-main .nav-link{color:#fff!important}
.navbar-main .nav-link:hover{color:#fff!important;background:rgba(255,255,255,.18)}
.navbar-main .nav-btn-call{background:rgba(255,255,255,.18);color:#fff!important;border:1.5px solid rgba(255,255,255,.7);box-shadow:none}
.navbar-main .nav-btn-call:hover{background:rgba(255,255,255,.3);color:#fff!important;box-shadow:none}
.navbar-main .mobile-toggle-btn{background:rgba(255,255,255,.16)!important;border-color:rgba(255,255,255,.45)!important}
.navbar-main .mobile-toggle-btn i{color:#fff!important}
/* navbar: even spacing (same gap between brand, links and call button; same padding on every link) */
@media(min-width:992px){
.navbar-main{--nav-gap:16px;--nav-pad:9px;padding:14px 0}
.navbar-main .container{display:flex;align-items:center;justify-content:space-between;gap:var(--nav-gap)}
.navbar-main .navbar-brand{margin:0!important}
.navbar-main .navbar-collapse{display:flex!important;flex:1 1 auto;align-items:center;justify-content:space-between;gap:var(--nav-gap)}
.navbar-main .navbar-nav{margin:0!important;flex:1 1 auto;justify-content:center;gap:2px!important}
.navbar-main .navbar-collapse>div{margin:0!important}
.navbar-main .nav-link{padding:8px var(--nav-pad)!important}
.navbar-main .nav-btn-call{padding:10px 18px!important}
}
@media(min-width:1200px){.navbar-main{--nav-gap:24px;--nav-pad:12px}}
/* hero */
.hero-media{display:flex;align-items:center;min-height:clamp(520px,calc(100svh - 100px),760px);padding:56px 7% 130px}
.hero-media>img{position:absolute;inset:0;width:100%;height:100%;min-height:0;max-height:none;object-fit:cover}
.hero-media::after,.hero-media:after{background:linear-gradient(270deg,rgba(8,32,24,.84) 0%,rgba(8,32,24,.58) 48%,rgba(8,32,24,.12) 100%)}
.hero-copy{position:relative;inset:auto;max-width:640px}
.hero-copy h1{font-family:'Aref Ruqaa','Cairo',serif;font-weight:700;font-size:clamp(2.6rem,6.2vw,5rem);line-height:1.3;margin-bottom:14px}
.hero-copy .hero-lead{font-size:1.3rem;font-weight:700;line-height:1.7;margin-bottom:12px}
.hero-copy .hero-body{font-size:1.08rem;line-height:2;max-width:56ch;color:rgba(255,255,255,.92);margin-bottom:18px}
.hero-copy .hero-areas{font-size:.95rem;line-height:1.8;color:rgba(255,255,255,.82);margin:0}
.hero-areas i{margin-inline-end:8px;color:#9be3bd}
.hero-actions{padding:0 7% 36px}
.hero-actions .d-flex{justify-content:flex-start!important}
@media(max-width:991.98px){.hero-media{min-height:480px;padding:40px 6% 44px}.hero-media::after,.hero-media:after{background:rgba(8,32,24,.62)}.hero-actions{padding:18px 6% 34px}}
@media(max-width:575px){.hero-copy .hero-lead{font-size:1.1rem}.hero-copy .hero-body{font-size:1rem}}
/* hero sits directly under the fixed navbar (no gap) */
.hero-section{padding:0}
.hero-media{padding-top:calc(var(--nav-h) + 40px);min-height:clamp(560px,100svh,800px)}
@media(max-width:991.98px){.hero-media{min-height:520px}}
/* portfolio */
#portfolioGrid,#momentsGrid{--bs-gutter-x:.9rem;--bs-gutter-y:.9rem}
.portfolio-card{display:block;width:100%;margin:0;padding:0;border:0;position:relative;overflow:hidden;border-radius:14px;aspect-ratio:4/3;background:#e8eee7;cursor:zoom-in}
.portfolio-card .portfolio-thumb{display:block;width:100%;height:100%;object-fit:cover;transition:transform .5s ease}
.portfolio-card:hover .portfolio-thumb{transform:scale(1.05)}
.portfolio-card::after{content:"\f00e";font-family:"Font Awesome 6 Free";font-weight:900;position:absolute;inset-block-end:12px;inset-inline-start:12px;width:38px;height:38px;border-radius:50%;display:grid;place-items:center;background:rgba(255,255,255,.94);color:#0f3d28;opacity:0;transform:translateY(6px);transition:opacity .25s,transform .25s}
.portfolio-card:hover::after,.portfolio-card:focus-visible::after{opacity:1;transform:none}
@media(min-width:992px){.col-fifth{flex:0 0 auto;width:20%}}
/* lightbox */
.lightbox-nav{position:fixed;top:50%;transform:translateY(-50%);width:46px;height:46px;border:0;border-radius:50%;background:rgba(255,255,255,.14);color:#fff;display:grid;place-items:center;cursor:pointer;z-index:2001;transition:background .2s}
.lightbox-nav:hover{background:rgba(255,255,255,.3)}
.lightbox-prev{right:18px}.lightbox-next{left:18px}
@media(max-width:575px){.lightbox-nav{width:38px;height:38px;top:auto;bottom:22px;transform:none}.lightbox-prev{right:calc(50% + 50px)}.lightbox-next{left:calc(50% + 50px)}}
</style>
</head>