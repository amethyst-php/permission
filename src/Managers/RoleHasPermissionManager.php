<?php

namespace Amethyst\Managers;

use Amethyst\Common\ConfigurableManager;
use Railken\Lem\Manager;

/**
 * @method \Amethyst\Models\RoleHasPermission                 newEntity()
 * @method \Amethyst\Schemas\RoleHasPermissionSchema          getSchema()
 * @method \Amethyst\Repositories\RoleHasPermissionRepository getRepository()
 * @method \Amethyst\Serializers\RoleHasPermissionSerializer  getSerializer()
 * @method \Amethyst\Validators\RoleHasPermissionValidator    getValidator()
 * @method \Amethyst\Authorizers\RoleHasPermissionAuthorizer  getAuthorizer()
 */
class RoleHasPermissionManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.permission.data.role-has-permission';
}
