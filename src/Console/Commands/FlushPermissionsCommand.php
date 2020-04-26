<?php

namespace Amethyst\Console\Commands;

use Amethyst\Managers;
use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;

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
        $this->info('Done!');
    }
}
