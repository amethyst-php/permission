<?php

namespace Railken\Amethyst\Models;

use Illuminate\Database\Eloquent\Model;
use Railken\Amethyst\Common\ConfigurableModel;
use Railken\Lem\Contracts\EntityContract;
use Spatie\Permission\Traits\HasPermissions;

class Role extends Model implements EntityContract
{
    use ConfigurableModel;
    use HasPermissions;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->ini('amethyst.permission.data.role');
        parent::__construct($attributes);
    }
}
