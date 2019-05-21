<?php

namespace Comertis\Http;

use Comertis\Http\HttpRequest;
use Comertis\Http\HttpResponse;

class HttpResult
{
    /**
     * Original HttpRequest
     *
     * @access private
     * @var HttpRequest
     */
    private $_request;

    /**
     * HttpResponse
     *
     * @access private
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
     * @access public
     * @return HttpRequest
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * Set the HttpRequest
     *
     * @access public
     * @param HttpRequest $request
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
     * @access public
     * @return HttpResponse
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * Set the HttpResponse
     *
     * @access public
     * @param HttpResponse $response
     * @return HttpResult
     */
    public function setResponse(HttpResponse $response)
    {
        $this->_response = $response;
        return $this;
    }
}
