<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectRoles */

$this->title = 'Create Project Roles';
$this->params['breadcrumbs'][] = ['label' => 'Project Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-roles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
