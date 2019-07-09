<?php

return [
    'enabled'    => true,
    'controller' => Amethyst\Http\Controllers\Admin\PermissionsController::class,
    'router'     => [
        'as'     => 'permission.',
        'prefix' => '/permissions',
    ],
];
