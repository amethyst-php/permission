<?php

namespace Amethyst\Managers;

use Amethyst\Common\ConfigurableManager;
use Railken\Lem\Manager;

/**
 * @method \Amethyst\Models\ModelHasRole newEntity()
 * @method \Amethyst\Schemas\ModelHasRoleSchema getSchema()
 * @method \Amethyst\Repositories\ModelHasRoleRepository getRepository()
 * @method \Amethyst\Serializers\ModelHasRoleSerializer getSerializer()
 * @method \Amethyst\Validators\ModelHasRoleValidator getValidator()
 * @method \Amethyst\Authorizers\ModelHasRoleAuthorizer getAuthorizer()
 */
class ModelHasRoleManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.permission.data.model-has-role';
}
