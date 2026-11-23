<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'باقات الصيانة';
$activeMenu = 'maintenance';

require_once __DIR__ . '/includes/crud.php';

$crud = new AdminCrud('maintenance_plans', [
    'singular' => 'باقة',
    'plural'   => 'الباقات',
    'search'   => ['title', 'description'],

    'fields' => [
        'title' => [
            'label'       => 'عنوان الباقة',
            'type'        => 'text',
            'required'    => true,
            'col'         => 'col-12',
            'placeholder' => 'برنامج العناية الأسبوعي',
        ],
        'description' => [
            'label'    => 'الوصف',
            'type'     => 'textarea',
            'required' => true,
            'rows'     => 4,
            'col'      => 'col-12',
            'hint'     => 'اذكر ما تشمله الباقة — نقاط أو فقرة',
        ],
        'icon' => [
            'label' => 'الأيقونة',
            'type'  => 'icon',
            'col'   => 'col-md-6',
        ],
        'cta_text' => [
            'label'   => 'نص الزر (CTA)',
            'type'    => 'text',
            'default' => 'طلب تفاصيل البرنامج',
            'col'     => 'col-md-6',
        ],
        'cta_link' => [
            'label'       => 'رابط الزر (CTA)',
            'type'        => 'text',
            'col'         => 'col-12',
            'placeholder' => 'https://wa.me/966505527615?text=...',
            'hint'        => 'يفضل رابط واتساب مع نص جاهز للرسالة',
        ],
        'card_style' => [
            'label'   => 'ستايل البطاقة',
            'type'    => 'select',
            'col'     => 'col-md-4',
            'options' => [
                'hover-mint-shift' => 'مينت',
                'hover-rose-shift' => 'وردي',
                'hover-sky-shift'  => 'سماوي',
            ],
        ],
        'gradient_start' => [
            'label'   => 'لون البداية (Gradient)',
            'type'    => 'color',
            'default' => '#147a4b',
            'col'     => 'col-md-4',
        ],
        'gradient_end' => [
            'label'   => 'لون النهاية (Gradient)',
            'type'    => 'color',
            'default' => '#1fa861',
            'col'     => 'col-md-4',
        ],
        'btn_class' => [
            'label'   => 'كلاس زر CTA (Bootstrap)',
            'type'    => 'select',
            'col'     => 'col-md-6',
            'options' => [
                'btn-outline-success' => 'أخضر Outline',
                'btn-outline-danger'  => 'أحمر Outline',
                'btn-outline-primary' => 'أزرق Outline',
                'btn-outline-warning' => 'أصفر Outline',
                'btn-success'         => 'أخضر مصمت',
                'btn-primary'         => 'أزرق مصمت',
            ],
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