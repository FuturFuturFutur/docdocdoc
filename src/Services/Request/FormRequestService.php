<?php


namespace Futurfuturfutur\Docdocdoc\Services\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use ReflectionClass;
use ReflectionMethod;

class FormRequestService
{

    private ?FormRequest $formRequest = null;

    public function __construct($params)
    {
        $this->formRequest = isset($params['request']) ? new $params['request'] : $this->getInjectedFormRequest();
    }

    public function getRules()
    {
        return $this->formRequest ? $this->formRequest->rules() : [];
    }

    private function getInjectedFormRequest()
    {
        $route = Route::currentRouteAction();
        $controllerAndAction = explode('@', $route);

        $reflection = new ReflectionMethod($controllerAndAction[0], $controllerAndAction[1]);
        $params = $reflection->getParameters();

        foreach ($params as $param){
            $paramClass = $param->getClass();
            if($paramClass->isSubclassOf(FormRequest::class)){
                $formRequestClass =$paramClass->getName();
                return new $formRequestClass;
            }
        }

        return null;
    }
}
