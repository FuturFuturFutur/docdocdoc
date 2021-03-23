<?php


namespace Futurfuturfutur\Docdocdoc\Services\Request;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RequestService
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getHost()
    {
        return $this->request->server('HTTP_HOST');
    }

    public function getHeaders()
    {
        return $this->request->headers->all();
    }

    public function getBodyParams()
    {
        return $this->request->request->all();
    }

    public function getQueryParams()
    {
        return $this->request->query->all();
    }

    public function getPathParams()
    {
        return Route::current()->parameters;
    }

    public function getMethod()
    {
        return $this->request->getMethod();
    }

    public function getPath()
    {
        return Route::current()->uri;
    }

    public function getPrefix()
    {
        return Route::current()->getAction()['prefix'];
    }
}
