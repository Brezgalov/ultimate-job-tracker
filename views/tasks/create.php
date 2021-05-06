<?php

use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Tasks */

$this->title = 'Создание задачи';
$this->params['breadcrumbs'][] = ['label' => ArrayHelper::getValue(\Yii::$app->params, 'pageTitles.tasks'), 'url' => ['/tasks']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
