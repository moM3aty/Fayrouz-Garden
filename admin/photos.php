<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'صور المشاريع';
$activeMenu = 'photos';

require_once __DIR__ . '/includes/crud.php';

$crud = new AdminCrud('project_photos', [
    'singular'    => 'صورة',
    'plural'      => 'الصور',
    'search'      => ['title'],
    'has_image'   => true,
    'image_field' => 'image',
    'image_folder'=> 'photos',

    'fields' => [
        'title' => [
            'label'       => 'عنوان الصورة',
            'type'        => 'text',
            'col'         => 'col-12',
            'placeholder' => 'شلال جداري - فيلا الياسمين',
            'hint'        => 'يظهر كـ caption عند تمرير الماوس على الصورة',
        ],
        'image' => [
            'label'    => 'الصورة',
            'type'     => 'image',
            'required' => true,
            'col'      => 'col-12',
            'hint'     => 'مقاس مفضل: 600×600 (مربع) أو 800×600 — JPG/PNG/WEBP',
        ],
        'sort_order' => [
            'label'   => 'الترتيب',
            'type'    => 'number',
            'default' => 0,
            'col'     => 'col-md-6',
        ],
        'is_active' => [
            'label'   => 'مفعّلة',
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