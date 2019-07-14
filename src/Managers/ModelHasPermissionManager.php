<?php

namespace Amethyst\Managers;

use Amethyst\Common\ConfigurableManager;
use Railken\Lem\Manager;

/**
 * @method \Amethyst\Models\ModelHasPermission                 newEntity()
 * @method \Amethyst\Schemas\ModelHasPermissionSchema          getSchema()
 * @method \Amethyst\Repositories\ModelHasPermissionRepository getRepository()
 * @method \Amethyst\Serializers\ModelHasPermissionSerializer  getSerializer()
 * @method \Amethyst\Validators\ModelHasPermissionValidator    getValidator()
 * @method \Amethyst\Authorizers\ModelHasPermissionAuthorizer  getAuthorizer()
 */
class ModelHasPermissionManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.permission.data.model-has-permission';
}
