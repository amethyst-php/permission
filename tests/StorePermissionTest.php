<?php

namespace Amethyst\Tests;

use Amethyst\Permissions\PermissionStoreMissingAgentIdException;
use Amethyst\Permissions\PermissionStore;

class StorePermissionTest extends BaseTest
{
    public function testSetGet()
    {
        $store = $this->app->make(PermissionStore::class);

        $agent = new Agent();
        $agent->id = 1;

        $this->assertEquals(null, $store->get($agent, "basic"));

        $store->set($agent, 'basic', true);
        $this->assertEquals(true, $store->get($agent, "basic"));

        $store->set($agent, 'basic', false);
        $this->assertEquals(false, $store->get($agent, "basic"));
    }

    public function testAgentMissingId()
    {
        $this->expectException(PermissionStoreMissingAgentIdException::class);

        $store = $this->app->make(PermissionStore::class);

        $agent = new Agent();

        $this->assertEquals(null, $store->get($agent, "basic"));
    }
}
