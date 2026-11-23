<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'لماذا يختارنا العملاء';
$activeMenu = 'why-choose-us';

require_once __DIR__ . '/includes/crud.php';

$crud = new AdminCrud('why_choose_us', [
    'singular' => 'ميزة',
    'plural'   => 'الميزات',
    'search'   => ['title', 'description'],
    'fields'   => [
        'icon'       => ['label'=>'الأيقونة', 'type'=>'icon', 'col'=>'col-md-4'],
        'icon_color' => ['label'=>'لون الأيقونة', 'type'=>'select', 'col'=>'col-md-4', 'options'=>[
            'text-success'=>'أخضر', 'text-warning'=>'أصفر', 'text-info'=>'سماوي',
            'text-danger'=>'أحمر', 'text-primary'=>'أزرق', 'text-light'=>'أبيض',
        ]],
        'sort_order' => ['label'=>'الترتيب', 'type'=>'number', 'default'=>0, 'col'=>'col-md-4'],
        'title'       => ['label'=>'العنوان', 'type'=>'text', 'required'=>true, 'col'=>'col-12'],
        'description' => ['label'=>'الوصف', 'type'=>'textarea', 'required'=>true, 'rows'=>2, 'col'=>'col-12'],
        'is_active'   => ['label'=>'مفعّلة', 'type'=>'toggle', 'default'=>1, 'col'=>'col-md-6'],
    ],
]);
$crud->run();
include __DIR__ . '/includes/head.php';
$crud->render();
include __DIR__ . '/includes/footer.php';