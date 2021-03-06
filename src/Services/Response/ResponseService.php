<?php


namespace Futurfuturfutur\Docdocdoc\Services\Response;


use Illuminate\Http\Response;

class ResponseService
{
    /**
     * @var Response
     */
    private Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    public function getPayload()
    {
        return $this->response->getContent();
    }
}
