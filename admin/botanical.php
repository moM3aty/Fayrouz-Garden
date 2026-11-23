<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'النباتات والزهور';
$activeMenu = 'botanical';

require_once __DIR__ . '/includes/crud.php';

$crud = new AdminCrud('botanical_varieties', [
    'singular' => 'نبات',
    'plural'   => 'النباتات',
    'search'   => ['title', 'description'],

    'fields' => [
        'title' => [
            'label'       => 'الاسم',
            'type'        => 'text',
            'required'    => true,
            'col'         => 'col-12',
            'placeholder' => 'زهور الفل البلدي والعراقي',
        ],
        'description' => [
            'label'    => 'الوصف',
            'type'     => 'textarea',
            'required' => true,
            'rows'     => 3,
            'col'      => 'col-12',
            'hint'     => 'وصف قصير جاذب — يظهر داخل كارت النبات',
        ],
        'icon' => [
            'label' => 'الأيقونة',
            'type'  => 'icon',
            'col'   => 'col-md-4',
        ],
        'badge_class' => [
            'label'       => 'كلاس البادج (Bootstrap)',
            'type'        => 'select',
            'col'         => 'col-md-4',
            'options'     => [
                'bg-success'             => 'أخضر',
                'bg-warning text-dark'   => 'أصفر',
                'bg-danger text-white'   => 'أحمر',
                'bg-info text-white'     => 'سماوي',
                'bg-primary text-white'  => 'أزرق',
                'bg-secondary text-white'=> 'رمادي',
            ],
        ],
        'card_style' => [
            'label'   => 'ستايل البطاقة',
            'type'    => 'select',
            'col'     => 'col-md-4',
            'options' => [
                'hover-jasmine-shift' => 'ياسمين',
                'hover-rose-shift'    => 'وردي',
                'hover-rayhan-shift'  => 'ريحان',
                'hover-mint-shift'    => 'مينت',
                'hover-sky-shift'     => 'سماوي',
                'hover-purple-shift'  => 'بنفسجي',
            ],
        ],
        'sort_order' => [
            'label'   => 'الترتيب',
            'type'    => 'number',
            'default' => 0,
            'col'     => 'col-md-6',
        ],
        'is_active' => [
            'label'   => 'مفعّل',
            'type'    => 'toggle',
            'default' => 1,
            'col'     => 'col-md-6',
        ],
    ],
]);

$crud->run();
include __DIR__ . '/includes/head.php';
$crud->render();
include __DIR__ . '/includes/footer.php';