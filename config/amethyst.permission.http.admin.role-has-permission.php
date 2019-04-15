<?php

return [
    'enabled'    => true,
    'controller' => Railken\Amethyst\Http\Controllers\Admin\RoleHasPermissionsController::class,
    'router'     => [
        'as'     => 'role-has-permission.',
        'prefix' => '/role-has-permissions',
    ],
];
