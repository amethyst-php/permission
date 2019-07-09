<?php

return [
    'comment'    => 'Role',
    'model'      => Amethyst\Models\Role::class,
    'schema'     => Amethyst\Schemas\RoleSchema::class,
    'repository' => Amethyst\Repositories\RoleRepository::class,
    'serializer' => Amethyst\Serializers\RoleSerializer::class,
    'validator'  => Amethyst\Validators\RoleValidator::class,
    'authorizer' => Amethyst\Authorizers\RoleAuthorizer::class,
    'faker'      => Amethyst\Fakers\RoleFaker::class,
    'manager'    => Amethyst\Managers\RoleManager::class,
];
