<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\RoleFaker;
use Railken\Amethyst\Managers\RoleManager;
use Railken\Amethyst\Tests\BaseTest;
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
