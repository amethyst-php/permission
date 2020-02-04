<?php

namespace Amethyst\Permissions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Railken\EloquentMapper\Scopes\FilterScope;

class PermissionScope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     */
    public function apply($manager, $builder): void
    {
        $agent = Auth::user();

        if (!$agent) {
            return;
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
