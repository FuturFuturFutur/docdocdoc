<?php

namespace Futurfuturfutur\Docdocdoc\Services\Format;

use Futurfuturfutur\Docdocdoc\Services\Request\FormRequestService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class SwaggerFormatService implements FormatServiceInterface
{
    private const DEFAULT = 'Empty';
    private const CONFIG_PATH = '/docdocdoc/swagger.json';

    private array $params;
    private array $call;

    private array $config;

    public function save(array $params, array $call)
    {
        $this->params = $params;
        $this->call = $call;

        $this->config = $this->initConfig();

        $this->initPath();
        $this->initResponse();

        $this->initBodyParameters();
        $this->initPathParameters();
        $this->initQueryParams();

//        $this->initValidations();

        $this->saveCall();
    }

    private function initConfig()
    {
        if (!Storage::disk('local')->exists(self::CONFIG_PATH)) {
            Storage::disk('local')->put(self::CONFIG_PATH, json_encode($this->getTemplate()));
        }

        return json_decode(Storage::disk('local')->get(self::CONFIG_PATH), true);
    }

    private function getTemplate()
    {
        return [
            'swagger' => '2.0',
            'info' => [
                'description' => Config::get('docdocdoc.description'),
                'version' => Config::get('docdocdoc.version'),
                "title" => Config::get('docdocdoc.title'),
            ],
            'host' => $this->call['host'],
            'paths' => [],
            'components' => [
                'securitySchemes' => [
                    'bearerAuth' => [
                        'type' => 'http',
                        'scheme' => 'bearer',
                        'bearerFormat' => 'JWT'
                    ]
                ]
            ]
        ];
    }

    private function initPath()
    {

        if (!isset($this->config['paths'][$this->call['path']][strtolower($this->call['method'])])) {
            $this->config['paths'][$this->call['path']][strtolower($this->call['method'])] = [
                'tags' => [
                    isset($this->params['group']) ? $this->params['group'] : 'Default'
                ],
                'summery' => isset($this->params['summery']) ? $this->params['summery'] : self::DEFAULT,
                'description' => isset($this->params['description']) ? $this->params['description'] : self::DEFAULT,
                'parameters' => [],
                'responses' => [],
            ];
        }
    }

    private function initResponse()
    {
        $this->config['paths'][$this->call['path']][strtolower($this->call['method'])]['responses'][intval($this->call['code'])] = [
            'description' => isset($this->call['docdocdoc']['description']) ? $this->call['docdocdoc']['description'] : self::DEFAULT,
            'examples' => [
                'application/json' => $this->call['payload']
            ],
        ];
    }

    private function initBodyParameters()
    {
        if(preg_match('/20[01]/', $this->call['code']) && !empty($this->call['body_params'])){
            $this->config['paths'][$this->call['path']][strtolower($this->call['method'])]['parameters'][] = [
                'in' => 'body',
                'name' => 'body',
                'required' => true,
                'schema' => [
                    'type' => 'object',
                    'example' => json_encode($this->call['body_params'])
                ]
            ];
        }
    }

    private function initPathParameters()
    {
        if(!empty($this->call['path_params'])){
            foreach ($this->call['path_params'] as $pathParam => $example){
                if(strpos($this->call['path'], $pathParam) !== false){
                    $this->config['paths'][$this->call['path']][strtolower($this->call['method'])]['parameters'][] = [
                        'in' => 'path',
                        'name' => $pathParam,
                        'required' => true,
                        'schema' => [
                            'type' => gettype($example),
                        ]
                    ];
                }
            }
        }
    }

    private function initQueryParams()
    {
        foreach ($this->call['query_params'] as $queryParam => $example){
            $this->config['paths'][$this->call['path']][strtolower($this->call['method'])]['parameters'][] = [
                'in' => 'query',
                'name' => $queryParam,
                'required' => true,
                'schema' => [
                    'type' => gettype($example),
                ]
            ];
        }
    }

    private function initValidations()
    {
        $formRequest = new FormRequestService($this->call['docdocdoc']);
        foreach ($formRequest->getRules() as $field => $rules){
            $this->config['paths'][$this->call['path']][strtolower($this->call['method'])]['parameters'][] = [
                'in' => 'body',
                'name' => $field,
                'required' => true,
            ];
        }
    }

    private function saveCall()
    {
        Storage::disk('local')->put(self::CONFIG_PATH, json_encode($this->config));
    }

    public function resetConfig()
    {
        Storage::disk('local')->delete(self::CONFIG_PATH);
    }
}
