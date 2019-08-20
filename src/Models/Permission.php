<?php

namespace Amethyst\Models;

use Amethyst\Common\ConfigurableModel;
use Railken\Lem\Contracts\EntityContract;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model implements EntityContract
{
    use ConfigurableModel;

    protected $casts = [ 'id' => 'string' ];
 
    protected $keyType = 'string';

    public $incrementing = false;

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
