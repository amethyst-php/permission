<?php

return [
    'comment'    => 'ModelHasRole',
    'model'      => Railken\Amethyst\Models\ModelHasRole::class,
    'schema'     => Railken\Amethyst\Schemas\ModelHasRoleSchema::class,
    'repository' => Railken\Amethyst\Repositories\ModelHasRoleRepository::class,
    'serializer' => Railken\Amethyst\Serializers\ModelHasRoleSerializer::class,
    'validator'  => Railken\Amethyst\Validators\ModelHasRoleValidator::class,
    'authorizer' => Railken\Amethyst\Authorizers\ModelHasRoleAuthorizer::class,
    'faker'      => Railken\Amethyst\Fakers\ModelHasRoleFaker::class,
    'manager'    => Railken\Amethyst\Managers\ModelHasRoleManager::class,
];
