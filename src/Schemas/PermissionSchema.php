<?php

namespace Amethyst\Schemas;

use Railken\Lem\Attributes;
use Railken\Lem\Schema;

class PermissionSchema extends Schema
{
    /**
     * Get all the attributes.
     *
     * @var array
     */
    public function getAttributes()
    {
        return [
            Attributes\UuidAttribute::make('id'),
            Attributes\EnumAttribute::make('effect', ['allow', 'deny'])
                ->setRequired(true),
            Attributes\EnumAttribute::make('type', ['data', 'route'])
                ->setRequired(true),
            Attributes\YamlAttribute::make('payload')
                ->setRequired(true),
            Attributes\TextAttribute::make('agent'),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
        ];
    }
}
