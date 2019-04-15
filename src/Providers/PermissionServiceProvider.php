<?php

namespace Railken\Amethyst\Providers;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Railken\Amethyst\Common\CommonServiceProvider;
use Illuminate\Support\Facades\Config;
use Railken\Amethyst\Console\Commands;

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

        \Illuminate\Database\Eloquent\Builder::macro('hasPermissions', function (): MorphMany {
            return app('amethyst')->createMacroMorphRelation($this, \Railken\Amethyst\Models\ModelHasPermission::class, 'hasPermissions', 'model');
        });

        \Illuminate\Database\Eloquent\Builder::macro('hasRoles', function (): MorphMany {
            return app('amethyst')->createMacroMorphRelation($this, \Railken\Amethyst\Models\ModelHasRole::class, 'hasRoles', 'model');
        });

        $this->commands([Commands\FlushPermissionsCommand::class]);
	}
}
