<?php

return [
    'comment'    => 'Role',
    'model'      => Railken\Amethyst\Models\Role::class,
    'schema'     => Railken\Amethyst\Schemas\RoleSchema::class,
    'repository' => Railken\Amethyst\Repositories\RoleRepository::class,
    'serializer' => Railken\Amethyst\Serializers\RoleSerializer::class,
    'validator'  => Railken\Amethyst\Validators\RoleValidator::class,
    'authorizer' => Railken\Amethyst\Authorizers\RoleAuthorizer::class,
    'faker'      => Railken\Amethyst\Fakers\RoleFaker::class,
    'manager'    => Railken\Amethyst\Managers\RoleManager::class,
];
