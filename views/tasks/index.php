<?php

use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TasksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/**
 * Костыли на js нужны из-за плохой совместимости DynaGrid и ExpandRowColumn
 * При вложенности отключается js отвечающий за работу кнопки вызова модалки. Почему - магия?
 * Так же присвоил всем DynaGrid одинаковый id для того, чтобы одой формой менять им всем набор полей.
 * Опять же, каждой таблице свои поля - не работает, конфликтует
 * Так же багует кнопка раскрытия всех строк, раскрывает - норм, закрывает - норм и больше не работает
 */
\app\assets\TasksGridAsset::register($this);

$this->title = ArrayHelper::getValue(\Yii::$app->params, 'pageTitles.tasks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-index">

    <?php Pjax::begin(); ?>

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= DynaGrid::widget([
        'gridOptions' => [
            'dataProvider'      => $dataProvider,
            'summary'           => false,
            'showPageSummary'   => false,
            'toolbar'           => false,
            'pjax'              => true,
            'hover'             => true,
            'panel' => [
                'before'        => false,
                'after'         => false,
                'heading'       => $this->render('_gridview_heading', ['title' => $this->title]),
                'footer'        => false,
            ],
        ],
        'userSpecific'  => true,
        'storage'       => DynaGrid::TYPE_COOKIE,
        'options' => [
            'id'        => 'tasks-grid',
            'class'     => 'tasks-grid-main',
        ],
        'columns'       => require (__DIR__ . '/_gridview_columns_setup.php'),
    ]); ?>

    <?php Pjax::end(); ?>

</div>

