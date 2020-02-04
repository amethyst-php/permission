<?php

namespace Amethyst\Tests;

use Amethyst\Traits\PermissionTrait;
use Railken\Lem\Contracts\AgentContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Agent extends Authenticatable implements AgentContract
{
    use PermissionTrait;

    public $fillable = ['id'];
}
