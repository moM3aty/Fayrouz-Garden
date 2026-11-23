<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'معرض الأعمال';
$activeMenu = 'portfolio';

require_once __DIR__ . '/includes/crud.php';

$crud = new AdminCrud('portfolio_items', [
    'singular'    => 'عمل',
    'plural'      => 'الأعمال',
    'search'      => ['title', 'category'],
    'has_image'   => true,
    'image_field' => 'image',
    'image_folder'=> 'portfolio',

    'fields' => [
        'title' => [
            'label'       => 'عنوان العمل',
            'type'        => 'text',
            'col'         => 'col-md-6',
            'placeholder' => 'حديقة فيلا - حي الملقا',
        ],
        'category' => [
            'label'       => 'التصنيف',
            'type'        => 'text',
            'col'         => 'col-md-6',
            'placeholder' => 'فلل / استراحات / شاليهات',
            'hint'        => 'التصنيف يُستخدم في فلتر المعرض على الموقع',
        ],
        'image' => [
            'label'    => 'الصورة',
            'type'     => 'image',
            'required' => true,
            'col'      => 'col-12',
            'hint'     => 'مقاس مفضل: 800×600 — JPG/PNG/WEBP',
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