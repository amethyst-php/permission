<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\ModelHasRoleFaker;
use Amethyst\Managers\ModelHasRoleManager;
use Amethyst\Tests\BaseTest;
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
