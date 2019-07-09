<?php

namespace Amethyst\Fakers;

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
        $bag->set('object_type', 'foo');
        $bag->set('object', FooFaker::make()->parameters()->toArray());
        $bag->set('attribute', 'id|name|created_at|updated_at|deleted_at');

        return $bag;
    }
}
