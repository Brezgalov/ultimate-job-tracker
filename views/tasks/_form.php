<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tasks */
/* @var $form yii\widgets\ActiveForm */

\app\assets\TasksInputAsset::register($this);

?>

<div class="tasks-form container-fluid">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default my-panel task-main-panel">
                <div class="panel-heading">
                    <?= $model->isNewRecord ? 'Создание Задачи' : "Задача #{$model->id}" ?>
                </div>
                <div class="panel-body">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default my-panel task-details-panel">
                <div class="panel-heading">Детали</div>
                <div class="panel-body container-fluid">
                    <div class="col-md-6">
                        <?= $form->field($model, 'project_id')->textInput() ?>

                        <?= $form->field($model, 'status_id')->textInput() ?>

                        <?= $form->field($model, 'start_at')->textInput() ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'parent_task_id')->textInput() ?>

                        <?= $form->field($model, 'hours_est')->textInput() ?>

                        <?= $form->field($model, 'end_at')->textInput() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
