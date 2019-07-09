<?php

namespace Amethyst\Tests;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();

        app('amethyst')->pushMorphRelation('model-has-permission', 'model', 'foo');
        app('amethyst')->pushMorphRelation('model-has-role', 'model', 'foo');

        $this->artisan('migrate:fresh');
        $this->artisan('amethyst:permission:flush');
    }

    protected function getPackageProviders($app)
    {
        return [
            \Amethyst\Providers\FooServiceProvider::class,
            \Amethyst\Providers\PermissionServiceProvider::class,
        ];
    }
}
