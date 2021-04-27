<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\forms\ProjectAddUserForm;
use app\models\search\UsersSearch;

/* @var $this yii\web\View */
/* @var $model app\forms\ProjectInputForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $rolesAvailable array */
/* @var $usersAvailableList array */
/* @var $addUserForm ProjectAddUserForm*/

$leftColumnClass = 'col-md-6 col-lg-4';
$rightColumnClass = 'col-md-6 col-lg-5';

$formName = $model->formName();
?>

<div class="projects-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id', [
        'template' => '{input}',
        'options' => [
            'tag' => false,
        ],
    ])->hiddenInput()->label(false) ?>

    <div class="row">
        <div class="<?= $leftColumnClass ?>">
            <h1>
                <?php if ($model->id): ?>
                    <?= Html::encode($model->name) ?>
                <?php else: ?>
                    Новый проект
                <?php endif; ?>
            </h1>
        </div>
        <div class="<?= $rightColumnClass ?>">
            <h2 class="project-users-input-heading">Участники</h2>
        </div>
    </div>
    <div class="row">
        <div class="<?= $leftColumnClass ?>">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form
                    ->field($model, 'slug')
                    ->textInput(['maxlength' => true])
                    ->hint('Если не указано - заполнится автоматически')
            ?>

            <?= $form->field($model, 'description')->textarea() ?>
        </div>
        <div class="<?= $rightColumnClass ?>">
            <div class="add-user-form form-inline">
                <?= $form->field($addUserForm, 'user_id')->dropDownList($usersAvailableList) ?>

                <span>
                    <?= $form->field($addUserForm, 'role_id')->dropDownList($rolesAvailable) ?>

                    <i id="add-user-to-project-btn" class="glyphicon glyphicon-plus"></i>
                </span>
            </div>

            <div class="users-added-container">
                <?php if (empty($model->users)): ?>
                    <div class="no-users-placeholder">
                        <span>В проекте нет участников</span>
                    </div>
                <?php else: ?>
                    <?php foreach ($model->users as $userData): ?>
                        <?= $this->render('_form_participant_user_row', [
                            'userData'          => $userData,
                            'rolesAvailable'    => $rolesAvailable,
                            'formName'          => $formName,
                        ]) ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-9 text-right">
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
