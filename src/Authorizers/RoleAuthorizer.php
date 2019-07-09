<?php

namespace Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class RoleAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'role.create',
        Tokens::PERMISSION_UPDATE => 'role.update',
        Tokens::PERMISSION_SHOW   => 'role.show',
        Tokens::PERMISSION_REMOVE => 'role.remove',
    ];
}
