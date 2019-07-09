<?php

namespace Amethyst\Observers;

use Amethyst\Models\ModelHasPermission;
use Spatie\Permission\PermissionRegistrar;

class ModelHasPermissionObserver
{
    /**
     * Handle the ModelHasPermission "deleted" event.
     *
     * @param \Amethyst\Models\ModelHasPermission $modelHasPermission
     */
    public function saved(ModelHasPermission $modelHasPermission)
    {
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
