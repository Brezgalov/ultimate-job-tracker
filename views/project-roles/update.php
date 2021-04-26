<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectRoles */

$this->title = 'Update Project Roles: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Project Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-roles-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
