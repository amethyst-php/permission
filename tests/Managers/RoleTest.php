<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\RoleFaker;
use Amethyst\Managers\RoleManager;
use Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class RoleTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = RoleManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = RoleFaker::class;
}
