<?php

namespace Railken\Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class ModelHasRoleAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'model-has-role.create',
        Tokens::PERMISSION_UPDATE => 'model-has-role.update',
        Tokens::PERMISSION_SHOW   => 'model-has-role.show',
        Tokens::PERMISSION_REMOVE => 'model-has-role.remove',
    ];
}
