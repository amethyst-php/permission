<?php

namespace Amethyst\Permissions;

use Amethyst\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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
}
