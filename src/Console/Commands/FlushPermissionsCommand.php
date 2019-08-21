<?php

namespace Amethyst\Console\Commands;

use Amethyst\Managers;
use Amethyst\Models;
use Illuminate\Console\Command;
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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $helper = new \Amethyst\Common\Helper();

        $this->info('Generating permissions...');

        $admin = app(Managers\PermissionManager::class)->findOrCreate([
            'data' => '*',
            'attribute' => '*',
            'action' => '*',
            'agent' => '{{ agent.id }} == 1'
        ])->getResource();

        $this->info('Done!');
    }
}
