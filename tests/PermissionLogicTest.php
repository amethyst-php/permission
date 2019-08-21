<?php

namespace Amethyst\Tests;

use Amethyst\Managers\PermissionManager;
use Amethyst\Managers\FooManager;
use Amethyst\Fakers\FooFaker;
use Railken\Lem\Exceptions\ModelNotAuthorizedException;

class PermissionLogicTest extends BaseTest
{   
    /**
     * Setup the test environment.
     */
    public function tearDown(): void
    {
        // Delete all permissions.
        // app(PermissionManager::class)->getRepository()->newQuery()->delete();
    }


    public function testFailCreationWithNoPermission()
    {
    	$result = FooManager::make(new Agent)->create(FooFaker::make()->parameters());

    	$this->assertEquals('FOO_NOT_AUTHORIZED', $result->getError()->getCode());
    }

    public function testSuccessCreationWithAll()
    {
        app(PermissionManager::class)->createOrFail([
            'data' => '*',
            'action' => '*',
            'attribute' => '*',
        ]);

        $result = FooManager::make(new Agent)->create(FooFaker::make()->parameters());
        $this->assertEquals(true, $result->ok());
    }

    public function testFailCreationWithAgent()
    {
        app(PermissionManager::class)->createOrFail([
            'data' => '*',
            'action' => '*',
            'attribute' => '*',
            'agent' => '{{ agent.id }} == 1'
        ]);

        $result = FooManager::make(new Agent)->create(FooFaker::make()->parameters());

        $this->assertEquals('FOO_NOT_AUTHORIZED', $result->getError()->getCode());
    }

    public function testSuccessCreationWithAgent()
    {
        app(PermissionManager::class)->createOrFail([
            'data' => '*',
            'action' => '*',
            'attribute' => '*',
            'agent' => '{{ agent.id }} == 0'
        ]);

        $result = FooManager::make(new Agent)->create(FooFaker::make()->parameters());

        $this->assertEquals(true, $result->ok());
    }

    public function testFailBarCreationWithAgentAndData()
    {
        app(PermissionManager::class)->createOrFail([
            'data' => 'foo',
            'action' => '*',
            'attribute' => '*',
            'agent' => '{{ agent.id }} == 0'
        ]);

        $result = FooManager::make(new Agent)->create(FooFaker::make()->parameters());

        $this->assertEquals('BAR_NOT_AUTHORIZED', $result->getError()->getCode());
    }

    public function testFailCreationWithAgentAndData()
    {
        app(PermissionManager::class)->createOrFail([
            'data' => 'foo|bar',
            'action' => '*',
            'attribute' => '*',
            'agent' => '{{ agent.id }} == 0'
        ]);

        $result = FooManager::make(new Agent)->create(FooFaker::make()->parameters());

        $this->assertEquals(true, $result->ok());
    }

    public function testSuccessCreationWithAgentAndAction()
    {
        app(PermissionManager::class)->createOrFail([
            'data' => 'foo|bar',
            'action' => 'create|attributes.*',
            'attribute' => '*',
            'agent' => '{{ agent.id }} == 0'
        ]);

        $result = FooManager::make(new Agent)->create(FooFaker::make()->parameters());

        $this->assertEquals(true, $result->ok());
    }
}
