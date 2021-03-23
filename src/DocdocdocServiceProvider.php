<?php

namespace Futurfuturfutur\Docdocdoc;

use Futurfuturfutur\Docdocdoc\Commands\InitCommand;
use Futurfuturfutur\Docdocdoc\Commands\RenderCommand;
use Futurfuturfutur\Docdocdoc\Http\Middleware\DocDocDocMiddleware;
use Futurfuturfutur\Docdocdoc\Services\Format\FormatServiceInterface;
use Futurfuturfutur\Docdocdoc\Services\Format\SwaggerFormatService;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class DocdocdocServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishConfig();
            $this->registerCommands();
            $this->registerBindings();
        }

        $this->registerMiddlewares();
    }

    private function publishConfig()
    {
        $this->publishes([__DIR__ . '/../config/docdocdoc.php' => config_path('docdocdoc.php')], 'config');

        // Renders
        $this->publishes([__DIR__ . '/../renders/swagger/docker-compose.yml' => base_path('docker-compose.swagger.yml')], 'renders.swagger');
    }

    private function registerCommands()
    {
        $this->commands([
            InitCommand::class,
            RenderCommand::class,
        ]);
    }

    private function registerBindings()
    {
        $this->app->bind(FormatServiceInterface::class, function (){
            switch (Config::get('docdocdoc.type')){
                default:
                    return new SwaggerFormatService();
            }
        });
    }

    private function registerMiddlewares()
    {
        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(DocDocDocMiddleware::class);
    }
}
