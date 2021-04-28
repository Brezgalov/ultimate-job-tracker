<?php

use app\forms\ProjectAddUserForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Projects */
/* @var $rolesAvailable array */
/* @var $usersAvailableList array */
/* @var $addUserForm ProjectAddUserForm*/

$this->title = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => ArrayHelper::getValue(\Yii::$app->params, 'pageTitles.projects'),
    'url' => ['index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $model->name,
    'url' => ['view', 'id' => $model->id],
];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="projects-update">
    <?= $this->render('_form', [
        'model' => $model,

        'rolesAvailable' => $rolesAvailable,
        'usersAvailableList' => $usersAvailableList,
        'addUserForm' => $addUserForm,
    ]) ?>
</div>
