<?php

namespace Amethyst\Services;

use Amethyst\Managers\PermissionManager;
use Amethyst\Models\Permission;
use Illuminate\Support\Facades\Cache;
use nicoSWD\Rules\Rule;
use Railken\Lem\Contracts\AgentContract;
use Railken\Template\Generators;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\Auth;

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
    protected $separator = ',';

    /**
     * @var string
     */
    protected $wildcard = '*';

    public function __construct()
    {
        $this->template = new Generators\TextGenerator();
        $this->manager = new PermissionManager();
        $this->permissions = collect();
    }

    /**
     * @return Generators\TextGenerator
     */
    public function getTemplate(): Generators\TextGenerator
    {
        return $this->template;
    }

    /**
     * Boot all permissions.
     */
    public function boot()
    {
        $this->permissions = $this->manager->getRepository()->findBy([])->filter(function ($permission) {
            $permission->payload = Yaml::parse($permission->payload);
        })

        $this->cached = Cache::get('permissions');
    }

    public function getAgent()
    {
        return Auth::user();
    }

    /**
     * Get permission.
     *
     * @param array         $parameters
     *
     * @return bool
     */
    public function permissions(array $parameters)
    {
        if (!$this->permissions) {
            return collect();
        }

        return $this->permissions->filter(function (Permission $model) use ($parameters) {

            $type = $this->types[$model->type];
            
            if (!$type->valid($model->payload, $parameters)) {
                return false;
            }

            if ($model->agent) {
                $expression = $this->template->generateAndRender($model->agent, [
                    'agent' => $this->getAgent(),
                ]);

                $rule = new Rule($expression, []);

                if(!$rule->isTrue()) {
                    return false;
                }
            }

            return false;
        });
    }

    /**
     * Has permission.
     *
     * @param AgentContract $agent
     * @param string        $permission
     * @param array         $arguments
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
     * Discovery.
     *
     * @param string $permission
     * @param array  $permissions
     *
     * @return bool
     */
    public function discovery($permission, $permissions)
    {
        $pp = explode('.', $permission);
        foreach ($permissions as $p) {
            if ($permission == $p) {
                return true;
            }
            $p = explode('.', $p);
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

    public function parsePayload($attr): array
    {
        return !is_array($attr) ? [$attr] : $attr;
    }

    public function explodePermissions(Permission $model)
    {
        $r = [];

        foreach ($this->parsePayload($model->payload->data) as $data) {
            $r = array_merge(
                $r,
                [$data],
                preg_filter('/^/', $data.'.', $this->parsePayload($model->payload->action)))
            );
        }

        return $r;
    }
}
