<?php

namespace Amethyst\Permissions;

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
