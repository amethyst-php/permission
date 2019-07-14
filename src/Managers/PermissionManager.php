<?php

namespace Amethyst\Managers;

use Amethyst\Common\ConfigurableManager;
use Railken\Lem\Manager;

/**
 * @method \Amethyst\Models\Permission newEntity()
 * @method \Amethyst\Schemas\PermissionSchema getSchema()
 * @method \Amethyst\Repositories\PermissionRepository getRepository()
 * @method \Amethyst\Serializers\PermissionSerializer getSerializer()
 * @method \Amethyst\Validators\PermissionValidator getValidator()
 * @method \Amethyst\Authorizers\PermissionAuthorizer getAuthorizer()
 */
class PermissionManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.permission.data.permission';
}
