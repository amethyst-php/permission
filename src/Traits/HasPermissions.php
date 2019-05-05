<?php

namespace Railken\Amethyst\Traits;

trait HasCompoundPermissions 
{
    public function permissionsCompound(): MorphMany
    {
        return $this->permissions()->with('object_id', 'attribute');
    }
}