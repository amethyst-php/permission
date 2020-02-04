<?php

namespace Amethyst\Tests;

use Amethyst\Traits\PermissionTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Railken\Lem\Contracts\AgentContract;

class Agent extends Authenticatable implements AgentContract
{
    use PermissionTrait;

    public $fillable = ['id'];
}
