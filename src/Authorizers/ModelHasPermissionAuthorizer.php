<?php

namespace Railken\Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class ModelHasPermissionAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'model-has-permission.create',
        Tokens::PERMISSION_UPDATE => 'model-has-permission.update',
        Tokens::PERMISSION_SHOW   => 'model-has-permission.show',
        Tokens::PERMISSION_REMOVE => 'model-has-permission.remove',
    ];
}
