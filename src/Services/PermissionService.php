<?php

namespace Amethyst\Services;

use Amethyst\Managers\PermissionManager;
use Railken\Cacheable\CacheableContract;
use Railken\Cacheable\CacheableTrait;
use Railken\Lem\Contracts\AgentContract;

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
        $permissionChecker = $agent->roles ? $agent->roles->map(function ($role) {
            return $role;
        }) : collect();
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
