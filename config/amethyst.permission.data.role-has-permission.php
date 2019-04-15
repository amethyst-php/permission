<?php

return [
    'comment'    => 'RoleHasPermission',
    'model'      => Railken\Amethyst\Models\RoleHasPermission::class,
    'schema'     => Railken\Amethyst\Schemas\RoleHasPermissionSchema::class,
    'repository' => Railken\Amethyst\Repositories\RoleHasPermissionRepository::class,
    'serializer' => Railken\Amethyst\Serializers\RoleHasPermissionSerializer::class,
    'validator'  => Railken\Amethyst\Validators\RoleHasPermissionValidator::class,
    'authorizer' => Railken\Amethyst\Authorizers\RoleHasPermissionAuthorizer::class,
    'faker'      => Railken\Amethyst\Fakers\RoleHasPermissionFaker::class,
    'manager'    => Railken\Amethyst\Managers\RoleHasPermissionManager::class,
];
