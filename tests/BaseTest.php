<?php

namespace Amethyst\Tests;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
        app('amethyst.permission')->boot();
        app('eloquent.mapper')->boot();
        
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
