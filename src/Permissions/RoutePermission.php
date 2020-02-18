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
    public function can(Model $agent, Request $request)
    {
        $store = $this->store->get($agent, $this->getPrimaryKeyByRequest($request));

        if (is_bool($store)) {
            return $store;
        }

        $permissions = $this->permissions($agent)->first(function (Permission $model) use ($request) {
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

        if (!$this->invalidUrl($request->url(), $url)) {
            return false;
        }

        $method = $this->parsePayload($payload->method);

        if (!$this->invalidMethod($request->url(), $method)) {
            return false;
        }

        return true;
    }

    public function invalidUrl(string $needle, array $container): bool
    {
        foreach ($container as $item) {
            if (preg_match('/'.$item.'/', $needle)) {
                return true;
            }
        }

        return false;
    }

    public function invalidMethod(string $needle, array $container): bool
    {
        if (count($needle) === 0) {
            return false;
        }

        if ($needle[0] === '*') {
            return true;
        }

        if (in_array($needle, $container, true)) {
            return true;
        }

        return false;
    }
}
