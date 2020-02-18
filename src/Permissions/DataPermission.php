<?php

namespace Amethyst\Permissions;

use Amethyst\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class DataPermission extends BasePermission
{
    /**
     * Has the agent the correct permission?
     *
     * @param Model  $agent
     * @param string $permission
     * @param array  $arguments
     *
     * @return bool
     */
    public function can(Model $agent, string $permission, array $arguments = [])
    {
        $store = $this->store->get($agent, $permission);

        if (is_bool($store)) {
            return $store;
        }

        $permissions = $this->permissions($agent)->first(function (Permission $model) use ($permission) {
            return $this->isRelatedPermission($model, $permission);
        });

        $this->store->set($agent, $permission, $permissions !== null);

        return $permissions !== null;
    }

    /**
     * Given agent retrieve a list of permissions.
     *
     * @param Model $agent
     * @param array $types
     *
     * @return Collection
     */
    public function permissions(Model $agent, array $types = ['data']): Collection
    {
        return $this->dictionary->getPermissionsByType($types)->filter(function (Permission $model) use ($agent) {
            return $this->isRelatedAgent($model, $agent);
        });
    }

    public function getPermissionsByDataAndAction(Model $agent, array $actions = [], array $data = []): Collection
    {
        return $this->permissions($agent)->filter(function (Permission $model) use ($data) {
            $stack = $this->parsePayload($model->parsed->data);

            return $stack[0] === '*' || count(array_intersect($data, $stack)) > 0;
        })->filter(function (Permission $model) use ($actions) {
            $stack = $this->parsePayload($model->parsed->action);

            return $stack[0] === '*' || count(array_intersect($actions, $stack)) > 0;
        });
    }

    /**
     * is related permission.
     *
     * @param Permission $model
     * @param string     $permission
     *
     * @return bool
     */
    public function isRelatedPermission(Permission $model, string $permission): bool
    {
        return $this->match($permission, $this->explodePermissions($model));
    }

    /**
     * Convert a non-array into an array with one element of itself.
     *
     * @param mixed $attr
     *
     * @return array
     */
    public function parsePayload($attr): array
    {
        return !is_array($attr) ? [$attr] : $attr;
    }

    public function getDictionary(): PermissionDictionaryContract
    {
        return $this->dictionary;
    }

    /**
     * Explode model permission into an string-array of all available permissions.
     *
     * @param Permission $model
     *
     * @return array
     */
    protected function explodePermissions(Permission $model): array
    {
        $r = [];

        $payload = $model->parsed;

        foreach ($this->parsePayload($payload->data) as $data) {
            $r = array_merge(
                $r,
                [$data],
                preg_filter('/^/', $data.'.', $this->parsePayload($payload->action))
            );
        }

        return $r;
    }
}
