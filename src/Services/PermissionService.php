<?php

namespace Amethyst\Services;

use Railken\Template\Generators;
use Amethyst\Managers\PermissionManager;
use Illuminate\Support\Facades\Cache;
use Amethyst\Models\Permission;
use nicoSWD\Rules\Rule;
use Railken\Lem\Contracts\AgentContract;

class PermissionService
{
    /**
     * @var \Railken\Template\Generators\TextGenerator
     */
    protected $template;

    /**
     * @var \Amethyst\Managers\PermissionManager
     */
    protected $manager;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $permissions;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $cached;

    /**
     * @var string
     */
    protected $separator = "|";

    /**
     * @var string
     */
    protected $wildcard = "*";

    public function __construct()
    {
        $this->template = new Generators\TextGenerator();
        $this->manager = new PermissionManager();
        $this->permission = collect();
    }

    /**
     * @return Generators\TextGenerator
     */
    public function getTemplate(): Generators\TextGenerator
    {
        return $this->template;
    }

    /**
     * Boot all permissions
     */
    public function boot()
    {
        $this->permissions = $this->manager->getRepository()->findBy([]);

        $this->cached = Cache::get('permissions');
    }

    /**
     * Get permission.
     *
     * @param array $names
     * @param array $actions
     * @param AgentContract $agent
     *
     * @return bool
     */
    public function permissions(array $names, array $actions, AgentContract $agent)
    {
        return $this->permissions->filter(function (Permission $model) use ($names, $actions, $agent) {


            if (!array_intersect(array_merge([$this->wildcard], $names), explode($this->separator, $model->data))) {
                return false;
            }

            if (!array_intersect(array_merge([$this->wildcard], $actions), explode($this->separator, $model->action))) {
                return false;
            }

            if (empty($model->agent)) {
                return true;
            }

            $expression = $this->template->generateAndRender($model->agent, [
                'agent' => $agent,
            ]);

            $rule = new Rule($expression, []);

            return $rule->isTrue();
        });
    }


    /**
     * Has permission.
     *
     * @param AgentContract $agent
     * @param string $permission
     * @param array  $arguments
     *
     * @return bool
     */
    public function can($agent, $permission, $arguments = [])
    {
        $permission = $this->permissions->first(function (Permission $model) use ($agent, $permission) {

            $permissions = $this->explodePermissions($model);

            if (!$this->discovery($permission, $permissions)) {
                return false;
            }

            if (empty($model->agent)) {
                return true;
            }

            $expression = $this->template->generateAndRender($model->agent, [
                'agent' => $agent,
            ]);

            $rule = new Rule($expression, []);

            return $rule->isTrue();
        });
        
        if ($permission) {
            return true;
        }

        return false;
    }

    /**
     * Discovery
     *
     * @param string $permission
     * @param array $permissions
     *
     * @return boolean
     */
    public function discovery($permission, $permissions)
    {
        $pp = explode(".", $permission);
        foreach ($permissions as $p) {
            if ($permission == $p) {
                return true;
            }
            $p = explode(".", $p);
            foreach ($p as $k => $in) {
                if ($in == '*') {
                    return true;
                }
                if (!isset($pp[$k])) {
                    break;
                }
                if ($pp[$k] != $in) {
                    break;
                }
            }
        }
        return false;
    }

    public function explodePermissions(Permission $model)
    {
        $r = [];

        foreach (explode("|", $model->data) as $data) {
            $r = array_merge(
                $r,
                [$data],
                preg_filter('/^/', $data . '.', explode("|", $model->action))
            );
        }

        return $r;
    }

}
