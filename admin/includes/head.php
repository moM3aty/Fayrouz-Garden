<?php
// admin/includes/head.php 
if (!defined('ADMIN_PANEL')) define('ADMIN_PANEL', true);
$admin  = currentAdmin();
$pageTitle = $pageTitle ?? 'لوحة التحكم';
$activeMenu = $activeMenu ?? '';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($pageTitle) ?> | مشتل الفيروز</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

<style>
/* ============================================
   MODERN ADMIN PANEL — 2025 EDITION
   ============================================ */
:root {
  --bg-body: #f4f6f9;
  --bg-white: #ffffff;
  --bg-light: #f5f8f3;
  --color-green-dark: #0f3d28;
  --color-green-mid: #147a4b;
  --color-green-bright: #1fa861;
  --color-green-emerald: #0d9d76;
  --color-pink: #e0496b;
  --color-rose: #e57aa2;
  --color-baby-blue: #116da6;
  --color-sky-blue: #4fa9d6;
  --color-soft-blue: #f0f9ff;
  --color-jasmine: #fef9c3;
  --color-jasmine-glow: #d9a50a;
  --color-soft-rayhan: #f7fee7;
  --text-main: #1e293b;
  --text-muted: #64748b;
  --border-soft: #e8eef3;
  --sidebar-w: 280px;
  --radius-xs: 8px;
  --radius-sm: 12px;
  --radius-md: 16px;
  --radius-lg: 20px;
  --radius-xl: 24px;
  --transition: all .3s cubic-bezier(.4,0,.2,1);
  --shadow-xs: 0 1px 3px rgba(15,61,40,.04);
  --shadow-sm: 0 2px 8px rgba(15,61,40,.06);
  --shadow-md: 0 4px 16px rgba(15,61,40,.08);
  --shadow-lg: 0 10px 32px rgba(15,61,40,.1);
  --shadow-xl: 0 20px 48px rgba(15,61,40,.14);
  --grad-green: linear-gradient(135deg, #147a4b, #1fa861);
  --grad-pink: linear-gradient(135deg, #e0496b, #ec8093);
  --grad-blue: linear-gradient(135deg, #116da6, #4fa9d6);
  --grad-jasmine: linear-gradient(135deg, #d9a50a, #fde047);
  --grad-dark: linear-gradient(135deg, #0f3d28, #1a5a3a);
}

* { box-sizing: border-box; outline: none; }
html { font-size: 14.5px; scroll-behavior: smooth; }
body {
  font-family: 'Tajawal', 'Cairo', sans-serif;
  background: var(--bg-body);
  color: var(--text-main);
  margin: 0; min-height: 100vh;
  overflow-x: hidden;
  -webkit-font-smoothing: antialiased;
}
h1,h2,h3,h4,h5,h6 { font-family: 'Cairo', sans-serif; font-weight: 800; }
a { text-decoration: none; color: inherit; transition: var(--transition); }

::-webkit-scrollbar { width: 8px; height: 8px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
::-webkit-scrollbar-thumb:hover { background: var(--color-green-bright); }

/* ============================================
   SIDEBAR
   ============================================ */
.sidebar {
  position: fixed; top: 0; right: 0; bottom: 0; width: var(--sidebar-w);
  background: linear-gradient(180deg, #0a2f1f 0%, #0f3d28 45%, #061a10 100%);
  color: #fff; z-index: 1050;
  display: flex; flex-direction: column;
  box-shadow: -8px 0 40px rgba(0,0,0,.15);
  transition: transform .35s cubic-bezier(.4,0,.2,1);
  overflow: hidden;
}
.sidebar::before {
  content: ''; position: absolute; top: -100px; right: -100px;
  width: 300px; height: 300px;
  background: radial-gradient(circle, rgba(31,168,97,.25), transparent 70%);
  border-radius: 50%; pointer-events: none; filter: blur(40px);
}
.sidebar::after {
  content: ''; position: absolute; bottom: -80px; left: -80px;
  width: 240px; height: 240px;
  background: radial-gradient(circle, rgba(224,73,107,.15), transparent 70%);
  border-radius: 50%; pointer-events: none; filter: blur(40px);
}
.sb-brand {
  height: 84px; padding: 0 24px;
  display: flex; align-items: center; gap: 14px;
  border-bottom: 1px solid rgba(255,255,255,.08);
  background: rgba(0,0,0,.2);
  position: relative; z-index: 2;
  backdrop-filter: blur(10px);
}
.sb-brand img {
  width: 48px; height: 48px; border-radius: 14px;
  border: 2px solid var(--color-green-bright); object-fit: cover;
  box-shadow: 0 4px 16px rgba(31,168,97,.5);
}
.sb-brand h1 {
  font-size: 1.05rem; font-weight: 900; margin: 0; color: #fff;
  letter-spacing: -.3px;
}
.sb-brand small {
  display: block; font-size: .72rem; color: #9be3bd;
  font-weight: 700; margin-top: 3px;
  display: flex; align-items: center; gap: 5px;
}
.sb-brand small::before {
  content: ''; width: 6px; height: 6px;
  background: var(--color-green-bright); border-radius: 50%;
  box-shadow: 0 0 0 3px rgba(31,168,97,.3);
  animation: pulse 2s infinite;
}
@keyframes pulse {
  0%,100% { box-shadow: 0 0 0 3px rgba(31,168,97,.3); }
  50% { box-shadow: 0 0 0 6px rgba(31,168,97,.1); }
}

.sb-nav {
  padding: 18px 14px; flex: 1; overflow-y: auto;
  position: relative; z-index: 2;
}
.sb-nav::-webkit-scrollbar { width: 4px; }
.sb-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 4px; }
.sb-section {
  font-size: .7rem; font-weight: 900; color: rgba(255,255,255,.35);
  text-transform: uppercase; padding: 20px 16px 10px;
  letter-spacing: 1.2px;
  display: flex; align-items: center; gap: 8px;
}
.sb-section::after {
  content: ''; flex: 1; height: 1px;
  background: linear-gradient(90deg, rgba(255,255,255,.1), transparent);
}
.sb-link {
  display: flex; align-items: center; gap: 12px;
  padding: 11px 14px; margin-bottom: 3px;
  border-radius: 12px; color: #a7d9be;
  font-weight: 700; font-size: .92rem;
  position: relative; overflow: hidden;
  transition: var(--transition);
}
.sb-link::before {
  content: ''; position: absolute; inset: 0;
  background: linear-gradient(90deg, rgba(31,168,97,.2), transparent);
  opacity: 0; transition: .3s;
  border-radius: 12px;
}
.sb-link i {
  width: 22px; text-align: center; font-size: 1rem;
  transition: .3s; opacity: .85;
  position: relative; z-index: 1;
}
.sb-link span { position: relative; z-index: 1; flex: 1; }
.sb-link:hover {
  color: #fff; transform: translateX(-4px);
  background: rgba(255,255,255,.06);
}
.sb-link:hover i { opacity: 1; transform: scale(1.15); color: var(--color-green-bright); }
.sb-link.active {
  background: linear-gradient(90deg, rgba(31,168,97,.3), rgba(31,168,97,.08));
  color: #fff;
  box-shadow: inset 3px 0 0 var(--color-green-bright);
}
.sb-link.active i { color: var(--color-green-bright); opacity: 1; }
.sb-badge {
  background: var(--color-pink); color: #fff;
  font-size: .65rem; font-weight: 900;
  padding: 2px 8px; border-radius: 20px;
  min-width: 22px; text-align: center;
  animation: pulseBadge 2s infinite;
  position: relative; z-index: 1;
}
@keyframes pulseBadge {
  0%,100% { transform: scale(1); }
  50% { transform: scale(1.1); }
}

.sb-footer {
  padding: 16px; border-top: 1px solid rgba(255,255,255,.08);
  background: rgba(0,0,0,.25);
  position: relative; z-index: 2;
  backdrop-filter: blur(10px);
}
.user-card {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 12px; padding: 12px;
  border-radius: 14px;
  background: rgba(255,255,255,.06);
  border: 1px solid rgba(255,255,255,.08);
}
.user-avatar {
  width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
  background: var(--grad-green);
  display: grid; place-items: center;
  font-weight: 900; color: #fff;
  font-family: 'Cairo'; font-size: 1.15rem;
  box-shadow: 0 6px 16px rgba(31,168,97,.5);
}
.user-info { min-width: 0; flex: 1; }
.user-info strong {
  display: block; font-size: .88rem; font-weight: 800; color: #fff;
  overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.user-info small {
  color: #9be3bd; font-size: .72rem; font-weight: 700;
  display: flex; align-items: center; gap: 5px;
}
.user-info small::before {
  content: ''; width: 6px; height: 6px;
  background: var(--color-green-bright); border-radius: 50%;
}
.btn-logout {
  width: 100%; display: flex; align-items: center; justify-content: center;
  gap: 8px; padding: 11px; border-radius: 11px;
  border: 1px solid rgba(224,73,107,.3);
  color: var(--color-rose);
  background: rgba(224,73,107,.1);
  font-weight: 800; font-size: .88rem;
  cursor: pointer; transition: var(--transition);
  font-family: inherit;
}
.btn-logout:hover {
  background: var(--color-pink); color: #fff;
  border-color: var(--color-pink);
  transform: translateY(-1px);
  box-shadow: 0 6px 16px rgba(224,73,107,.4);
}

/* ============================================
   MAIN LAYOUT
   ============================================ */
.main-wrap {
  margin-right: var(--sidebar-w);
  min-height: 100vh;
  display: flex; flex-direction: column;
  transition: margin .35s ease;
}
.topbar {
  height: 76px;
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 32px;
  background: rgba(255,255,255,.85);
  backdrop-filter: blur(20px) saturate(180%);
  border-bottom: 1px solid var(--border-soft);
  position: sticky; top: 0; z-index: 900;
  box-shadow: 0 4px 20px rgba(0,0,0,.02);
}
.tb-left { display: flex; align-items: center; gap: 14px; }
.tb-breadcrumb {
  display: flex; align-items: center; gap: 8px;
  font-size: .78rem; color: var(--text-muted);
  font-weight: 700; margin-bottom: 2px;
}
.tb-breadcrumb a { color: var(--color-green-mid); }
.tb-breadcrumb a:hover { color: var(--color-green-bright); }
.tb-title {
  font-size: 1.3rem; color: var(--color-green-dark);
  margin: 0; font-weight: 900; letter-spacing: -.4px;
}
.tb-actions { display: flex; align-items: center; gap: 10px; }
.tb-btn {
  height: 42px; padding: 0 20px; border-radius: 50px;
  background: var(--grad-green); color: #fff;
  font-weight: 800; font-size: .88rem;
  display: inline-flex; align-items: center; gap: 8px;
  box-shadow: 0 8px 20px rgba(31,168,97,.3);
  font-family: 'Cairo'; cursor: pointer; border: none;
  transition: var(--transition);
}
.tb-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 28px rgba(31,168,97,.4);
  color: #fff;
}
.tb-icon-btn {
  width: 42px; height: 42px; border-radius: 12px;
  background: #fff; border: 1px solid var(--border-soft);
  color: var(--color-green-dark);
  display: grid; place-items: center;
  cursor: pointer; position: relative;
  transition: var(--transition); font-size: 1rem;
}
.tb-icon-btn:hover {
  background: var(--color-soft-rayhan);
  border-color: var(--color-green-bright);
  color: var(--color-green-bright);
  transform: translateY(-2px);
}
.tb-icon-btn .dot {
  position: absolute; top: 10px; left: 10px;
  width: 8px; height: 8px;
  background: var(--color-pink); border-radius: 50%;
  border: 2px solid #fff;
}

.content {
  padding: 32px; flex: 1;
  max-width: 1500px; margin: 0 auto; width: 100%;
  animation: fadeInPage .5s ease;
}
@keyframes fadeInPage {
  from { opacity: 0; transform: translateY(8px); }
  to { opacity: 1; transform: none; }
}

/* ============================================
   FILTER BAR
   ============================================ */
.f-filter-bar {
  background: #fff;
  border: 1px solid var(--border-soft);
  border-radius: var(--radius-md);
  padding: 16px; margin-bottom: 20px;
  display: flex; gap: 12px; flex-wrap: wrap; align-items: center;
  box-shadow: var(--shadow-sm);
}
.f-search { flex: 1; min-width: 220px; position: relative; }
.f-search i {
  position: absolute; right: 16px; top: 50%;
  transform: translateY(-50%); color: var(--text-muted); opacity: .6;
}
.f-search input {
  width: 100%; padding: 12px 44px 12px 16px;
  border: 2px solid var(--border-soft); border-radius: 12px;
  font-family: inherit; font-size: .92rem;
  background: var(--bg-body); transition: var(--transition);
}
.f-search input:focus {
  border-color: var(--color-green-bright);
  background: #fff;
  box-shadow: 0 0 0 4px rgba(31,168,97,.1);
}
.f-chip {
  padding: 10px 18px; border-radius: 50px;
  border: 2px solid var(--border-soft); background: #fff;
  font-family: inherit; font-weight: 800; font-size: .85rem;
  cursor: pointer; color: var(--text-muted);
  transition: var(--transition);
  display: inline-flex; align-items: center; gap: 6px;
}
.f-chip:hover {
  border-color: var(--color-green-bright);
  color: var(--color-green-dark);
  transform: translateY(-2px);
}
.f-chip.active {
  background: var(--grad-green); color: #fff;
  border-color: transparent;
  box-shadow: 0 6px 16px rgba(31,168,97,.3);
}
.f-chip .count {
  background: rgba(255,255,255,.25);
  padding: 1px 8px; border-radius: 10px;
  font-size: .72rem;
}
.f-chip:not(.active) .count {
  background: var(--bg-body); color: var(--color-green-dark);
}

/* ============================================
   PANELS & CARDS
   ============================================ */
.f-panel {
  background: #fff;
  border: 1px solid var(--border-soft);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-sm);
  overflow: hidden; margin-bottom: 24px;
  transition: var(--transition);
}
.f-panel:hover {
  border-color: rgba(31,168,97,.2);
  box-shadow: var(--shadow-md);
}
.panel-head {
  padding: 20px 24px;
  border-bottom: 1px solid var(--border-soft);
  display: flex; justify-content: space-between; align-items: center;
  background: linear-gradient(180deg, #fafbfc, #f5f8f3);
}
.panel-head h2 {
  font-size: 1.05rem; color: var(--color-green-dark);
  margin: 0; display: flex; align-items: center; gap: 10px;
  font-weight: 900;
}
.panel-head h2 i {
  width: 32px; height: 32px; border-radius: 10px;
  background: var(--grad-green); color: #fff;
  display: grid; place-items: center; font-size: .85rem;
}

.form-card, .h-card {
  background: #fff;
  border-radius: var(--radius-md);
  border: 1px solid var(--border-soft);
  padding: 28px; margin-bottom: 22px;
  box-shadow: var(--shadow-sm);
  transition: var(--transition);
  position: relative;
  overflow: hidden;
}
.form-card::before, .h-card::before {
  content: ''; position: absolute; top: 0; left: 0; right: 0;
  height: 3px;
  background: var(--grad-green);
  opacity: 0; transition: opacity .3s;
}
.form-card:hover::before, .h-card:hover::before { opacity: 1; }
.form-card:hover, .h-card:hover {
  border-color: rgba(31,168,97,.25);
  box-shadow: var(--shadow-md);
  transform: translateY(-1px);
}
.form-card h3, .h-card h3 {
  font-size: 1.05rem; font-weight: 900;
  color: var(--color-green-dark);
  margin: 0 0 22px; padding-bottom: 16px;
  border-bottom: 2px solid var(--color-soft-rayhan);
  display: flex; align-items: center; gap: 12px;
}
.form-card h3 i, .h-card h3 i {
  width: 36px; height: 36px; border-radius: 10px;
  background: var(--grad-green); color: #fff;
  display: grid; place-items: center; font-size: .9rem;
  box-shadow: 0 4px 12px rgba(31,168,97,.3);
}

/* ============================================
   TABLE
   ============================================ */
.f-table { width: 100%; border-collapse: collapse; text-align: right; }
.f-table th {
  background: #fafbfc; padding: 14px 20px;
  font-size: .78rem; font-weight: 900;
  color: var(--text-muted);
  border-bottom: 2px solid var(--border-soft);
  text-transform: uppercase; letter-spacing: .5px;
}
.f-table td {
  padding: 16px 20px; font-size: .92rem;
  color: var(--text-main);
  border-bottom: 1px solid var(--border-soft);
  font-weight: 600; vertical-align: middle;
}
.f-table tr:last-child td { border-bottom: none; }
.f-table tbody tr { transition: var(--transition); }
.f-table tbody tr:hover {
  background: var(--color-soft-rayhan);
  box-shadow: inset 4px 0 0 var(--color-green-bright);
}

/* ============================================
   BUTTONS
   ============================================ */
.btn-primary-c {
  background: var(--grad-green); color: #fff; border: none;
  padding: 12px 24px; border-radius: 12px;
  font-family: 'Cairo'; font-weight: 800; font-size: .9rem;
  cursor: pointer; transition: var(--transition);
  display: inline-flex; align-items: center; gap: 8px;
  box-shadow: 0 6px 18px rgba(31,168,97,.3);
}
.btn-primary-c:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 26px rgba(31,168,97,.45);
  color: #fff;
}
.btn-icon {
  width: 38px; height: 38px; border-radius: 10px; border: none;
  cursor: pointer; display: grid; place-items: center;
  font-size: .85rem; transition: var(--transition);
}
.btn-icon:hover { transform: translateY(-2px) scale(1.05); }
.btn-edit { background: var(--color-soft-blue); color: var(--color-baby-blue); }
.btn-edit:hover { background: var(--color-baby-blue); color: #fff; box-shadow: 0 6px 14px rgba(17,109,166,.4); }
.btn-del { background: #fff1f2; color: var(--color-pink); }
.btn-del:hover { background: var(--color-pink); color: #fff; box-shadow: 0 6px 14px rgba(224,73,107,.4); }
.btn-toggle-on { background: var(--color-soft-rayhan); color: var(--color-green-mid); }
.btn-toggle-on:hover { background: var(--color-green-mid); color: #fff; }
.btn-toggle-off { background: #fef2f2; color: #b91c1c; }
.btn-toggle-off:hover { background: #b91c1c; color: #fff; }

/* ============================================
   FORM INPUTS
   ============================================ */
.f-label {
  display: block; font-weight: 800;
  color: var(--color-green-dark);
  font-size: .85rem; margin-bottom: 8px;
  display: flex; align-items: center; gap: 6px;
}
.f-label::before {
  content: ''; width: 3px; height: 14px;
  background: var(--grad-green); border-radius: 2px;
}
.f-input, .f-textarea, .f-select {
  width: 100%; padding: 12px 16px;
  border: 2px solid #e2e8f0; border-radius: 12px;
  font-family: inherit; font-size: .93rem;
  background: #f8fafc;
  transition: var(--transition);
  color: var(--text-main);
}
.f-input:focus, .f-textarea:focus, .f-select:focus {
  outline: none;
  border-color: var(--color-green-bright);
  background: #fff;
  box-shadow: 0 0 0 4px rgba(31,168,97,.1);
}
.f-textarea { min-height: 100px; resize: vertical; line-height: 1.7; }
.f-select {
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='3'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: left 16px center;
  padding-left: 44px;
}

/* ============================================
   TOGGLE SWITCH
   ============================================ */
.switch { position: relative; display: inline-block; width: 52px; height: 28px; }
.switch input { opacity: 0; width: 0; height: 0; }
.slider {
  position: absolute; cursor: pointer; inset: 0;
  background: #cbd5e1; border-radius: 30px;
  transition: .3s;
}
.slider:before {
  position: absolute; content: "";
  height: 22px; width: 22px; left: 3px; bottom: 3px;
  background: #fff; border-radius: 50%;
  transition: .3s;
  box-shadow: 0 2px 4px rgba(0,0,0,.2);
}
.switch input:checked + .slider { background: var(--grad-green); }
.switch input:checked + .slider:before { transform: translateX(24px); }

/* ============================================
   IMAGE UPLOADER (NEW!)
   ============================================ */
.img-uploader {
  border: 2px dashed #cbd5e1;
  border-radius: var(--radius-md);
  padding: 20px; background: #fafbfc;
  transition: var(--transition);
  position: relative;
}
.img-uploader.has-image {
  border-style: solid;
  border-color: var(--color-green-bright);
  background: #fff;
  padding: 16px;
}
.img-uploader.dragover {
  border-color: var(--color-green-bright);
  background: var(--color-soft-rayhan);
  transform: scale(1.01);
  box-shadow: 0 0 0 4px rgba(31,168,97,.1);
}
.uploader-drop {
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  gap: 8px; cursor: pointer;
  padding: 20px;
}
.uploader-drop i {
  font-size: 2.5rem;
  background: var(--grad-green);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  transition: transform .3s;
}
.img-uploader:hover .uploader-drop i { transform: scale(1.1) translateY(-3px); }
.uploader-drop p {
  margin: 0; font-weight: 800;
  color: var(--color-green-dark); font-size: .95rem;
}
.uploader-drop small {
  color: var(--text-muted); font-size: .78rem;
}
.uploader-preview {
  display: flex; gap: 16px; align-items: center;
}
.uploader-preview img {
  width: 100px; height: 100px;
  border-radius: 12px; object-fit: cover;
  border: 3px solid #fff;
  box-shadow: 0 6px 20px rgba(0,0,0,.15);
  transition: var(--transition);
}
.uploader-preview img:hover {
  transform: scale(1.05);
  box-shadow: 0 10px 28px rgba(0,0,0,.2);
}
.uploader-meta { flex: 1; min-width: 0; }
.uploader-meta strong {
  display: block; font-size: .85rem;
  color: var(--color-green-dark);
  font-weight: 900; margin-bottom: 4px;
}
.uploader-meta code {
  font-size: .7rem; color: var(--text-muted);
  background: #fff; padding: 4px 10px;
  border-radius: 6px; word-break: break-all;
  display: inline-block; direction: ltr;
  border: 1px solid var(--border-soft);
  max-width: 100%;
}
.uploader-actions {
  display: flex; gap: 8px; margin-top: 12px;
}
.uploader-btn {
  padding: 8px 14px; border-radius: 8px;
  border: none; cursor: pointer;
  font-family: inherit; font-weight: 800; font-size: .8rem;
  display: inline-flex; align-items: center; gap: 6px;
  transition: var(--transition);
}
.uploader-btn-change {
  background: var(--color-soft-blue);
  color: var(--color-baby-blue);
}
.uploader-btn-change:hover {
  background: var(--color-baby-blue);
  color: #fff;
}
.uploader-btn-remove {
  background: #fff1f2;
  color: var(--color-pink);
}
.uploader-btn-remove:hover {
  background: var(--color-pink);
  color: #fff;
}

/* ============================================
   ICON PICKER
   ============================================ */
.icon-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(48px, 1fr));
  gap: 8px; padding: 14px;
  background: #fafbfc;
  border-radius: 12px;
  border: 1px solid var(--border-soft);
  max-height: 240px; overflow-y: auto;
}
.icon-option {
  aspect-ratio: 1; border-radius: 10px;
  background: #fff; border: 2px solid transparent;
  display: grid; place-items: center;
  cursor: pointer; transition: var(--transition);
  color: var(--text-muted); font-size: 1.05rem;
}
.icon-option:hover {
  transform: scale(1.08);
  border-color: var(--color-green-bright);
  color: var(--color-green-dark);
}
.icon-option.active {
  background: var(--grad-green);
  color: #fff; border-color: transparent;
  box-shadow: 0 4px 12px rgba(31,168,97,.35);
}

/* ============================================
   SAVE BAR
   ============================================ */
.save-bar {
  position: sticky; bottom: 0;
  background: rgba(255,255,255,.95);
  backdrop-filter: blur(20px);
  border-top: 2px solid var(--border-soft);
  padding: 18px 32px;
  margin: 22px -32px -32px;
  display: flex; justify-content: space-between; align-items: center;
  gap: 12px;
  box-shadow: 0 -8px 24px rgba(15,61,40,.08);
  z-index: 100; flex-wrap: wrap;
  border-radius: 0 0 var(--radius-lg) var(--radius-lg);
}
.save-bar .status {
  font-size: .82rem; color: var(--text-muted);
  font-weight: 700;
  display: flex; align-items: center; gap: 8px;
}
.save-bar .status i { color: var(--color-green-bright); }
.btn-save {
  background: var(--grad-green); color: #fff; border: none;
  padding: 14px 36px; border-radius: 12px;
  font-family: 'Cairo'; font-weight: 900; font-size: 1rem;
  cursor: pointer;
  box-shadow: 0 8px 22px rgba(31,168,97,.4);
  transition: var(--transition);
  display: inline-flex; align-items: center; gap: 10px;
}
.btn-save:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 30px rgba(31,168,97,.5);
}

/* ============================================
   EMPTY STATE
   ============================================ */
.empty-state {
  padding: 70px 24px; text-align: center;
  background: #fff; border-radius: var(--radius-lg);
  border: 2px dashed var(--border-soft);
  animation: fadeInPage .5s ease;
}
.empty-state i {
  font-size: 3.5rem; color: #cbd5e1;
  margin-bottom: 16px; display: block;
  animation: floatIcon 3s ease-in-out infinite;
}
@keyframes floatIcon {
  0%,100% { transform: translateY(0); }
  50% { transform: translateY(-8px); }
}
.empty-state h4 {
  color: var(--text-muted); font-weight: 900;
  margin-bottom: 8px; font-size: 1.2rem;
}

/* ============================================
   SWEETALERT
   ============================================ */
.swal2-popup {
  font-family: 'Cairo', sans-serif !important;
  border-radius: var(--radius-lg) !important;
  padding: 2.2rem !important;
  box-shadow: var(--shadow-xl) !important;
}
.swal2-title {
  font-weight: 900 !important;
  color: var(--color-green-dark) !important;
  font-size: 1.4rem !important;
}
.swal2-html-container {
  color: var(--text-muted) !important;
  font-weight: 600 !important;
  font-size: .95rem !important;
}
.swal2-confirm {
  background: var(--grad-green) !important;
  font-weight: 800 !important;
  border-radius: 50px !important;
  padding: 12px 32px !important;
  box-shadow: 0 6px 18px rgba(31,168,97,.3) !important;
}
.swal2-cancel {
  background: var(--bg-body) !important;
  color: var(--color-green-dark) !important;
  font-weight: 800 !important;
  border-radius: 50px !important;
  padding: 12px 32px !important;
}
.swal2-toast {
  background: #fff !important;
  border-radius: 14px !important;
  box-shadow: var(--shadow-lg) !important;
  border-right: 4px solid var(--color-green-bright) !important;
}

/* ============================================
   MOBILE
   ============================================ */
.tb-toggle {
  display: none; background: #fff;
  border: 1px solid var(--border-soft);
  width: 42px; height: 42px; border-radius: 12px;
  color: var(--color-green-dark);
  cursor: pointer; font-size: 1.15rem;
}
.tb-toggle:hover { background: var(--color-soft-rayhan); }
@media (max-width: 991px) {
  .sidebar { transform: translateX(100%); }
  .sidebar.open { transform: translateX(0); }
  .main-wrap { margin-right: 0; }
  .tb-toggle { display: grid; place-items: center; }
  .content { padding: 20px; }
  .topbar { padding: 0 18px; }
  .overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(15,61,40,.6);
    z-index: 1040; backdrop-filter: blur(4px);
  }
  .overlay.show { display: block; }
}

/* ============================================
   RICH EDITOR
   ============================================ */
.tox-tinymce {
  border-radius: 14px !important;
  border: 2px solid #e2e8f0 !important;
}
.tox:not(.tox-tinymce-inline) .tox-editor-header {
  border-radius: 14px 14px 0 0 !important;
}
/* ============================================
   SIDEBAR COLLAPSE
   ============================================ */
body.sidebar-collapsed .sidebar {
    width: 82px;
}
body.sidebar-collapsed .main-wrap {
    margin-right: 82px;
}
body.sidebar-collapsed .sb-brand {
    justify-content: center;
    padding: 0;
    height: 82px;
}
body.sidebar-collapsed .sb-brand > div {
    display: none;
}
body.sidebar-collapsed .sb-brand img {
    width: 44px;
    height: 44px;
}
body.sidebar-collapsed .sb-section {
    display: none;
}
body.sidebar-collapsed .sb-link {
    justify-content: center;
    padding: 12px;
    margin-bottom: 6px;
    position: relative;
}
body.sidebar-collapsed .sb-link span,
body.sidebar-collapsed .sb-link .sb-badge {
    display: none;
}
body.sidebar-collapsed .sb-link i {
    margin: 0;
    font-size: 1.2rem;
}
body.sidebar-collapsed .sb-nav {
    padding: 16px 8px;
}
body.sidebar-collapsed .sb-footer {
    padding: 12px 8px;
}
body.sidebar-collapsed .user-card {
    justify-content: center;
    padding: 8px;
}
body.sidebar-collapsed .user-info {
    display: none;
}
body.sidebar-collapsed .btn-logout {
    padding: 12px 0;
    font-size: 0;
}
body.sidebar-collapsed .btn-logout i {
    font-size: 1rem;
}

/* Tooltip on collapsed links */
body.sidebar-collapsed .sb-link::after {
    content: attr(title);
    position: absolute;
    right: calc(100% + 12px);
    top: 50%;
    transform: translateY(-50%) translateX(8px);
    background: #0f3d28;
    color: #fff;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: .8rem;
    font-weight: 700;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all .25s ease;
    pointer-events: none;
    box-shadow: 0 6px 20px rgba(0,0,0,.25);
    z-index: 1060;
}
body.sidebar-collapsed .sb-link::before {
    content: '';
    position: absolute;
    right: calc(100% + 6px);
    top: 50%;
    transform: translateY(-50%);
    border: 6px solid transparent;
    border-left-color: #0f3d28;
    opacity: 0;
    visibility: hidden;
    transition: all .25s ease;
    z-index: 1060;
}
body.sidebar-collapsed .sb-link:hover::after {
    opacity: 1;
    visibility: visible;
    transform: translateY(-50%) translateX(0);
}
body.sidebar-collapsed .sb-link:hover::before {
    opacity: 1;
    visibility: visible;
}

/* Floating collapse button */
.sb-collapse-btn {
    position: fixed;
    top: 30px;
    right: calc(var(--sidebar-w) - 18px);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #fff;
    color: var(--color-green-dark);
    border: 2px solid var(--border-soft);
    display: grid;
    place-items: center;
    cursor: pointer;
    z-index: 1051;
    transition: all .35s cubic-bezier(.4,0,.2,1);
    box-shadow: 0 4px 14px rgba(0,0,0,.1);
    font-size: .85rem;
}
.sb-collapse-btn:hover {
    background: var(--color-green-bright);
    color: #fff;
    border-color: transparent;
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(31,168,97,.35);
}
body.sidebar-collapsed .sb-collapse-btn {
    right: 64px;
}
body.sidebar-collapsed .sb-collapse-btn i {
    transform: rotate(180deg);
}
body.sidebar-collapsed .sb-collapse-btn:hover {
    transform: scale(1.1);
}

/* Hide collapse button on mobile */
@media (max-width: 991px) {
    .sb-collapse-btn {
        display: none !important;
    }
    body.sidebar-collapsed .sidebar {
        width: var(--sidebar-w);
    }
    body.sidebar-collapsed .main-wrap {
        margin-right: 0;
    }
    body.sidebar-collapsed .sb-brand > div,
    body.sidebar-collapsed .sb-section,
    body.sidebar-collapsed .sb-link span,
    body.sidebar-collapsed .sb-link .sb-badge,
    body.sidebar-collapsed .user-info {
        display: revert;
    }
    body.sidebar-collapsed .btn-logout {
        font-size: .88rem;
        padding: 11px;
    }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Flash messages → SweetAlert Toast
    document.querySelectorAll('.alert-legacy-hidden').forEach((el, i) => {
        setTimeout(() => {
            Swal.fire({
                toast: true, position: 'bottom-end', icon: el.dataset.type || 'info',
                title: el.innerText.trim(), showConfirmButton: false, timer: 4500,
                timerProgressBar: true, customClass: { popup: 'swal2-toast' }
            });
        }, i * 250);
        el.remove();
    });

    // TinyMCE
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '.rich-editor',
            directionality: 'rtl', language: 'ar', height: 380, menubar: false, branding: false,
            plugins: 'lists link image table code preview fullscreen',
            toolbar: 'undo redo | blocks | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | link image table | code fullscreen',
            skin: 'oxide',
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&family=Tajawal:wght@400;600;800&display=swap'); body { font-family: 'Tajawal', sans-serif; font-size: 15px; color: #1f2937; line-height: 1.9; padding: 8px; } h1,h2,h3,h4{font-family:'Cairo',sans-serif;color:#0f3d28;} a{color:#1fa861;} blockquote{border-right:4px solid #1fa861;padding-right:14px;margin:14px 0;color:#4b5563;font-style:italic;}",
            setup: function (editor) {
                editor.on('init', function () {
                    editor.getContainer().style.borderRadius = "14px";
                    editor.getContainer().style.border = "2px solid #e2e8f0";
                    editor.getContainer().style.boxShadow = "0 6px 20px rgba(15,61,40,0.04)";
                });
            }
        });
    }
});

/** Delete confirmation */
function confirmDelete(formId, text = 'هل أنت متأكد من الحذف؟ هذا الإجراء لا يمكن التراجع عنه.') {
    Swal.fire({
        title: 'تأكيد الحذف', html: `<p>${text}</p>`, icon: 'warning',
        showCancelButton: true, confirmButtonText: '<i class="fa-solid fa-trash me-1"></i> نعم، احذف',
        cancelButtonText: 'إلغاء', reverseButtons: true, confirmButtonColor: '#e0496b', cancelButtonColor: '#64748b'
    }).then((result) => {
        if (result.isConfirmed) document.getElementById(formId).submit();
    });
    return false;
}

/** Toast */
function fToast(msg, type = 'success') {
    Swal.fire({
        toast: true, position: 'bottom-end', icon: type, title: msg,
        showConfirmButton: false, timer: 3500, timerProgressBar: true,
        customClass: { popup: 'swal2-toast' }
    });
}

/** Filter list */
function fFilter(searchInputId, chipsSelector, itemsSelector) {
    const q = (document.getElementById(searchInputId)?.value || '').toLowerCase().trim();
    const activeChip = document.querySelector(chipsSelector + ' .f-chip.active');
    const filter = activeChip ? activeChip.dataset.value : 'all';
    let visible = 0;

    document.querySelectorAll(itemsSelector).forEach(el => {
        const text = el.dataset.search || el.innerText.toLowerCase();
        const status = el.dataset.status || '';
        const matchSearch = !q || text.includes(q);
        const matchFilter = filter === 'all' || filter === status;
        const show = matchSearch && matchFilter;
        el.style.display = show ? '' : 'none';
        if (show) {
            visible++;
            el.style.animation = 'fadeInPage .3s ease';
        }
    });

    const counter = document.querySelector('[data-filter-count]');
    if (counter) counter.textContent = visible;
}

/** Icon picker */
function pickIcon(btn) {
    const grid = btn.closest('.icon-grid'); if (!grid) return;
    grid.querySelectorAll('.icon-option').forEach(el => el.classList.remove('active'));
    btn.classList.add('active');
    const hidden = grid.nextElementSibling;
    if (hidden && hidden.type === 'hidden') hidden.value = btn.dataset.icon;
}

/** NEW: Modern image uploader */
function handleImageUpload(input, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    
    if (!input.files || !input.files[0]) return;
    
    const file = input.files[0];
    if (!file.type.startsWith('image/')) {
        fToast('يرجى اختيار صورة صحيحة', 'error');
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
        container.classList.add('has-image');
        container.innerHTML = `
            <div class="uploader-preview">
                <img src="${e.target.result}" alt="preview">
                <div class="uploader-meta">
                    <strong>صورة جديدة جاهزة للرفع</strong>
                    <code>${file.name}</code>
                    <div class="uploader-actions">
                        <button type="button" class="uploader-btn uploader-btn-change" onclick="document.getElementById('${input.id}').click()">
                            <i class="fa-solid fa-arrows-rotate"></i> تغيير
                        </button>
                    </div>
                </div>
            </div>
        `;
    };
    reader.readAsDataURL(file);
}

/** NEW: Remove image */
function removeImage(inputId, containerId, fieldName) {
    Swal.fire({
        title: 'حذف الصورة؟',
        text: 'هل تريد حذف الصورة الحالية؟',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'نعم، احذف',
        cancelButtonText: 'إلغاء',
        reverseButtons: true,
        confirmButtonColor: '#e0496b'
    }).then(r => {
        if (!r.isConfirmed) return;
        const container = document.getElementById(containerId);
        const input = document.getElementById(inputId);
        if (input) input.value = '';
        if (container) {
            container.classList.remove('has-image');
            container.innerHTML = `
                <div class="uploader-drop" onclick="document.getElementById('${inputId}').click()">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <p>اسحب صورة هنا أو اضغط للاختيار</p>
                    <small>JPG / PNG / WEBP — حتى 5 ميجا</small>
                </div>
            `;
        }
        const hidden = document.querySelector(`input[name="${fieldName}"][type="hidden"]`);
        if (hidden) hidden.value = '';
    });
}

/** Drag & Drop for image uploader */
function setupImageDrop(containerId, inputId) {
    const container = document.getElementById(containerId);
    const input = document.getElementById(inputId);
    if (!container || !input) return;
    
    ['dragenter', 'dragover'].forEach(ev => 
        container.addEventListener(ev, e => {
            e.preventDefault();
            container.classList.add('dragover');
        })
    );
    ['dragleave', 'drop'].forEach(ev => 
        container.addEventListener(ev, e => {
            e.preventDefault();
            container.classList.remove('dragover');
        })
    );
    container.addEventListener('drop', e => {
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;
            handleImageUpload(input, containerId);
        }
    });
}

/** Legacy previewFile (backward compat) */
function previewFile(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const container = input.closest('.img-uploader');
        if (container) {
            handleImageUpload(input, container.id);
        }
    };
    reader.readAsDataURL(input.files[0]);
}
// ============================================
// SIDEBAR COLLAPSE
// ============================================
function toggleSidebarCollapse() {
    document.body.classList.toggle('sidebar-collapsed');
    const isCollapsed = document.body.classList.contains('sidebar-collapsed');
    localStorage.setItem('admin_sidebar_collapsed', isCollapsed ? '1' : '0');
}

// Restore state on load
document.addEventListener('DOMContentLoaded', function() {
    if (localStorage.getItem('admin_sidebar_collapsed') === '1' && window.innerWidth > 991) {
        document.body.classList.add('sidebar-collapsed');
    }
});
</script>
</head>
<body>
<div class="overlay" id="sbOverlay" onclick="toggleSidebar()"></div>
<?php include __DIR__ . '/sidebar.php'; ?>
<div class="main-wrap">
    <header class="topbar">
        <div class="tb-left">
            <button class="tb-toggle" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
            <div>
                <div class="tb-breadcrumb">
                    <a href="/admin/index.php"><i class="fa-solid fa-house"></i> الرئيسية</a>
                    <i class="fa-solid fa-angle-left" style="font-size:.6rem"></i>
                    <span><?= e($pageTitle) ?></span>
                </div>
                <h1 class="tb-title"><?= e($pageTitle) ?></h1>
            </div>
        </div>
        <div class="tb-actions">
            <button class="tb-icon-btn" onclick="location.reload()" title="تحديث"><i class="fa-solid fa-rotate"></i></button>
            <a class="tb-btn" href="<?= APP_URL ?>" target="_blank">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span class="d-none d-sm-inline">عرض الموقع</span>
            </a>
        </div>
    </header>
    <main class="content">
        <div id="flash-messages-container" style="display:none;">
            <?php foreach (getFlashes() as $f): ?>
                <div class="alert-legacy-hidden" data-type="<?= e($f['type'] === 'danger' ? 'error' : $f['type']) ?>"><?= e($f['message']) ?></div>
            <?php endforeach; ?>
        </div>