<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'مراحل التنفيذ';
$activeMenu = 'workflow';

require_once __DIR__ . '/includes/crud.php';

$crud = new AdminCrud('workflow_steps', [
    'singular' => 'مرحلة',
    'plural'   => 'المراحل',
    'search'   => ['title', 'description'],

    'fields' => [
        'step_number' => [
            'label'   => 'رقم المرحلة',
            'type'    => 'number',
            'required'=> true,
            'default' => 1,
            'col'     => 'col-md-3',
            'hint'    => 'يظهر داخل دائرة على الموقع (1، 2، 3...)',
        ],
        'title' => [
            'label'       => 'العنوان',
            'type'        => 'text',
            'required'    => true,
            'col'         => 'col-md-9',
            'placeholder' => 'المعاينة ورفع المقاسات',
        ],
        'description' => [
            'label'    => 'الوصف',
            'type'     => 'textarea',
            'required' => true,
            'rows'     => 3,
            'col'      => 'col-12',
            'hint'     => 'شرح مختصر للمرحلة — 1-2 سطر يكفي',
        ],
        'card_style' => [
            'label'   => 'ستايل البطاقة',
            'type'    => 'select',
            'col'     => 'col-md-4',
            'options' => [
                'hover-mint-shift'    => 'مينت',
                'hover-rose-shift'    => 'وردي',
                'hover-sky-shift'     => 'سماوي',
                'hover-jasmine-shift' => 'ياسمين',
                'hover-rayhan-shift'  => 'ريحان',
            ],
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
            'col'     => 'col-md-4',
        ],
    ],
]);

$crud->run();
include __DIR__ . '/includes/head.php';
$crud->render();
include __DIR__ . '/includes/footer.php';