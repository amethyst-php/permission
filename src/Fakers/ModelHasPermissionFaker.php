<?php

namespace Railken\Amethyst\Fakers;

use Faker\Factory;
use Railken\Bag;
use Railken\Lem\Faker;

class ModelHasPermissionFaker extends Faker
{
    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();

        $bag = new Bag();
        $bag->set('model_type', 'foo');
        $bag->set('model', FooFaker::make()->parameters()->toArray());
        $bag->set('permission', PermissionFaker::make()->parameters()->toArray());

        return $bag;
    }
}
