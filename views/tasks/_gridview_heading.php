<?php

use yii\helpers\Html;

/* @var $title string */

?>

<h3 class="panel-title">
    <i class="glyphicon glyphicon-list"></i>&nbsp; <?= $title ?>
</h3>
<div class="pull-right">
    <?= Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/task/create'], [
        'type'=>'button', 'title'=>'Добавить задачу',
        'class'=>'btn btn-success'
    ]) ?>
    <?= Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['/tasks'], [
        'data-pjax' => 0,
        'class' => 'btn btn-default',
        'title'=>'Сбросить фильтр',
    ]) ?>
    {dynagrid}
</div>
