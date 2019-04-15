<?php

return [
    'enabled'    => true,
    'controller' => Railken\Amethyst\Http\Controllers\Admin\RolesController::class,
    'router'     => [
        'as'     => 'role.',
        'prefix' => '/roles',
    ],
];
