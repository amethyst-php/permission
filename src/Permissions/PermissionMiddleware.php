<?php

namespace Amethyst\Permissions;

use Amethyst\Models\Permission;
use Closure;

class PermissionMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     */
    public function handle($request, Closure $next)
    {
        if (!app('amethyst.permission.route')->can($request)) {
            abort(404);
        }

        return $next($request);
    }
}
