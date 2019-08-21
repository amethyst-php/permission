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
            Attributes\TextAttribute::make('data')
                ->setDefault(function ($entity) {
                    return '*';
                })
                ->setRequired(true),
            Attributes\TextAttribute::make('attribute')
                ->setDefault(function ($entity) {
                    return '*';
                })
                ->setRequired(true),
            Attributes\TextAttribute::make('action')
                ->setDefault(function ($entity) {
                    return '*';
                })
                ->setRequired(true),
            Attributes\TextAttribute::make('filter'),
            Attributes\TextAttribute::make('agent'),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
        ];
    }
}
