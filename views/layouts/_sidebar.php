<?php
$items = [
    [
        'label' => '<i class="icon glyphicon glyphicon-list-alt"></i><span class="text">Проекты</span>',
        'url' => '/projects',
    ],
    [
        'label' => '<i class="icon glyphicon glyphicon-list"></i><span class="text">Задачи</span>',
        'url' => '/',
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
