<?php

namespace Amethyst\Tests;

use Railken\Lem\Contracts\AgentContract;
use Amethyst\Traits\PermissionTrait;

class Agent implements AgentContract
{
	public $id = 1;
	
    use PermissionTrait;
}
