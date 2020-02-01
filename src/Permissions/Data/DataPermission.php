<?php

namespace Amethyst\Permissions\Data;

use Amethyst\Managers\PermissionManager;
use Amethyst\Models\Permission;
use Illuminate\Support\Facades\Cache;
use nicoSWD\Rules\Rule;
use Railken\Lem\Contracts\AgentContract;
use Railken\Template\Generators;
use Symfony\Component\Yaml\Yaml;

class DataPermission
{
    /**
     * Get permission.
     *
     * @param array         $parameters
     * @param AgentContract $agent
     *
     * @return bool
     */
    public function valid(array $parameters, AgentContract $agent)
    {
        if (!$this->permissions) {
            return collect();
        }

        return $this->permissions->filter(function (Permission $model) use ($names, $actions, $agent) {

            if (!array_intersect(array_merge([$this->wildcard], $names), $this->parsePayload($model->payload->data)))) {
                return false;
            }

            if (!array_intersect(array_merge([$this->wildcard], $actions), $this->parsePayload($model->payload->action)))) {
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
}
