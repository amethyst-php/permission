<?php

namespace Amethyst\Tests;

use Amethyst\Fakers\FooFaker;
use Amethyst\Managers\FooManager;
use Amethyst\Managers\PermissionManager;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\Route;

class PermissionRouteTest extends BaseTest
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Route::any('foo', function () {
            return 'bazinga';
        })->middleware(\Amethyst\Permissions\PermissionMiddleware::class);
    }

    public function testPermissionDenied()
    {
        $response = $this->call('GET', "/foo", []);

        $response->assertStatus(404);
    }
}
