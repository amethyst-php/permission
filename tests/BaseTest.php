<?php

namespace Amethyst\Tests;

use Amethyst\Permissions\PermissionStoreContract;
use Amethyst\Permissions\PermissionDictionaryContract;

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
    }

    protected function getPackageProviders($app)
    {
        return [
            \Amethyst\Providers\FooServiceProvider::class,
            \Amethyst\Providers\PermissionServiceProvider::class,
        ];
    }
}
