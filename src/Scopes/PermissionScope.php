<?php

namespace Amethyst\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Railken\LaraEye\Filter;
use Railken\Lem\Agents\SystemAgent;
use Railken\Lem\Contracts\ManagerContract;

class PermissionScope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     */
    public function apply(ManagerContract $manager, Builder $builder, Model $model = null): void
    {
        $agent = $manager->getAgent();

        if ($agent instanceof SystemAgent) {
            return;
        }

        $name = app('amethyst')->tableize($manager->getEntity());

        $tableName = $builder->getQuery()->from;

        $permissions = app('amethyst.permission')->permissions([$name], ['query'], $agent);

        // No permissions means no query
        if ($permissions->count() === 0) {
            // i think this shit is bad.
            $builder->whereRaw('0 = 1');
        }

        $filter = new Filter($tableName, ['*']);

        $strFilter = $permissions->filter(function ($permission) {
            return !empty($permission->filter);
        })->map(function ($permission) {
            return "( $permission->filter )";
        })->implode(' or ');

        $filter->build($builder, app('amethyst.permission')->getTemplate()->generateAndRender($strFilter, [
            'agent' => $agent,
        ]));

        /*
        $select = [];

        foreach ($manager->getAttributes() as $attribute) {
            $n = $attribute->getName();
            $selects[] = "CASE WHEN CONCAT(',', p.attribute, ',') like '%,$n,%' THEN $tableName.$n ELSE null END as `$n`";
        }

        $query->select(DB::raw(implode(',', $selects)));

        // id must be present at least.
        $query->whereRaw(DB::raw("CONCAT(',', p.attribute, ',') like '%,id,%'"));
        */
    }
}
