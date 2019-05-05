<?php

namespace Railken\Amethyst\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Railken\Amethyst\Managers;

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

        $admin = app(Managers\RoleManager::class)->findOrCreate(['name' => 'admin', 'guard_name' => 'web'])->getResource();

        $helper->getData()->map(function ($data) use ($admin, $helper) {
            $manager = app(Arr::get($data, 'manager'));

            $permissions = $this->updatePermissions($manager);

            $attributes = $manager->getAttributes()->map(function ($attribute) {
                return $attribute->getName();
            });

            $permissions->map(function ($permission) use ($manager, $admin, $attributes) {
                app(Managers\ModelHasPermissionManager::class)->findOrCreateOrFail([
                    'permission_id' => $permission->id,
                    'object_type'   => app('amethyst')->findMorphByModelCached($manager->getEntity()),
                    'model_type'    => 'role',
                    'attribute'     => $attributes->implode(','),
                    'model_id'      => $admin->id,
                ])->getResource();
            });
        });

        $admin->forgetCachedPermissions();

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
