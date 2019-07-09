<?php

return [
    'enabled'    => true,
    'controller' => Amethyst\Http\Controllers\Admin\ModelHasPermissionsController::class,
    'router'     => [
        'as'     => 'model-has-permission.',
        'prefix' => '/model-has-permissions',
    ],
];
