<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\TasksSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tasks-search container-fluid">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-12">
            <span class="filters-title">Фильтры</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'project_id') ?>
            <?= $form->field($model, 'status_id') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'id') ?>
            <?= $form->field($model, 'parent_task_id') ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'any_text') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
