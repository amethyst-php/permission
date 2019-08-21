<?php

return [
    'table'      => 'amethyst_permissions',
    'comment'    => 'Permission',
    'model'      => Amethyst\Models\Permission::class,
    'schema'     => Amethyst\Schemas\PermissionSchema::class,
    'repository' => Amethyst\Repositories\PermissionRepository::class,
    'serializer' => Amethyst\Serializers\PermissionSerializer::class,
    'validator'  => Amethyst\Validators\PermissionValidator::class,
    'authorizer' => Amethyst\Authorizers\PermissionAuthorizer::class,
    'faker'      => Amethyst\Fakers\PermissionFaker::class,
    'manager'    => Amethyst\Managers\PermissionManager::class,
];
