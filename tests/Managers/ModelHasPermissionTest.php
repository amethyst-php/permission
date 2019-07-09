<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\ModelHasPermissionFaker;
use Amethyst\Managers\ModelHasPermissionManager;
use Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class ModelHasPermissionTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = ModelHasPermissionManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = ModelHasPermissionFaker::class;
}
