<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();
$pageTitle = 'فحص الحديقة'; $activeMenu = 'garden-checkup';
require_once __DIR__ . '/includes/crud.php';

$crud = new AdminCrud('garden_checkup_items', [
    'singular' => 'عنصر',
    'plural'   => 'العناصر',
    'search'   => ['item_text'],
    'fields'   => [
        'item_text' => ['label'=>'نص الملاحظة', 'type'=>'text', 'required'=>true, 'col'=>'col-12'],
        'sort_order' => ['label'=>'الترتيب', 'type'=>'number', 'default'=>0, 'col'=>'col-md-6'],
        'is_active'  => ['label'=>'مفعّل', 'type'=>'toggle', 'default'=>1, 'col'=>'col-md-6'],
    ],
]);
$crud->run();
include __DIR__ . '/includes/head.php';
$crud->render();
include __DIR__ . '/includes/footer.php';