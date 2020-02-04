<?php

namespace Amethyst\Observers;

use Amethyst\Models\Permission;
use Amethyst\Permissions\PermissionStoreContract;
use Amethyst\Permissions\PermissionDictionaryContract;

class PermissionObserver
{
    /**
     * Handle the Permission "created" event.
     *
     * @param \Amethyst\Models\Permission $permission
     */
    public function created(Permission $permission)
    {
        app(PermissionStoreContract::class)->reset();
        app(PermissionDictionaryContract::class)->boot();
    }

    /**
     * Handle the Permission "updated" event.
     *
     * @param \Amethyst\Models\Permission $permission
     */
    public function updated(Permission $permission)
    {
        app(PermissionStoreContract::class)->reset();
        app(PermissionDictionaryContract::class)->boot();
    }

    /**
     * Handle the Permission "deleted" event.
     *
     * @param \Amethyst\Models\Permission $permission
     */
    public function deleted(Permission $permission)
    {
        app(PermissionStoreContract::class)->reset();
        app(PermissionDictionaryContract::class)->boot();
    }
}
