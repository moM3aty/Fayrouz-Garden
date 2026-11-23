<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'القوائم العلوية';
$activeMenu = 'nav';

require_once __DIR__ . '/includes/crud.php';

$crud = new AdminCrud('navigation_links', [
    'singular' => 'رابط',
    'plural'   => 'الروابط',
    'search'   => ['label', 'href'],

    'fields' => [
        'label' => [
            'label'       => 'النص الظاهر',
            'type'        => 'text',
            'required'    => true,
            'col'         => 'col-md-6',
            'placeholder' => 'الرئيسية',
        ],
        'href' => [
            'label'       => 'الرابط',
            'type'        => 'text',
            'required'    => true,
            'col'         => 'col-md-6',
            'placeholder' => '#hero أو /page.php',
            'hint'        => 'استخدم #section للتمرير الداخلي، أو رابط كامل',
        ],
        'icon' => [
            'label' => 'الأيقونة',
            'type'  => 'icon',
            'col'   => 'col-md-6',
        ],
        'sort_order' => [
            'label'   => 'الترتيب',
            'type'    => 'number',
            'default' => 0,
            'col'     => 'col-md-6',
        ],
        'show_in_nav' => [
            'label'   => 'يظهر في النافبار العلوي',
            'type'    => 'toggle',
            'default' => 1,
            'col'     => 'col-md-4',
        ],
        'show_in_drawer' => [
            'label'   => 'يظهر في القائمة الجانبية (الموبايل)',
            'type'    => 'toggle',
            'default' => 1,
            'col'     => 'col-md-4',
        ],
        'is_active' => [
            'label'   => 'مفعّل',
            'type'    => 'toggle',
            'default' => 1,
            'col'     => 'col-md-4',
        ],
    ],
]);

$crud->run();
include __DIR__ . '/includes/head.php';
$crud->render();
include __DIR__ . '/includes/footer.php';