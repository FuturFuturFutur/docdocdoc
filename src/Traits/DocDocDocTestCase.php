<?php

namespace Futurfuturfutur\Docdocdoc\Traits;

use Futurfuturfutur\Docdocdoc\Services\Format\FormatServiceInterface;
use Futurfuturfutur\Docdocdoc\Services\PhpDocParserService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait DocDocDocTestCase
{
    protected function tearDown(): void
    {
        if(Config::get('docdocdoc.mode_on')) {
            $service = App::make(FormatServiceInterface::class);

            if ($this->getTestResultObject()->count() === 1)
                $service->resetConfig();

            $testClass = get_class($this);
            $testReflection = new \ReflectionClass($testClass);
            $testParams = PhpDocParserService::parsePhpDoc($testReflection->getDocComment());

            if (Cache::has('docdocdoc.call')) {
                if (!$this->hasFailed()) {
                    $testCallTarget = explode('::', $this->provides()[0]->getTarget());
                    $testCallReflection = new \ReflectionMethod($testClass, $testCallTarget[1]);
                    $testCallParams = PhpDocParserService::parsePhpDoc($testCallReflection->getDocComment());

                    $call = Cache::get('docdocdoc.call');
                    $call['docdocdoc'] = $testCallParams;

                    $service->save($testParams, $call);
                }

                Cache::forget('docdocdoc.call');
            }
        }

        parent::tearDown();
    }
}
