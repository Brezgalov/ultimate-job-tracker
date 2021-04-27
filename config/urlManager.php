<?php

return [
    '/' => 'projects/index',
    'login' => 'auth/login',
    'logout' => 'auth/logout',

    'project/<slug>'        => 'projects/view',
    'project/<slug>/edit'   => 'projects/update',
];