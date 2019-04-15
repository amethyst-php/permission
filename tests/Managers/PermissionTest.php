<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\PermissionFaker;
use Railken\Amethyst\Managers\PermissionManager;
use Railken\Amethyst\Tests\BaseTest;
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
