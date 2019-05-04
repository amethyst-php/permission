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

        $this->info("Generating permissions...");

        $helper->getData()->map(function ($data) use ($helper) {

            $manager = app(Arr::get($data, 'manager'));

            $this->updatePermissions($manager->getAuthorizer()->getPermissions());

            foreach ($manager->getAttributes() as $attribute) {
                $this->updatePermissions($attribute->getPermissions());
            }
        });

        $this->info("Adding permissions to role admin...");
        $admin = app(Managers\RoleManager::class)->findOrCreate(['name' => 'admin', 'guard_name' => 'web'])->getResource();

        $admin->permissions()->sync((new Models\Permission)->get(), false);
        $admin->forgetCachedPermissions();

        $this->info("Done!");
    }

    public function updatePermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $permission = app(Managers\PermissionManager::class)->findOrCreate(['name' => $permission, 'guard_name' => 'web'])->getResource();
        }
    }
}