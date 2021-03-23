<?php

namespace Futurfuturfutur\Docdocdoc\Commands;

use Futurfuturfutur\Docdocdoc\DocdocdocServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class InitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docdocdoc:init {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize package';

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
     * @return int
     */
    public function handle()
    {
        $this->info('Initializing DocDocDoc.');

        $this->call('vendor:publish', [
            '--provider' => DocdocdocServiceProvider::class,
            '--tag' => 'config'
        ]);

        $this->info('Package successfully initialized.');
    }
}
