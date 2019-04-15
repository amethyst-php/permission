<?php

return [
    'comment'    => 'Permission',
    'model'      => Railken\Amethyst\Models\Permission::class,
    'schema'     => Railken\Amethyst\Schemas\PermissionSchema::class,
    'repository' => Railken\Amethyst\Repositories\PermissionRepository::class,
    'serializer' => Railken\Amethyst\Serializers\PermissionSerializer::class,
    'validator'  => Railken\Amethyst\Validators\PermissionValidator::class,
    'authorizer' => Railken\Amethyst\Authorizers\PermissionAuthorizer::class,
    'faker'      => Railken\Amethyst\Fakers\PermissionFaker::class,
    'manager'    => Railken\Amethyst\Managers\PermissionManager::class,
];
