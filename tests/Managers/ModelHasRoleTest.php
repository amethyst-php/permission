<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\ModelHasRoleFaker;
use Railken\Amethyst\Managers\ModelHasRoleManager;
use Railken\Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class ModelHasRoleTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = ModelHasRoleManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = ModelHasRoleFaker::class;
}
