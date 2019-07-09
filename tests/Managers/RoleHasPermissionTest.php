<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\RoleHasPermissionFaker;
use Amethyst\Managers\RoleHasPermissionManager;
use Amethyst\Tests\BaseTest;
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
