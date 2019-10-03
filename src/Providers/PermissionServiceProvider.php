<?php

namespace Amethyst\Providers;

use Amethyst\Common\CommonServiceProvider;
use Amethyst\Console\Commands;
use Amethyst\Models\Ownable;
use Amethyst\Models\Permission;
use Amethyst\Observers\OwnablePermissionObserver;
use Amethyst\Observers\PermissionObserver;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class PermissionServiceProvider extends CommonServiceProvider
{
    /**
     * @inherit
     */
    public function register()
    {
        parent::register();

        $this->commands([Commands\FlushPermissionsCommand::class]);

        //$this->app->register(\Amethyst\Providers\GroupServiceProvider::class);
        $this->app->register(\Railken\Template\TemplateServiceProvider::class);
        $this->app->register(\Amethyst\Providers\OwnerServiceProvider::class);

        $this->app->singleton('amethyst.permission', function ($app) {
            return new \Amethyst\Services\PermissionService();
        });
    }

    /**
     * @inherit
     */
    public function boot()
    {
        parent::boot();

        Permission::observe(PermissionObserver::class);
        // Ownable::observe(OwnablePermissionObserver::class);

        if (Schema::hasTable(Config::get('amethyst.permission.data.permission.table'))) {
            app('amethyst.permission')->boot();
        }
        $this->app->booted(function () {
            \Railken\Lem\Repository::addScope(new \Amethyst\Scopes\PermissionScope());
        });
    }
}
