<?php

namespace Railken\Amethyst\Traits;

trait HasPermissions 
{
    public function permissionsPivoted(): MorphMany
    {
        return $this->permissions()->with('object_id', 'attribute');
    }
}