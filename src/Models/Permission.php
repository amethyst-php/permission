<?php

namespace Amethyst\Models;

use Amethyst\Core\ConfigurableModel;
use Illuminate\Database\Eloquent\Model;
use Railken\Lem\Contracts\EntityContract;

class Permission extends Model implements EntityContract
{
    use ConfigurableModel;

    public $incrementing = false;

    protected $casts = ['id' => 'string'];

    protected $keyType = 'string';

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
