<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Projects;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ProjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ArrayHelper::getValue(\Yii::$app->params, 'pageTitles.projects');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="projects-index">

    <h1>
        <?= Html::encode($this->title) ?>
        <a href="/project/create"><i class="glyphicon glyphicon-plus"></i></a>
    </h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'showHeader' => false,
        'dataProvider' => $dataProvider,
        'columns' => [
            'name' => [
                'format' => 'raw',
                'value' => function(Projects $model) {
                    return Html::a($model->name, ["project/{$model->slug}"]);
                }
            ],
            'created_at' => [
                'value' => function(Projects $model) {
                    return date('d.m.Y', $model->created_at);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
