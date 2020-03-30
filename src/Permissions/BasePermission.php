<?php

namespace Amethyst\Permissions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Amethyst\Models\Permission;

class BasePermission
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
     * Create a new instance.
     *
     * @param PermissionDictionary $dictionary
     */
    public function __construct(PermissionDictionaryContract $dictionary, PermissionStoreContract $store)
    {
        $this->dictionary = $dictionary;
        $this->store = $store;
    }

    /**
     * @return PermissionDictionaryContract
     */
    public function getDictionary(): PermissionDictionaryContract
    {
        return $this->dictionary;
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

    /**
     * Retrieve a new user as guest user
     *
     * @return Model
     */
    public function guestUser()
    {
        $class = config('amethyst.authentication.entity');
        $agent = new $class;
        $agent->id = 0;

        return $agent;
    }
}
