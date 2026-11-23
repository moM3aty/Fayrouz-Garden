<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();

$pageTitle  = 'الأسئلة الشائعة';
$activeMenu = 'faqs';

require_once __DIR__ . '/includes/crud.php';

$crud = new AdminCrud('faqs', [
    'singular' => 'سؤال',
    'plural'   => 'الأسئلة',
    'search'   => ['question', 'answer'],

    'fields' => [
        'question' => [
            'label'       => 'السؤال',
            'type'        => 'text',
            'required'    => true,
            'col'         => 'col-12',
            'placeholder' => 'كم تستغرق مدة تنفيذ حديقة فيلا كاملة؟',
        ],
        'answer' => [
            'label'    => 'الإجابة',
            'type'     => 'textarea',
            'required' => true,
            'rows'     => 5,
            'col'      => 'col-12',
            'hint'     => 'أجب بشكل واضح ومفصّل — يتم عرضه في accordion',
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