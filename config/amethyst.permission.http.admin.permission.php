<?php

return [
    'enabled'    => true,
    'controller' => Railken\Amethyst\Http\Controllers\Admin\PermissionsController::class,
    'router'     => [
        'as'     => 'permission.',
        'prefix' => '/permissions',
    ],
];
