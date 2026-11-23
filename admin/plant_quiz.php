<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/upload.php';
requireLogin();
$pageTitle = 'أسئلة الكويز'; $activeMenu = 'plant-quiz';
require_once __DIR__ . '/includes/crud.php';

$crud = new AdminCrud('plant_quiz_questions', [
    'singular' => 'سؤال',
    'plural'   => 'الأسئلة',
    'search'   => ['question'],
    'fields'   => [
        'group_key' => ['label'=>'المجموعة (sun/space/care)', 'type'=>'select', 'col'=>'col-md-4', 'options'=>[
            'sun'=>'الشمس', 'space'=>'المساحة', 'care'=>'العناية',
        ]],
        'sort_order' => ['label'=>'الترتيب', 'type'=>'number', 'default'=>0, 'col'=>'col-md-4'],
        'is_active'  => ['label'=>'مفعّل', 'type'=>'toggle', 'default'=>1, 'col'=>'col-md-4'],
        'question' => ['label'=>'نص السؤال', 'type'=>'text', 'required'=>true, 'col'=>'col-12'],
        'hint' => ['label'=>'نص التلميح', 'type'=>'textarea', 'rows'=>2, 'col'=>'col-12'],
        'options' => ['label'=>'الخيارات (key:label,key:label)', 'type'=>'textarea', 'required'=>true, 'rows'=>3, 'col'=>'col-12', 'hint'=>'الصيغة: full:شمس كاملة,half:نصف ظل,shade:ظل أغلب اليوم'],
    ],
]);
$crud->run();
include __DIR__ . '/includes/head.php';
$crud->render();
include __DIR__ . '/includes/footer.php';