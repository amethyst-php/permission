<?php

namespace Amethyst\Permissions;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     */
    public function handle($request, Closure $next)
    {
        if (!app('amethyst.permission.route')->can(Auth::user(), $request)) {
            abort(404);
        }

        return $next($request);
    }
}
