<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\RoleHasPermissionFaker;
use Railken\Amethyst\Managers\RoleHasPermissionManager;
use Railken\Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class RoleHasPermissionTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = RoleHasPermissionManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = RoleHasPermissionFaker::class;
}
