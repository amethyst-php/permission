<?php

namespace Railken\Amethyst\Console\Commands;

use Illuminate\Console\Command;
use Railken\Amethyst\Managers;
use Railken\Amethyst\Models;
use Illuminate\Support\Arr;

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
     *
     * @return void
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

        $helper->getData()->map(function ($data) use ($helper) {

            $manager = app(Arr::get($data, 'manager'));

            $this->updatePermissions($manager->getAuthorizer()->getPermissions());

            foreach ($manager->getAttributes() as $attribute) {
                $this->updatePermissions($attribute->getPermissions());
            }
        });

        $admin = app(Managers\RoleManager::class)->findOrCreate(['name' => 'admin', 'guard_name' => 'admin'])->getResource();

        (new Models\Permission)->get()->map(function ($permission) use ($admin) {
            $admin->givePermissionTo($permission->name);
        });
        return 1;
    }

    public function updatePermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $permission = app(Managers\PermissionManager::class)->findOrCreate(['name' => $permission, 'guard_name' => 'admin'])->getResource();
        }
    }
}