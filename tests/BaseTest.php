<?php

namespace Amethyst\Tests;

use Amethyst\Models\Bar;
use Amethyst\Models\Foo;
use Amethyst\Models\Ownable;
use Amethyst\Permissions\PermissionDictionaryContract;
use Amethyst\Permissions\PermissionStoreContract;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');

        app(PermissionStoreContract::class)->reset();
        app(PermissionDictionaryContract::class)->boot();

        // $this->artisan('amethyst:permission:flush');

        Bar::resolveRelationUsing('ownables', function (Bar $model) {
            return $model->morphMany(Ownable::class, 'ownable');
        });

        Foo::resolveRelationUsing('ownables', function (Foo $model) {
            return $model->morphMany(Ownable::class, 'ownable');
        });

        $this->artisan('mapper:generate');
        \Railken\Lem\Repository::resetScopes();
        \Railken\Lem\Repository::addScope(new \Amethyst\Permissions\PermissionScope());
    }

    protected function getPackageProviders($app)
    {
        return [
            \Amethyst\Providers\FooServiceProvider::class,
            \Amethyst\Providers\PermissionServiceProvider::class,
        ];
    }
}
