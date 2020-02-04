<?php

namespace Amethyst\Providers;

use Amethyst\Console\Commands;
use Amethyst\Core\Providers\CommonServiceProvider;
use Amethyst\Models\Permission;
use Amethyst\Observers\PermissionObserver;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Amethyst\Permissions\PermissionStoreContract;
use Amethyst\Permissions\PermissionDictionaryContract;
use Amethyst\Permissions\PermissionStore;
use Amethyst\Permissions\PermissionDictionary;

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
    }

    /**
     * @inherit
     */
    public function boot()
    {
        parent::boot();

        Permission::observe(PermissionObserver::class);

        $this->app->booted(function () {
            \Railken\Lem\Repository::addScope(new \Amethyst\Permissions\PermissionScope());
        });
    }
}
