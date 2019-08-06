<?php

namespace Amethyst\Schemas;

use Amethyst\Managers;
use Railken\Lem\Attributes;
use Railken\Lem\Contracts\EntityContract;
use Railken\Lem\Schema;

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
            Attributes\EnumAttribute::make('object_type', app('amethyst')->getMorphListable('model-has-permission', 'object'))
                ->setRequired(true),
            Attributes\MorphToAttribute::make('object_id')
                ->setRelationKey('object_type')
                ->setRelationName('object')
                ->setRelations(app('amethyst')->getMorphRelationable('model-has-permission', 'object'))
                ->setRequired(false),
            Attributes\TextAttribute::make('attribute')->setDefault(function (EntityContract $entity) {

                if (!$entity->object_type) {
                    return [];
                }
                
                $manager = app(app('amethyst')->findManagerByName($entity->object_type));

                return $manager->getAttributes()->map(function ($attribute) {
                    return $attribute->getName();
                })->implode(',');
            })->setMaxLength(4096),
            Attributes\CreatedAtAttribute::make(),
        ];
    }
}
