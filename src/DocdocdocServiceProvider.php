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
        //
    }
}
