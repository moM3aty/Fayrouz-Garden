<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'التقويم الزراعي';
$activeMenu = 'seasonal-calendar';

require_once __DIR__ . '/includes/crud.php';

$crud = new AdminCrud('seasonal_calendar', [
    'singular' => 'فصل',
    'plural'   => 'الفصول',
    'search'   => ['title'],
    'fields'   => [
        'badge_text'  => ['label'=>'نص البادج', 'type'=>'text', 'required'=>true, 'col'=>'col-md-4'],
        'badge_class' => ['label'=>'لون البادج', 'type'=>'select', 'col'=>'col-md-4', 'options'=>[
            'bg-success text-white'=>'أخضر', 'bg-danger text-white'=>'أحمر',
            'bg-primary text-white'=>'أزرق', 'bg-warning text-dark'=>'أصفر',
            'bg-info text-white'=>'سماوي', 'bg-secondary text-white'=>'رمادي',
        ]],
        'card_style'  => ['label'=>'ستايل البطاقة', 'type'=>'select', 'col'=>'col-md-4', 'options'=>[
            'hover-mint-shift'=>'مينت', 'hover-rose-shift'=>'وردي',
            'hover-sky-shift'=>'سماوي', 'hover-jasmine-shift'=>'ياسمين',
            'hover-rayhan-shift'=>'ريحان',
        ]],
        'title'       => ['label'=>'العنوان', 'type'=>'text', 'required'=>true, 'col'=>'col-12'],
        'description' => ['label'=>'الوصف', 'type'=>'textarea', 'required'=>true, 'rows'=>3, 'col'=>'col-12'],
        'sort_order'  => ['label'=>'الترتيب', 'type'=>'number', 'default'=>0, 'col'=>'col-md-6'],
        'is_active'   => ['label'=>'مفعّل', 'type'=>'toggle', 'default'=>1, 'col'=>'col-md-6'],
    ],
]);
$crud->run();
include __DIR__ . '/includes/head.php';
$crud->render();
include __DIR__ . '/includes/footer.php';