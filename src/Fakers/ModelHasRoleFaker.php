<?php

namespace Amethyst\Fakers;

use Faker\Factory;
use Railken\Bag;
use Railken\Lem\Faker;

class ModelHasRoleFaker extends Faker
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
        $bag->set('role', RoleFaker::make()->parameters()->toArray());

        return $bag;
    }
}
