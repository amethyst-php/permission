<?php

namespace Amethyst\Fakers;

use Faker\Factory;
use Railken\Bag;
use Railken\Lem\Faker;

class PermissionFaker extends Faker
{
    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();

        $bag = new Bag();
        $bag->set('data', 'foo');
        $bag->set('attribute', 'id|name|created_at|updated_at|deleted_at');
        $bag->set('action', 'create|update|show|remove');
        $bag->set('filter', 'id = 1');

        return $bag;
    }
}
