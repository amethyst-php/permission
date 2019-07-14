<?php

namespace Amethyst\Managers;

use Amethyst\Common\ConfigurableManager;
use Railken\Lem\Manager;

/**
 * @method \Amethyst\Models\Role newEntity()
 * @method \Amethyst\Schemas\RoleSchema getSchema()
 * @method \Amethyst\Repositories\RoleRepository getRepository()
 * @method \Amethyst\Serializers\RoleSerializer getSerializer()
 * @method \Amethyst\Validators\RoleValidator getValidator()
 * @method \Amethyst\Authorizers\RoleAuthorizer getAuthorizer()
 */
class RoleManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.permission.data.role';
}
