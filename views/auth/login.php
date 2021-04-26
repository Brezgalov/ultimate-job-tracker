<?php

/* @var $this yii\web\View */
/* @var $activeForm yii\bootstrap\ActiveForm */
/* @var $loginForm \app\forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-page">
    <div class="login-brand"><?= ArrayHelper::getValue(\Yii::$app->params, 'brandName', 'Login') ?></div>
    <div class="login-form-wrapper">
        <?php $activeForm = ActiveForm::begin([
            'id' => 'login-form',
//            'layout' => 'horizontal',
//            'fieldConfig' => [
//                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
//                'labelOptions' => ['class' => 'col-lg-1 control-label'],
//            ],
        ]); ?>

        <?= $activeForm->field($loginForm, 'username')->textInput(['autofocus' => true]) ?>

        <?= $activeForm->field($loginForm, 'password')->passwordInput() ?>

        <?= $activeForm->field($loginForm, 'rememberMe')->checkbox([
//            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
