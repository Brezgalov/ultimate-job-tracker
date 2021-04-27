<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
        NavBar::begin([
            'brandLabel' => '<i class="glyphicon glyphicon-menu-hamburger"></i>',
            'brandUrl' => null,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
            'innerContainerOptions' => [
                'class' => 'container-fluid',
            ],
        ]);

        $userName = \Yii::$app->user->identity->name;

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                "<li><a class='btn btn-link'>{$userName}</a></li>",
                '<li><a href="/logout"><i class="glyphicon glyphicon-log-out"></i></a></li>',
            ],
        ]);

        NavBar::end();
    ?>

    <div class="main-wrapper container-fluid">
        <?= Alert::widget() ?>
        <div class="row">
            <div class="sidebar-wrapper col-md-2">
                <?= $this->render('_sidebar') ?>
            </div>
            <div class="content-wrapper col-md-10">
                <div class="container-fluid">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>

                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
