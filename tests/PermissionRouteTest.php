<?php

namespace Amethyst\Tests;

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
        $response = $this->call('GET', '/foo', []);

        $response->assertStatus(404);
    }
}
