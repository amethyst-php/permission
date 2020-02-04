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
use Illuminate\Support\Collection;

class DataPermission
{ 
    use IsAgent;
    use MatchDotNotation;

    /**
     * @var PermissionDictionaryContract
     */
    protected $dictionary;

    /**
     * @var PermissionStoreContract
     */
    protected $store;

    /**
     * Create a new instance
     *
     * @param PermissionDictionary $dictionary
     */
    public function __construct(PermissionDictionaryContract $dictionary, PermissionStoreContract $store)
    {
        $this->dictionary = $dictionary; 
        $this->store = $store;
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

    public function getPermissionsByData(Model $agent, array $types = ['data'], array $data = []): Collection
    {
        return $this->permissions($agent, $types)->filter(function (Permission $model) use ($data) {
            $stack = $this->parsePayload($model->payload->data);

            return count(array_intersect($data, $stack)) > 0;
        });
    }

    /**
     * Has the agent the correct permission?
     *
     * @param Model $agent
     * @param string        $permission
     * @param array         $arguments
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
     * is related permission
     *
     * @param Permission $model
     * @param string $permission
     *
     * @return bool
     */
    public function isRelatedPermission(Permission $model, string $permission): bool
    {
        return $this->match($permission, $this->explodePermissions($model));
    }


    /**
     * Convert a non-array into an array with one element of itself
     *
     * @param mixed $attr
     *
     * @return array
     */
    public function parsePayload($attr): array
    {
        return !is_array($attr) ? [$attr] : $attr;
    }

    /**
     * Explode model permission into an string-array of all available permissions
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

    public function getDictionary(): PermissionDictionaryContract
    {
        return $this->dictionary;
    }
}
