<?php

namespace Railken\Amethyst\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Railken\Amethyst\Managers;
use Railken\Amethyst\Models;

class FlushPermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amethyst:permission:flush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate all permission';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $helper = new \Railken\Amethyst\Common\Helper();

        $this->info('Generating permissions...');
        $this->info('');

        $data = $helper->getData();

        $bar = $this->output->createProgressBar($data->count());

        $admin = app(Managers\RoleManager::class)->findOrCreate(['name' => 'admin', 'guard_name' => 'web'])->getResource();

        $bar->start();

        $data->map(function ($data) use ($admin, $helper, $bar) {
            $manager = app(Arr::get($data, 'manager'));

            $permissions = $this->updatePermissions($manager);

            $attributes = $manager->getAttributes()->map(function ($attribute) {
                return $attribute->getName();
            });

            $type = app('amethyst')->findMorphByModel($manager->getEntity());

            $permissions->map(function ($permission) use ($admin, $type, $attributes) {
                $model = app(Models\ModelHasPermission::class);

                $model->unsetEventDispatcher();

                $model = $model->firstOrCreate([
                    'permission_id' => $permission->id,
                    'object_type'   => $type,
                    'model_type'    => 'role',
                    'model_id'      => $admin->id,
                ]);

                $model->fill([
                    'attribute'     => $attributes->implode(','),
                ]);

                $model->save();
            });

            $bar->advance();
        });

        $admin->forgetCachedPermissions();

        $bar->finish();
        $this->info('');
        $this->info('');
        $this->info('Done!');
    }

    public function updatePermissions($manager)
    {
        $permissions = collect();

        foreach ($manager->getAuthorizer()->getPermissions() as $permission) {
            $permissions->push(app(Managers\PermissionManager::class)->findOrCreate(['name' => $permission, 'guard_name' => 'web'])->getResource());
        }

        return $permissions;
    }
}
