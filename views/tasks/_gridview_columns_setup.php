<?php

use app\models\Tasks;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

return [
    [
        'class'             => 'kartik\grid\ExpandRowColumn',
        'headerOptions'     => ['class' => 'kartik-sheet-style'],
        'width'             => '50px',
        'detailUrl'         => '/tasks/children',
        'allowBatchToggle'  => false,
        'disabled'      => function (Tasks $model, $key, $index, $column) {
            return !$model->getChildren()->exists();
        },
        'value'         => function (Tasks $model, $key, $index, $column) {
            return GridView::ROW_COLLAPSED;
        },
        'detailAnimationDuration' => 150,
    ],
    [
        'attribute'         => 'id',
        'width'             => '7%',
        'contentOptions'    => ['class'=>'text-center'],
    ],
    [
        'attribute'         => 'status_id',
        'width'             => '7%',
        'contentOptions'    => ['class'=>'text-center'],
        'value' => function (Tasks $task) {
            return $task->status ? Html::encode($task->status->name) : '';
        }
    ],
    [
        'attribute' => 'title',
        'format'    => 'raw',
        'value'     => function (Tasks $task) {
            return Html::a($task->title, ["/task/{$task->id}"], [
                'class' => 'task-link',
            ]);
        }
    ],
    [
        'attribute'         => 'created_at',
        'width'             => '10%',
        'contentOptions'    => ['class'=>'text-center'],
        'value'             => function (Tasks $task) {
            return date('d.m.Y H:i', $task->created_at);
        }
    ],
    [
        'attribute' => 'project_id',
        'visible'   => false,
        'value' => function (Tasks $task) {
            return $task->project ? Html::encode($task->project->name) : '';
        }
    ],
    [
        'attribute' => 'start_at',
        'visible'   => false,
    ],
    [
        'attribute' => 'end_at',
        'visible'   => false,
    ],
    [
        'attribute' => 'hours_est',
        'visible'   => false,
    ],
    [
        'attribute' => 'description',
        'visible'   => false,
    ],
];