<?php

return [
    'comment'    => 'ModelHasPermission',
    'model'      => Amethyst\Models\ModelHasPermission::class,
    'schema'     => Amethyst\Schemas\ModelHasPermissionSchema::class,
    'repository' => Amethyst\Repositories\ModelHasPermissionRepository::class,
    'serializer' => Amethyst\Serializers\ModelHasPermissionSerializer::class,
    'validator'  => Amethyst\Validators\ModelHasPermissionValidator::class,
    'authorizer' => Amethyst\Authorizers\ModelHasPermissionAuthorizer::class,
    'faker'      => Amethyst\Fakers\ModelHasPermissionFaker::class,
    'manager'    => Amethyst\Managers\ModelHasPermissionManager::class,
];
