<?php

namespace Railken\Amethyst\Models;

use Spatie\Permission\Models\Permission as Model;
use Railken\Amethyst\Common\ConfigurableModel;
use Railken\Lem\Contracts\EntityContract;

class Permission extends Model implements EntityContract
{
    use ConfigurableModel;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->ini('amethyst.permission.data.permission');
        parent::__construct($attributes);
    }
}
