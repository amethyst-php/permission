<?php

namespace Amethyst\Providers;

use Amethyst\Api\Http\Controllers\RestManagerController;
use Amethyst\Common\CommonServiceProvider;
use Amethyst\Console\Commands;
use Amethyst\Models\ModelHasPermission;
use Amethyst\Observers\ModelHasPermissionObserver;
use Amethyst\Services\PermissionService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Railken\Lem\Contracts\ManagerContract;
use Amethyst\Models\Permission;
use Amethyst\Observers\PermissionObserver;
use Illuminate\Support\Facades\Schema;

class PermissionServiceProvider extends CommonServiceProvider
{
    /**
     * @inherit
     */
    public function register()
    {
        parent::register();

        $this->commands([Commands\FlushPermissionsCommand::class]);

        //$this->app->register(\Amethyst\Providers\GroupServiceProvider::class);
        $this->app->register(\Railken\Template\TemplateServiceProvider::class);
        $this->app->register(\Amethyst\Providers\OwnerServiceProvider::class);

        $this->app->singleton('amethyst.permission', function ($app) {
            return new \Amethyst\Services\PermissionService();
        });
    }

    /**
     * @inherit
     */
    public function boot()
    {
        parent::boot();

        Permission::observe(PermissionObserver::class);


        if (Schema::hasTable(Config::get('amethyst.permission.data.permission.table'))) {
            app('amethyst.permission')->boot();
        }

        /*$this->app->booted(function () {
            RestManagerController::addHandler('query', function ($data) {
                return $this->attachPermissionsToQuery($data->manager, $data->query);
            });
        });*/
    }

    public function attachPermissionsToQuery(ManagerContract $manager, $query)
    {
        return;

        $agent = $manager->getAgent();

        if (!$agent->id) {
            return;
        }

        $name = app('amethyst')->tableize($manager->getEntity());

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
