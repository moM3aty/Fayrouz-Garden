<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'نطاق التغطية';
$activeMenu = 'districts';

require_once __DIR__ . '/includes/crud.php';

$crud = new AdminCrud('districts', [
    'singular' => 'منطقة',
    'plural'   => 'المناطق',
    'search'   => ['name'],

    'fields' => [
        'name' => [
            'label'       => 'اسم المنطقة',
            'type'        => 'text',
            'required'    => true,
            'col'         => 'col-md-8',
            'placeholder' => 'الملقا',
            'hint'        => 'يظهر في قائمة مناطق التغطية على الموقع',
        ],
        'sort_order' => [
            'label'   => 'الترتيب',
            'type'    => 'number',
            'default' => 0,
            'col'     => 'col-md-4',
        ],
        'is_active' => [
            'label'   => 'مفعّلة',
            'type'    => 'toggle',
            'default' => 1,
            'col'     => 'col-12',
        ],
    ],
]);

$crud->run();
include __DIR__ . '/includes/head.php';
$crud->render();
include __DIR__ . '/includes/footer.php';