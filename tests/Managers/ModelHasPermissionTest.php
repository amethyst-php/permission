<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\ModelHasPermissionFaker;
use Railken\Amethyst\Managers\ModelHasPermissionManager;
use Railken\Amethyst\Tests\BaseTest;
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
