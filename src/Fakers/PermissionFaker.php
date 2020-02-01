<?php

namespace Amethyst\Fakers;

use Faker\Factory;
use Railken\Bag;
use Railken\Lem\Faker;
use Symfony\Component\Yaml\Yaml;

class PermissionFaker extends Faker
{
    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();

        $bag = new Bag();
        $bag->set('effect', 'accept');
        $bag->set('type', 'route');
        $bag->set('payload', Yaml::dump([
            'name' => 'foo'
        ]));
        $bag->set('agent', '{{ agent.id }} == 1');

        return $bag;
    }
}
