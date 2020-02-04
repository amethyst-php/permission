<?php

namespace Amethyst\Console\Commands;

use Amethyst\Managers;
use Illuminate\Console\Command;

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
        $helper = new \Amethyst\Core\Helper();

        $this->info('Generating permissions...');

        $admin = app(Managers\PermissionManager::class)->findOrCreate([
            'data'      => '*',
            'attribute' => '*',
            'action'    => '*',
            'agent'     => '{{ agent.id }} == 1',
        ])->getResource();

        // Everything that is owned, should be allowed to query.
        app(Managers\PermissionManager::class)->createOrFail([
            'effect' => 'allow',
            'type' => 'data',
            'payload' => Yaml::dump([
                'data'      => '*',
                'action'    => 'query',
                'filter'    => 'ownables.owner_id = {{ agent.id }}',
            ]),
        ]);

        $this->info('Done!');
    }
}
