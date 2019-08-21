<?php

namespace Amethyst\Observers;

use Amethyst\Models\Permission;

class PermissionObserver
{
    /**
     * Handle the Permission "created" event.
     *
     * @param \Amethyst\Models\Permission $permission
     */
    public function created(Permission $permission)
    {
        app('amethyst.permission')->boot();
    }

    /**
     * Handle the Permission "updated" event.
     *
     * @param \Amethyst\Models\Permission $permission
     */
    public function updated(Permission $permission)
    {
        app('amethyst.permission')->boot();
    }

    /**
     * Handle the Permission "deleted" event.
     *
     * @param \Amethyst\Models\Permission $permission
     */
    public function deleted(Permission $permission)
    {
        app('amethyst.permission')->boot();
    }
}
