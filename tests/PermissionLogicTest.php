<?php

namespace Amethyst\Tests;

use Amethyst\Fakers\FooFaker;
use Amethyst\Managers\FooManager;
use Amethyst\Managers\PermissionManager;
use Amethyst\Permissions\PermissionScope;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\Auth;

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
        $result = FooManager::make($this->authenticateAs(['id' => 1]))->create(FooFaker::make()->parameters());

        $this->assertEquals('FOO_NOT_AUTHORIZED', $result->getError()->getCode());
    }

    /*public function testListPermissions()
    {
        app(PermissionManager::class)->createOrFail([
            'effect' => 'allow',
            'type' => 'data',
            'payload' => Yaml::dump([
                'data'      => '*',
                'action'    => '*',
                'attribute' => '*',
            ])
        ]);

        print_r(app('amethyst.permission.data')->getDictionary()->getPermissionsByType(['data']));
    }*/


    public function testSuccessCreationWithAll()
    {
        app(PermissionManager::class)->createOrFail([
            'effect' => 'allow',
            'type' => 'data',
            'payload' => Yaml::dump([
                'data'      => '*',
                'action'    => '*',
                'attribute' => '*',
            ])
        ]);

        $result = FooManager::make($this->authenticateAs(['id' => 1]))->create(FooFaker::make()->parameters());
        $this->assertEquals(true, $result->ok());
    }

    public function testFailCreationWithAgent()
    {
        app(PermissionManager::class)->createOrFail([
            'effect' => 'allow',
            'type' => 'data',
            'payload' => Yaml::dump([
                'data'      => '*',
                'action'    => '*',
            ]),
            'agent'     => '{{ agent.id }} == 0',
        ]);

        $result = FooManager::make($this->authenticateAs(['id' => 1]))->create(FooFaker::make()->parameters());

        $this->assertEquals('FOO_NOT_AUTHORIZED', $result->getError()->getCode());
    }

    public function testSuccessCreationWithAgent()
    {
        app(PermissionManager::class)->createOrFail([
            'effect' => 'allow',
            'type' => 'data',
            'payload' => Yaml::dump([
                'data'      => '*',
                'action'    => '*',
            ]),
            'agent'     => '{{ agent.id }} == 1',
        ]);

        $result = FooManager::make($this->authenticateAs(['id' => 1]))->create(FooFaker::make()->parameters());

        $this->assertEquals(true, $result->ok());
    }

    public function testFailBarCreationWithAgentAndData()
    {
        app(PermissionManager::class)->createOrFail([
            'effect' => 'allow',
            'type' => 'data',
            'payload' => Yaml::dump([
                'data'      => 'foo',
                'action'    => '*',
            ]),
            'agent'     => '{{ agent.id }} == 1',
        ]);

        $result = FooManager::make($this->authenticateAs(['id' => 1]))->create(FooFaker::make()->parameters());

        $this->assertEquals('BAR_NOT_AUTHORIZED', $result->getError()->getCode());
    }

    public function testFailCreationWithAgentAndData()
    {
        app(PermissionManager::class)->createOrFail([
            'effect' => 'allow',
            'type' => 'data',
            'payload' => Yaml::dump([
                'data'      => ['foo', 'bar'],
                'action'    => '*',
            ]),
            'agent'     => '{{ agent.id }} == 1',
        ]);

        $result = FooManager::make($this->authenticateAs(['id' => 1]))->create(FooFaker::make()->parameters());

        $this->assertEquals(true, $result->ok());
    }

    public function testSuccessCreationWithAgentAndAction()
    {
        app(PermissionManager::class)->createOrFail([
            'effect' => 'allow',
            'type' => 'data',
            'payload' => Yaml::dump([
                'data'      => ['foo', 'bar'],
                'action'    => ['create', 'attributes.*'],
            ]),
            'agent'     => '{{ agent.id }} == 1',
        ]);

        $result = FooManager::make($this->authenticateAs(['id' => 1]))->create(FooFaker::make()->parameters());

        $this->assertEquals(true, $result->ok());
    }

    public function testFailQuery()
    {
        $result = FooManager::make()->create(FooFaker::make()->parameters());

        $query = FooManager::make()->getRepository()->newQuery();

        (new PermissionScope())->apply(FooManager::make($this->authenticateAs(['id' => 1])), $query);

        $this->assertEquals(0, $query->count());
    }

    public function testSuccessQuery()
    {
        app(PermissionManager::class)->createOrFail([
            'effect' => 'allow',
            'type' => 'data',
            'payload' => Yaml::dump([
                'data'      => '*',
                'action'    => '*',
            ]),
            'agent'     => '{{ agent.id }} == 1',
        ]);

        $result = FooManager::make()->create(FooFaker::make()->parameters());

        $query = FooManager::make()->getRepository()->newQuery();

        (new PermissionScope())->apply(FooManager::make($this->authenticateAs(['id' => 1])), $query);

        $this->assertEquals(1, $query->count());
    }

    public function testFailDataFilterQuery()
    {
        app(PermissionManager::class)->createOrFail([
            'effect' => 'allow',
            'type' => 'data',
            'payload' => Yaml::dump([
                'data'      => 'bar',
                'action'    => '*',
            ]),
            'agent'     => '{{ agent.id }} == 1',
        ]);

        $result = FooManager::make()->create(FooFaker::make()->parameters());

        $query = FooManager::make()->getRepository()->newQuery();

        (new PermissionScope())->apply(FooManager::make($this->authenticateAs(['id' => 1])), $query);

        $this->assertEquals(0, $query->count());
    }

    public function testSuccessFilterQuery()
    {
        app(PermissionManager::class)->createOrFail([
            'effect' => 'allow',
            'type' => 'data',
            'payload' => Yaml::dump([
                'data'      => '*',
                'action'    => '*',
                'filter'    => 'id = 1',
            ]),
            'agent'     => '{{ agent.id }} == 1',
        ]);

        $result = FooManager::make()->create(FooFaker::make()->parameters());

        $query = FooManager::make()->getRepository()->newQuery();

        (new PermissionScope())->apply(FooManager::make($this->authenticateAs(['id' => 1])), $query);

        $this->assertEquals(1, $query->count());
    }

    public function testWrongFilterQuery()
    {
        app(PermissionManager::class)->createOrFail([
            'effect' => 'allow',
            'type' => 'data',
            'payload' => Yaml::dump([
                'data'      => '*',
                'action'    => '*',
                'filter'    => 'id = 2',
            ]),
            'agent'     => '{{ agent.id }} == 1',
        ]);

        $result = FooManager::make()->create(FooFaker::make()->parameters());

        $query = FooManager::make()->getRepository()->newQuery();

        (new PermissionScope())->apply(FooManager::make($this->authenticateAs(['id' => 1])), $query);

        $this->assertEquals(0, $query->count());
    }

    public function testSuccess1FilterQuery()
    {
        app(PermissionManager::class)->createOrFail([
            'effect' => 'allow',
            'type' => 'data',
            'payload' => Yaml::dump([
                'data'      => '*',
                'action'    => '*',
                'filter'    => 'bar.id = 1',
            ]),
            'agent'     => '{{ agent.id }} == 1',
        ]);

        $result = FooManager::make()->create(FooFaker::make()->parameters());

        $query = FooManager::make()->getRepository()->newQuery();

        (new PermissionScope())->apply(FooManager::make($this->authenticateAs(['id' => 1])), $query);

        $this->assertEquals(1, $query->count());
    }

    public function testCollisionBetweenTwoAgents()
    {
        app(PermissionManager::class)->createOrFail([
            'effect' => 'allow',
            'type' => 'data',
            'payload' => Yaml::dump([
                'data'      => '*',
                'action'    => ['create', 'attributes.*'],
            ]),
        ]);

        
        $result1 = FooManager::make($this->authenticateAs(['id' => 1]))->create(FooFaker::make()->parameters());
        $this->assertEquals(true, $result1->ok());

        $result2a = FooManager::make($this->authenticateAs(['id' => 2]))->create(FooFaker::make()->parameters());
        $this->assertEquals(true, $result2a->ok());
        $result2b = FooManager::make($this->authenticateAs(['id' => 2]))->create(FooFaker::make()->parameters());
        $this->assertEquals(true, $result2b->ok());

        // Agent 1 should see only result 1 and agent 2 only 2a and 2b.
        $query = FooManager::make()->getRepository()->newQuery();
        (new PermissionScope())->apply(FooManager::make($this->authenticateAs(['id' => 1])), $query);
        $this->assertEquals(1, $query->count());

        $query = FooManager::make()->getRepository()->newQuery();
        (new PermissionScope())->apply(FooManager::make($this->authenticateAs(['id' => 1])), $query);
        $this->assertEquals(2, $query->count());
    }

    public function authenticateAs($params)
    {
        $user = new Agent($params);
        Auth::login($user);

        return $user;
    }
}
