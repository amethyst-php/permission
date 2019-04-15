<?php

namespace Railken\Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class PermissionAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'permission.create',
        Tokens::PERMISSION_UPDATE => 'permission.update',
        Tokens::PERMISSION_SHOW   => 'permission.show',
        Tokens::PERMISSION_REMOVE => 'permission.remove',
    ];
}
