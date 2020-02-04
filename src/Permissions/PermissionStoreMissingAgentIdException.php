<?php

namespace Amethyst\Permissions;

use Exception;

class PermissionStoreMissingAgentIdException extends Exception
{
    public function __construct()
    {
        parent::__construct("PermissionStore require a valid ID for agent");
    }
}
