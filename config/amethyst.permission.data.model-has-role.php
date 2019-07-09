<?php

return [
    'comment'    => 'ModelHasRole',
    'model'      => Amethyst\Models\ModelHasRole::class,
    'schema'     => Amethyst\Schemas\ModelHasRoleSchema::class,
    'repository' => Amethyst\Repositories\ModelHasRoleRepository::class,
    'serializer' => Amethyst\Serializers\ModelHasRoleSerializer::class,
    'validator'  => Amethyst\Validators\ModelHasRoleValidator::class,
    'authorizer' => Amethyst\Authorizers\ModelHasRoleAuthorizer::class,
    'faker'      => Amethyst\Fakers\ModelHasRoleFaker::class,
    'manager'    => Amethyst\Managers\ModelHasRoleManager::class,
];
