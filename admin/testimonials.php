<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'آراء العملاء';
$activeMenu = 'testimonials';

require_once __DIR__ . '/includes/crud.php';

$crud = new AdminCrud('testimonials', [
    'singular'    => 'رأي',
    'plural'      => 'الآراء',
    'search'      => ['client_name', 'content'],
    'has_image'   => true,
    'image_field' => 'image',
    'image_folder'=> 'testimonials',

    'fields' => [
        'client_name' => [
            'label'       => 'اسم العميل',
            'type'        => 'text',
            'required'    => true,
            'col'         => 'col-md-6',
            'placeholder' => 'أبو محمد',
        ],
        'client_title' => [
            'label'       => 'اللقب / المهنة',
            'type'        => 'text',
            'col'         => 'col-md-6',
            'placeholder' => 'صاحب فيلا - الملقا',
        ],
        'content' => [
            'label'    => 'نص الرأي',
            'type'     => 'textarea',
            'required' => true,
            'rows'     => 4,
            'col'      => 'col-12',
            'hint'     => 'اكتب الرأي كما هو — يُعرض داخل الكارت على الموقع',
        ],
        'rating' => [
            'label'   => 'التقييم (نجوم)',
            'type'    => 'select',
            'default' => '5',
            'col'     => 'col-md-4',
            'options' => [
                '5' => '⭐⭐⭐⭐⭐ (ممتاز)',
                '4' => '⭐⭐⭐⭐ (جيد جداً)',
                '3' => '⭐⭐⭐ (جيد)',
                '2' => '⭐⭐ (مقبول)',
                '1' => '⭐ (ضعيف)',
            ],
        ],
        'sort_order' => [
            'label'   => 'الترتيب',
            'type'    => 'number',
            'default' => 0,
            'col'     => 'col-md-4',
        ],
        'is_active' => [
            'label'   => 'مفعّل',
            'type'    => 'toggle',
            'default' => 1,
            'col'     => 'col-md-4',
        ],
        'image' => [
            'label' => 'صورة العميل (اختياري)',
            'type'  => 'image',
            'col'   => 'col-12',
            'hint'  => 'اتركها فارغة لعرض صورة افتراضية، أو ارفع صورة شخصية',
        ],
    ],
]);

$crud->run();
include __DIR__ . '/includes/head.php';
$crud->render();
include __DIR__ . '/includes/footer.php';