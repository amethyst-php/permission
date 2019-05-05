<?php

namespace Railken\Amethyst\Schemas;

use Railken\Amethyst\Managers;
use Railken\Lem\Attributes;
use Railken\Lem\Schema;

class RoleHasPermissionSchema extends Schema
{
    /**
     * Get all the attributes.
     *
     * @var array
     */
    public function getAttributes()
    {
        return [
            Attributes\IdAttribute::make(),
            Attributes\BelongsToAttribute::make('role_id')
                ->setRelationManager(Managers\RoleManager::class)
                ->setRelationName('role')
                ->setRequired(true),
            Attributes\BelongsToAttribute::make('permission_id')
                ->setRelationManager(Managers\PermissionManager::class)
                ->setRelationName('permission')
                ->setRequired(true),
            Attributes\CreatedAtAttribute::make(),
        ];
    }
}
