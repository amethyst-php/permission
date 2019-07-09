<?php

namespace Amethyst\Fakers;

use Faker\Factory;
use Railken\Bag;
use Railken\Lem\Faker;

class RoleHasPermissionFaker extends Faker
{
    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();

        $bag = new Bag();
        $bag->set('role', RoleFaker::make()->parameters()->toArray());
        $bag->set('permission', PermissionFaker::make()->parameters()->toArray());

        return $bag;
    }
}
