<?php

return [
    'enabled'    => true,
    'controller' => Amethyst\Http\Controllers\Admin\RoleHasPermissionsController::class,
    'router'     => [
        'as'     => 'role-has-permission.',
        'prefix' => '/role-has-permissions',
    ],
];
