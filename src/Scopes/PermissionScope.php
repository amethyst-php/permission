<?php

namespace Amethyst\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Railken\Lem\Contracts\ManagerContract;
use Railken\Lem\Agents\SystemAgent;
use Railken\LaraEye\Filter;

class PermissionScope implements Scope
{
	/**
	 * @var \Railken\Lem\Contracts\ManagerContract
	 */
	protected $manager;

	/**
	 * Constructor
	 */
	public function __construct(ManagerContract $manager)
	{
		$this->manager = $manager;
	}

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     */
    public function apply(Builder $builder, Model $model = null): void
    {
        $agent = $this->manager->getAgent();

        if ($agent instanceof SystemAgent) {
            return;
        }

        $name = app('amethyst')->tableize($this->manager->getEntity());

        $tableName = $builder->getQuery()->from;

        $permissions = app('amethyst.permission')->permissions([$name], $agent);

        // No permissions means no query
        if ($permissions->count() === 0) {

        	// i think this shit is bad.
        	$builder->whereRaw('0 = 1');
        }


	    $filter = new Filter($tableName, ['*']);

        foreach ($permissions as $permission) {

	        $filter->build($builder, app('amethyst.permission')->getTemplate()->generateAndRender($permission->filter, [
	        	'agent' => $agent
	        ]));
        	// Apply permission for EACH 
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