<?php

namespace Amethyst\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Amethyst\Api\Http\Controllers\RestManagerController;
use Amethyst\Common\CommonServiceProvider;
use Amethyst\Console\Commands;
use Amethyst\Models\ModelHasPermission;
use Amethyst\Observers\ModelHasPermissionObserver;
use Amethyst\Services\PermissionService;
use Railken\Lem\Contracts\ManagerContract;

class PermissionServiceProvider extends CommonServiceProvider
{
    /**
     * @inherit
     */
    public function register()
    {
        parent::register();

        $this->app->register(\Spatie\Permission\PermissionServiceProvider::class);

        Config::set('amethyst.permission.data.permission.table', Config::get('permission.table_names.permissions'));
        Config::set('amethyst.permission.data.role.table', Config::get('permission.table_names.roles'));
        Config::set('amethyst.permission.data.model-has-permission.table', Config::get('permission.table_names.model_has_permissions'));
        Config::set('amethyst.permission.data.model-has-role.table', Config::get('permission.table_names.model_has_roles'));
        Config::set('amethyst.permission.data.role-has-permission.table', Config::get('permission.table_names.role_has_permissions'));

        Config::set('permission.models.role', Config::get('amethyst.permission.data.role.model'));
        Config::set('permission.models.permission', Config::get('amethyst.permission.data.permission.model'));

        $this->commands([Commands\FlushPermissionsCommand::class]);
    }

    /**
     * @inherit
     */
    public function boot()
    {
        parent::boot();

        // app('amethyst')->pushMorphRelation('model-has-permission', 'model', 'role');

        app('amethyst')->getData()->map(function ($data, $key) {
            // app('amethyst')->pushMorphRelation('model-has-permission', 'object', $key);
        });

        $this->app->booted(function () {
            RestManagerController::addHandler('query', function ($data) {
                return $this->attachPermissionsToQuery($data->manager, $data->query);
            });
        });

        ModelHasPermission::observe(ModelHasPermissionObserver::class);
    }

    public function attachPermissionsToQuery(ManagerContract $manager, $query)
    {
        return;

        $agent = $manager->getAgent();

        if (!$agent->id) {
            return;
        }

        $name = $manager->newEntity()->getMorphName();

        $tableName = $query->getQuery()->from;

        $permission = app(PermissionService::class)->findFirstPermissionByPolicyCached($agent, sprintf('%s.show', $name));

        $query->leftJoin('model_has_permissions as p', function ($join) use ($permission, $tableName, $name) {
            $query = ModelHasPermission::where('permission_id', $permission ? $permission->id : 0)
                ->where(function ($query) use ($tableName) {
                    return $query->orWhere('object_id', DB::raw("$tableName.id"))
                        ->orWhereNull('object_id');
                })
                ->orderBy('object_id', 'DESC')
                ->take(1)
                ->select('id');

            if ($permission) {
                $query
                ->where('model_type', '=', '"'.$permission->pivot->model_type.'"')
                ->where('model_id', $permission->pivot->model_id);
            }

            $sql = str_replace_array('?', $query->getBindings(), $query->toSql());

            return $join->on('p.id', '=', DB::raw("($sql)"));
        });

        $select = [];

        foreach ($manager->getAttributes() as $attribute) {
            $n = $attribute->getName();
            $selects[] = "CASE WHEN CONCAT(',', p.attribute, ',') like '%,$n,%' THEN $tableName.$n ELSE null END as `$n`";
        }

        $query->select(DB::raw(implode(',', $selects)));

        // id must be present at least.
        $query->whereRaw(DB::raw("CONCAT(',', p.attribute, ',') like '%,id,%'"));
    }
}
