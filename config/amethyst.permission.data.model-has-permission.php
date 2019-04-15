<?php

return [
    'comment'    => 'ModelHasPermission',
    'model'      => Railken\Amethyst\Models\ModelHasPermission::class,
    'schema'     => Railken\Amethyst\Schemas\ModelHasPermissionSchema::class,
    'repository' => Railken\Amethyst\Repositories\ModelHasPermissionRepository::class,
    'serializer' => Railken\Amethyst\Serializers\ModelHasPermissionSerializer::class,
    'validator'  => Railken\Amethyst\Validators\ModelHasPermissionValidator::class,
    'authorizer' => Railken\Amethyst\Authorizers\ModelHasPermissionAuthorizer::class,
    'faker'      => Railken\Amethyst\Fakers\ModelHasPermissionFaker::class,
    'manager'    => Railken\Amethyst\Managers\ModelHasPermissionManager::class,
];
