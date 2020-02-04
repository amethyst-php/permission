<?php

namespace Amethyst\Permissions;

use Amethyst\Models\Permission;
use Illuminate\Database\Eloquent\Model;

class PermissionStore implements PermissionStoreContract
{
    /**
     * @var items;
     */
    protected $items;

    /**
     * Create a new instance.
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Set item.
     *
     * @param Model  $agent
     * @param string $permission
     * @param bool   $value
     */
    public function set(Model $agent, string $permission, bool $value)
    {
        $this->items[$this->key($agent, $permission)] = $value;
    }

    /**
     * Retrieve item.
     *
     * @param Model  $agent
     * @param string $permission
     *
     * @return bool
     */
    public function get(Model $agent, string $permission): ?bool
    {
        return $this->items[$this->key($agent, $permission)] ?? null;
    }

    /**
     * Create a key given agent and permission.
     *
     * @param Model  $agent
     * @param string $Permission
     *
     * @return string
     */
    public function key(Model $agent, string $permission): string
    {
        if (empty($agent->id)) {
            throw new PermissionStoreMissingAgentIdException();
        }

        return $agent->id.':'.$permission;
    }

    /**
     * Reset items.
     */
    public function reset()
    {
        $this->items = [];
    }
}
