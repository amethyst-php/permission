<?php

namespace Railken\Amethyst\Services;

use Railken\Amethyst\Managers\PermissionManager;
use Railken\Lem\Contracts\AgentContract;
use Railken\Cacheable\CacheableTrait;
use Railken\Cacheable\CacheableContract;

class PermissionService implements CacheableContract
{
    use CacheableTrait;

	protected $manager;

	public function __construct(PermissionManager $manager)
	{
		$this->manager = $manager;
	}

    public function findFirstPermissionByPolicy(AgentContract $agent, string $permission)
    {
    	$permissionChecker = $agent->roles->map(function ($role) {
    		return $role;
    	});
    	$permissionChecker->push($agent);

    	foreach ($permissionChecker as $checker) {

    		$p = $checker->permissions()->where('name', $permission)->withPivot('object_id', 'attribute')->first();

    		if (!empty($p->pivot->attribute)) {
    			return $p;
    		}

    	}

    	return null;
    }
}