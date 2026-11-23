<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'أسرار المهندس';
$activeMenu = 'pro-tips';

require_once __DIR__ . '/includes/crud.php';

$crud = new AdminCrud('pro_tips', [
    'singular' => 'نصيحة',
    'plural'   => 'النصائح',
    'search'   => ['title', 'back_text'],
    'fields'   => [
        'icon'       => ['label'=>'الأيقونة', 'type'=>'icon', 'col'=>'col-md-6'],
        'title'      => ['label'=>'العنوان الأمامي', 'type'=>'text', 'required'=>true, 'col'=>'col-md-6'],
        'back_text'  => ['label'=>'النص الخلفي (عند قلب البطاقة)', 'type'=>'textarea', 'required'=>true, 'rows'=>3, 'col'=>'col-12'],
        'sort_order' => ['label'=>'الترتيب', 'type'=>'number', 'default'=>0, 'col'=>'col-md-6'],
        'is_active'  => ['label'=>'مفعّلة', 'type'=>'toggle', 'default'=>1, 'col'=>'col-md-6'],
    ],
]);
$crud->run();
include __DIR__ . '/includes/head.php';
$crud->render();
include __DIR__ . '/includes/footer.php';