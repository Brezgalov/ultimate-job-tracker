<?php

use app\forms\ProjectAddUserForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Projects */
/* @var $rolesAvailable array */
/* @var $usersAvailableList array */
/* @var $addUserForm ProjectAddUserForm*/

$this->title = 'Создание Проекта';
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-create">
    <?= $this->render('_form', [
        'model' => $model,

        'rolesAvailable' => $rolesAvailable,
        'usersAvailableList' => $usersAvailableList,
        'addUserForm' => $addUserForm,
    ]) ?>
</div>
