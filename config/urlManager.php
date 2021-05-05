<?php

return [
    '/' => 'projects/index',
    'login' => 'auth/login',
    'logout' => 'auth/logout',

    'task/create'           => 'tasks/create',
    'task/<id>'             => 'tasks/update',
    'task/<id>/children'    => 'tasks/children',

    'project/create'        => 'projects/create',
    'project/<slug>'        => 'projects/view',
    'project/<slug>/edit'   => 'projects/update',
    'project/<slug>/kanban' => 'projects/kanban',
];