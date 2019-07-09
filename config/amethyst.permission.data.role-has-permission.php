<?php

return [
    'comment'    => 'RoleHasPermission',
    'model'      => Amethyst\Models\RoleHasPermission::class,
    'schema'     => Amethyst\Schemas\RoleHasPermissionSchema::class,
    'repository' => Amethyst\Repositories\RoleHasPermissionRepository::class,
    'serializer' => Amethyst\Serializers\RoleHasPermissionSerializer::class,
    'validator'  => Amethyst\Validators\RoleHasPermissionValidator::class,
    'authorizer' => Amethyst\Authorizers\RoleHasPermissionAuthorizer::class,
    'faker'      => Amethyst\Fakers\RoleHasPermissionFaker::class,
    'manager'    => Amethyst\Managers\RoleHasPermissionManager::class,
];
