<?php

namespace Futurfuturfutur\Docdocdoc\Commands;

use Futurfuturfutur\Docdocdoc\DocdocdocServiceProvider;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class RenderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docdocdoc:render {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Up render service for API documentation';

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
        switch ($this->argument('type')){
            case 'swagger':
                $type = $this->argument('type');
                $this->publishConfig($type);
                $this->info("Render docker config was published. Inside the root of the app run 'docker-compose -f docker-compose.$type.yml up --build -d'");
                break;
            default:
                $this->error('There is no render engine with type provided.');
        }
    }

    private function publishConfig($type)
    {
        $this->call('vendor:publish', [
            '--provider' => DocdocdocServiceProvider::class,
            '--tag' => 'renders.' . $type
        ]);
    }
}
