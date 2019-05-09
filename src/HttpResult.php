<?php

namespace Comertis\Http;

class HttpResult
{
    /**
     * Original HttpRequest
     *
     * @var HttpRequest
     */
    private $_request;

    /**
     * HttpResponse
     *
     * @var HttpResponse
     */
    private $_response;

    /**
     * Create a new HttpResult
     *
     * @param HttpRequest $request
     * @param HttpResponse $response
     */
    public function __construct(HttpRequest $request = null, HttpResponse $response = null)
    {
        $this->_request = $request;
        $this->_response = $response;
    }

    public function __destruct()
    {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    /**
     * Get the original sent HttpRequest
     *
     * @return HttpRequest
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * Set the HttpRequest
     *
     * @param HttpRequest $request
     *
     * @return HttpResult
     */
    public function setRequest(HttpRequest $request)
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * Get the HttpResponse
     *
     * @return HttpResponse
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * Set the HttpResponse
     *
     * @param HttpResponse $response
     *
     * @return HttpResult
     */
    public function setResponse(HttpResponse $response)
    {
        $this->_response = $response;
        return $this;
    }
}
