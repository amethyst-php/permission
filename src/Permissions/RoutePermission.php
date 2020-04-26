<?php

namespace Amethyst\Permissions;

use Amethyst\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RoutePermission extends BasePermission
{
    /**
     * Has the agent the correct permission?
     *
     * @param Model   $agent
     * @param Request $request
     *
     * @return bool
     */
    public function can(Model $agent = null, Request $request)
    {
        if ($agent === null) {
            $agent = $this->guestUser();
        }

        $store = $this->store->get($agent, $this->getPrimaryKeyByRequest($request));

        if (is_bool($store)) {
            return $store;
        }

        $permissions = $this->permissions($agent, ['route'])->first(function (Permission $model) use ($request) {
            return $this->isRelatedPermission($model, $request);
        });

        $this->store->set($agent, $this->getPrimaryKeyByRequest($request), $permissions !== null);

        return $permissions !== null;
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function getPrimaryKeyByRequest(Request $request): string
    {
        return $request->method().'|'.$request->url();
    }

    /**
     * is related permission.
     *
     * @param Permission $model
     * @param Request    $request
     *
     * @return bool
     */
    public function isRelatedPermission(Permission $model, Request $request): bool
    {
        $payload = $model->parsed;

        $url = $this->parsePayload($payload->url);

        if (!$this->validUrl($request->path(), $url)) {
            return false;
        }

        $method = $this->parsePayload($payload->method ?? '*');

        if (!$this->validMethod($request->method(), $method)) {
            return false;
        }

        return true;
    }

    public function validUrl(string $needle, array $container): bool
    {
        if (!is_array($container)) {
            $container = [$container];
        }

        if (count($container) === 0) {
            return false;
        }

        if ($container[0] === '*') {
            return true;
        }

        foreach ($container as $item) {
            if (preg_match('/^'.str_replace('/', "\/", $this->normalizePath($item)).'$/', $this->normalizePath($needle))) {
                return true;
            }
        }

        return false;
    }

    public function normalizePath(string $i)
    {
        return $i[0] !== '/' ? '/'.$i : $i;
    }

    public function validMethod(string $needle, array $container): bool
    {
        if (!is_array($container)) {
            $container = [$container];
        }

        if (count($container) === 0) {
            return false;
        }

        if ($container[0] === '*') {
            return true;
        }

        if (in_array($needle, $container, true)) {
            return true;
        }

        return false;
    }
}
