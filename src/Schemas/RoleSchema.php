<?php

namespace Railken\Amethyst\Schemas;

use Railken\Lem\Attributes;
use Railken\Lem\Schema;

class RoleSchema extends Schema
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
            Attributes\TextAttribute::make('name')
                ->setRequired(true)
                ->setUnique(true),
            Attributes\TextAttribute::make('guard_name')
                ->setRequired(true)
                ->setUnique(true),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make()
        ];
    }
}
