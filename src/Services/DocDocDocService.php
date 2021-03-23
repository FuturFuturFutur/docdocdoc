<?php

namespace Futurfuturfutur\Docdocdoc\Services;

use Futurfuturfutur\Docdocdoc\Services\Request\FormRequestService;
use Futurfuturfutur\Docdocdoc\Services\Request\RequestService;
use Futurfuturfutur\Docdocdoc\Services\Response\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class DocDocDocService
{

    public function parse(Request $request, Response $response)
    {
        $requestFormat = new RequestService($request);
        $responseFormat = new ResponseService($response);

        $call = $this->formatCall($requestFormat, $responseFormat);
        $this->save($call);
    }

    private function formatCall(RequestService $request, ResponseService $response)
    {
        return [
            'host' => $request->getHost(),
            'prefix' => $request->getPrefix(),
            'path' => $request->getPath(),
            'headers' => $request->getHeaders(),
            'method' => $request->getMethod(),
            'body_params' => $request->getBodyParams(),
            'query_params' => $request->getQueryParams(),
            'path_params' => $request->getPathParams(),
            'code' => $response->getStatusCode(),
            'payload' => $response->getPayload(),
        ];
    }

    private function save($call)
    {
        Cache::put('docdocdoc.call', $call);
    }

}
