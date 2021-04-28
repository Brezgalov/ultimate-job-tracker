<?php

use yii\helpers\ArrayHelper;

$items = [
    [
        'label' => '<i class="icon glyphicon glyphicon-th-large"></i><span class="text">' .
            ArrayHelper::getValue(\Yii::$app->params, 'pageTitles.projects') .
            '</span>',
        'url' => '/projects',
    ],
    [
        'label' => '<i class="icon glyphicon glyphicon-list"></i><span class="text">Задачи</span>',
        'url' => '/tasks',
    ],
    [
        'label' => '<i class="icon glyphicon glyphicon-object-align-top"></i><span class="text">Kanban</span>',
        'url' => '/tasks',
    ],
    [
        'label' => '<i class="glyphicon glyphicon-user"></i><span class="text">Пользователи</span>',
        'url' => '/users',
    ],
    [
        'label' => '<i class="icon glyphicon glyphicon-wrench"></i><span class="text">Настройки</span>',
        'url' => '/',
    ],
];
?>

<div class="sidebar-items">
    <?php foreach ($items as $itemData): ?>
        <div class="sidebar-item">
            <a href="<?= $itemData['url'] ?>"><?= $itemData['label'] ?></a>
        </div>
    <?php endforeach; ?>
</div>
