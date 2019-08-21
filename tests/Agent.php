<?php

namespace Amethyst\Tests;

use Railken\Lem\Contracts\AgentContract;
use Amethyst\Traits\PermissionTrait;

class Agent implements AgentContract
{
	public $id;

    use PermissionTrait;

    public function __construct($id = 1)
    {
    	$this->id = $id;
    }
}
