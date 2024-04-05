<?php

namespace Amethyst\Permissions;

use Amethyst\Models\Permission;
use nicoSWD\Rule\Parser\Exception\ParserException;
use nicoSWD\Rule\Rule;
use Railken\Lem\Contracts\AgentContract;

trait IsAgent
{
    /**
     * Return if the permission is related to the current agent.
     *
     * @param Permission    $model
     * @param AgentContract $agent
     *
     * @return bool
     */
    public function isRelatedAgent(Permission $model, AgentContract $agent): bool
    {
        if (empty($model->agent)) {
            return true;
        }

        $expression = $this->getDictionary()->getTemplate()->generateAndRender($model->agent, [
            'agent' => $agent,
        ]);

        try {
            $rule = new Rule($expression, []);

            return $rule->isTrue();
        } catch (ParserException $e) {
            return false;
        }
    }
}
