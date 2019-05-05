<?php

namespace Railken\Amethyst\Observers;

use Railken\Amethyst\Models\ModelHasPermission;
use Spatie\Permission\PermissionRegistrar;

class ModelHasPermissionObserver
{
    /**
     * Handle the ModelHasPermission "deleted" event.
     *
     * @param \Railken\Amethyst\Models\ModelHasPermission $modelHasPermission
     *
     * @return void
     */
    public function saved(ModelHasPermission $modelHasPermission)
    {
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
