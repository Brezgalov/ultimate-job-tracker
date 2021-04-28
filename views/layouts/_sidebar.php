<?php

use yii\helpers\ArrayHelper;

/* @var $identity \app\models\Users */


$identity = \Yii::$app->user->identity;

$defaultProjectSlug = $identity->getDefaultProjectSlug();

$items = [
    0 => [
        'label' => '<i class="icon glyphicon glyphicon-th-large"></i><span class="text">' .
            ArrayHelper::getValue(\Yii::$app->params, 'pageTitles.projects') .
            '</span>',
        'url' => '/projects',
    ],
    1 => [
        'label' => '<i class="icon glyphicon glyphicon-list"></i><span class="text">Задачи</span>',
        'url' => '/tasks',
    ],
    2 => [
        'label' => '<i class="icon glyphicon glyphicon-object-align-top"></i><span class="text">Kanban</span>',
        'url' => "/project/{$defaultProjectSlug}/kanban",
    ],
    3 => [
        'label' => '<i class="glyphicon glyphicon-user"></i><span class="text">Пользователи</span>',
        'url' => '/users',
    ],
    4 => [
        'label' => '<i class="icon glyphicon glyphicon-wrench"></i><span class="text">Настройки</span>',
        'url' => '/',
    ],
];

if (empty($defaultProjectSlug)) {
    unlink($items[2]);
}

?>

<div class="sidebar-items">
    <?php foreach ($items as $itemData): ?>
        <div class="sidebar-item">
            <a href="<?= $itemData['url'] ?>"><?= $itemData['label'] ?></a>
        </div>
    <?php endforeach; ?>
</div>
