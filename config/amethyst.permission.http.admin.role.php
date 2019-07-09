<?php

return [
    'enabled'    => true,
    'controller' => Amethyst\Http\Controllers\Admin\RolesController::class,
    'router'     => [
        'as'     => 'role.',
        'prefix' => '/roles',
    ],
];
