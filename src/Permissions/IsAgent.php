<?php

namespace Amethyst\Permissions;

use Amethyst\Models\Permission;
use Illuminate\Support\Facades\Cache;
use nicoSWD\Rules\Rule;
use Railken\Lem\Contracts\AgentContract;
use Railken\Template\Generators;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Database\Eloquent\Model;

trait IsAgent
{
    /**
     * Return if the permission is related to the current agent
     *
     * @param Permission $model
     * @param Model $agent
     *
     * @return bool
     */
    public function isRelatedAgent(Permission $model, Model $agent): bool
    {
        if (empty($model->agent)) {
            return true;
        }

        $expression = $this->getDictionary()->getTemplate()->generateAndRender($model->agent, [
            'agent' => $agent,
        ]);

        $rule = new Rule($expression, []);

        return $rule->isTrue();
    }
}
