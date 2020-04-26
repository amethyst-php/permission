<?php

namespace Amethyst\Permissions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;
use Railken\EloquentMapper\Scopes\FilterScope;
use Railken\Lem\Agents;

class PermissionScope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     */
    public function apply($manager, $builder): void
    {
        $agent = $manager->getAgent();

        if ($agent instanceof Agents\SystemAgent) {
            return;
        }

        if (!$agent) {
            $agent = app('amethyst.permission.data')->guestUser();
        }

        $name = app('amethyst')->getNameDataByModel(get_class($builder->getModel()));

        // $tableName = $builder->getQuery()->from;
        $permissions = app('amethyst.permission.data')->getPermissionsByDataAndAction($agent, ['query'], [$name]);

        // No permissions means no authorization
        if ($permissions->count() === 0) {
            // i think this shit is bad.
            $builder->whereRaw('0 = 1');

            return;
        }

        $unfilteredPermissions = $permissions->filter(function ($permission) {
            return empty($permission->parsed->filter);
        });

        if ($unfilteredPermissions->count() > 0) {
            return;
        }

        $filteredPermissions = $permissions->filter(function ($permission) {
            return !empty($permission->parsed->filter);
        });

        $strFilter = $filteredPermissions->map(function ($permission) {
            return "( {$permission->parsed->filter} )";
        })->implode(' or ');

        $strFilter = app('amethyst.permission.data')->getDictionary()->getTemplate()->generateAndRender($strFilter, [
            'agent' => $agent,
        ]);

        $scope = new FilterScope();
        $scope->apply($builder, $strFilter);
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
