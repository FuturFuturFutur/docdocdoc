<?php

namespace Futurfuturfutur\Docdocdoc\Http\Middleware;

use Closure;
use Futurfuturfutur\Docdocdoc\Services\DocDocDocService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class DocDocDocMiddleware
{
    /**
     * @var DocDocDocService
     */
    private DocDocDocService $docDocDocService;

    public function __construct(DocDocDocService $docDocDocService)
    {
        $this->docDocDocService = $docDocDocService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if(Config::get('app.debug'))
            $this->docDocDocService->parse($request, $response);

        return $response;
    }
}
