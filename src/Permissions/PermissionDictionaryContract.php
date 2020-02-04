<?php

namespace Amethyst\Permissions;

use Amethyst\Managers\PermissionManager;
use Amethyst\Models\Permission;
use Illuminate\Support\Facades\Cache;
use nicoSWD\Rules\Rule;
use Railken\Lem\Contracts\AgentContract;
use Railken\Template\Generators;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Database\Eloquent\Model;

interface PermissionDictionaryContract
{

}
