<?php

namespace Amethyst\Providers;

use Amethyst\Console\Commands;
use Amethyst\Core\Providers\CommonServiceProvider;
use Amethyst\Models\Permission;
use Amethyst\Observers\PermissionObserver;
use Amethyst\Permissions\PermissionDictionary;
use Amethyst\Permissions\PermissionDictionaryContract;
use Amethyst\Permissions\PermissionStore;
use Amethyst\Permissions\PermissionStoreContract;
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

        $this->app->singleton(
            PermissionStoreContract::class,
            PermissionStore::class
        );

        $this->app->singleton(
            PermissionDictionaryContract::class,
            PermissionDictionary::class
        );

        $this->app->singleton('amethyst.permission.data', function ($app) {
            return $this->app->make(\Amethyst\Permissions\DataPermission::class);
        });

        $this->app->singleton('amethyst.permission.route', function ($app) {
            return $this->app->make(\Amethyst\Permissions\RoutePermission::class);
        });
    }

    /**
     * @inherit
     */
    public function boot()
    {
        parent::boot();

        if (Schema::hasTable(Config::get('amethyst.permission.data.permission.table'))) {
            Permission::observe(PermissionObserver::class);

            \Railken\Lem\Repository::addScope(new \Amethyst\Permissions\PermissionScope());

            app(PermissionStoreContract::class)->reset();
            app(PermissionDictionaryContract::class)->boot();
        }
    }
}
