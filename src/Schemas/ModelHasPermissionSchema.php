<?php

namespace Railken\Amethyst\Schemas;

use Railken\Lem\Attributes;
use Railken\Lem\Schema;
use Railken\Amethyst\Managers;

class ModelHasPermissionSchema extends Schema
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
            Attributes\EnumAttribute::make('model_type', app('amethyst')->getMorphListable('model-has-permission', 'model'))
                ->setRequired(true),
            Attributes\MorphToAttribute::make('model_id')
                ->setRelationKey('model_type')
                ->setRelationName('model')
                ->setRelations(app('amethyst')->getMorphRelationable('model-has-permission', 'model'))
                ->setRequired(true),
            Attributes\BelongsToAttribute::make('permission_id')
                ->setRelationManager(Managers\PermissionManager::class)
                ->setRelationName('permission')
                ->setRequired(true),
            Attributes\CreatedAtAttribute::make()
        ];
    }
}
