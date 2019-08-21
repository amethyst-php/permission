<?php

namespace Amethyst\Tests;

use Railken\Lem\Agents\SystemAgent;
use Amethyst\Traits\PermissionTrait;

class Agent extends SystemAgent
{
    use PermissionTrait;
}
