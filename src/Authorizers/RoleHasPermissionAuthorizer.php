<?php

namespace Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class RoleHasPermissionAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'role-has-permission.create',
        Tokens::PERMISSION_UPDATE => 'role-has-permission.update',
        Tokens::PERMISSION_SHOW   => 'role-has-permission.show',
        Tokens::PERMISSION_REMOVE => 'role-has-permission.remove',
    ];
}
