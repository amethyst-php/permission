<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\PermissionFaker;
use Amethyst\Managers\PermissionManager;
use Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class PermissionTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = PermissionManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = PermissionFaker::class;
}
