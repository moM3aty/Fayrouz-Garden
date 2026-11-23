<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'خدمات المشتل';
$activeMenu = 'services';

require_once __DIR__ . '/includes/crud.php';

$crud = new AdminCrud('services', [
    'singular' => 'خدمة',
    'plural'   => 'الخدمات',
    'search'   => ['title', 'description'],

    'fields' => [
        'title' => [
            'label'       => 'العنوان',
            'type'        => 'text',
            'required'    => true,
            'col'         => 'col-12',
            'placeholder' => 'تصميم حدائق 3D واوتوكاد',
        ],
        'description' => [
            'label'    => 'الوصف',
            'type'     => 'textarea',
            'required' => true,
            'rows'     => 4,
            'col'      => 'col-12',
            'hint'     => 'يظهر داخل كارت الخدمة — اختصره في 2-4 سطور',
        ],
        'icon' => [
            'label' => 'الأيقونة',
            'type'  => 'icon',
            'col'   => 'col-md-6',
        ],
        'card_style' => [
            'label'   => 'ستايل البطاقة',
            'type'    => 'select',
            'col'     => 'col-md-6',
            'options' => [
                'hover-mint-shift'    => 'مينت (أخضر فاتح)',
                'hover-sky-shift'     => 'سماوي',
                'hover-jasmine-shift' => 'ياسمين',
                'hover-rayhan-shift'  => 'ريحان',
                'hover-purple-shift'  => 'بنفسجي',
                'hover-rose-shift'    => 'وردي',
            ],
        ],
        'gradient_start' => [
            'label'   => 'لون البداية (Gradient)',
            'type'    => 'color',
            'default' => '#147a4b',
            'col'     => 'col-md-3',
        ],
        'gradient_end' => [
            'label'   => 'لون النهاية (Gradient)',
            'type'    => 'color',
            'default' => '#1fa861',
            'col'     => 'col-md-3',
        ],
        'sort_order' => [
            'label'   => 'الترتيب',
            'type'    => 'number',
            'default' => 0,
            'col'     => 'col-md-3',
        ],
        'is_active' => [
            'label'   => 'مفعّلة',
            'type'    => 'toggle',
            'default' => 1,
            'col'     => 'col-md-3',
        ],
    ],
]);

$crud->run();
include __DIR__ . '/includes/head.php';
$crud->render();
include __DIR__ . '/includes/footer.php';