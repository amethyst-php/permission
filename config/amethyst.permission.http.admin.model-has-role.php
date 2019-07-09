<?php

return [
    'enabled'    => true,
    'controller' => Amethyst\Http\Controllers\Admin\ModelHasRolesController::class,
    'router'     => [
        'as'     => 'model-has-role.',
        'prefix' => '/model-has-roles',
    ],
];
