<?php

namespace Amethyst\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Railken\LaraEye\Filter;
use Railken\Lem\Agents\SystemAgent;
use Railken\Lem\Contracts\ManagerContract;
use Railken\EloquentMapper\Scopes\FilterScope;

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

        $filteredPermissions = $permissions->filter(function ($permission) {
            return !empty($permission->filter);
        });

        if ($filteredPermissions->count() === $permissions->count()) {
            $strFilter = $filteredPermissions->map(function ($permission) {
                return "( $permission->filter )";
            })->implode(' or ');

            $strFilter = app('amethyst.permission')->getTemplate()->generateAndRender($strFilter, [
                'agent' => $agent,
            ]);

            $filter = new FilterScope(
                function (Model $model) use ($manager) {
                    return app('amethyst')->newManagerByModel(
                        get_class($model), 
                        $manager->getAgent()
                    )->getAttributes()
                    ->map(function ($attribute) {
                        return $attribute->getName();
                    })->values()->toArray();
                },
                $strFilter
            );

            $filter->apply($builder, $manager->newEntity());
        }

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
