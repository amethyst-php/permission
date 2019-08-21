<?php

namespace Amethyst\Tests;

use Amethyst\Traits\PermissionTrait;
use Railken\Lem\Contracts\AgentContract;

class Agent implements AgentContract
{
    use PermissionTrait;
    public $id;

    public function __construct($id = 1)
    {
        $this->id = $id;
    }
}
