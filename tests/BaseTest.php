<?php

namespace Railken\Amethyst\Tests;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__.'/..', '.env');
        $dotenv->load();

        parent::setUp();

        app('amethyst')->pushMorphRelation('model-has-permission', 'model', 'foo');
        app('amethyst')->pushMorphRelation('model-has-role', 'model', 'foo');

        $this->artisan('migrate:fresh');
        $this->artisan('amethyst:permission:flush');
    }

    protected function getPackageProviders($app)
    {
        return [
            \Railken\Amethyst\Providers\FooServiceProvider::class,
            \Railken\Amethyst\Providers\PermissionServiceProvider::class,
        ];
    }
}
