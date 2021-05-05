<?php

use kartik\dynagrid\DynaGrid;

/* @var \yii\data\ActiveDataProvider $dataProvider */
/* @var $title string */
/* @var $parentId int */

?>

<?= DynaGrid::widget([
    'gridOptions' => [
        'dataProvider'      => $dataProvider,
        'summary'           => false,
        'showPageSummary'   => false,
        'toolbar'           => false,
        'pjax'              => true,
        'hover'             => true,
        'panel' => [
            'before'        => false,
            'after'         => false,
            'heading'       => false,
            'footer'        => false,
        ],
    ],
    'storage' => DynaGrid::TYPE_COOKIE,
//    'options' => [
//        'id' => "task-{$parentId}-children-grid",
//    ],
    'options' => [
        'id'        => 'tasks-grid',
    ],
    'columns' => require (__DIR__ . '/_gridview_columns_setup.php'),
]); ?>