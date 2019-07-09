<?php

namespace Amethyst\Models;

use Amethyst\Common\ConfigurableModel;
use Railken\Lem\Contracts\EntityContract;
use Spatie\Permission\Models\Permission as Model;

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
