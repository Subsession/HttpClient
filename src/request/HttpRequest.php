<?php

namespace Comertis\Http;

use Comertis\Http\HttpRequestMethod;

/**
 * Http Request class
 */
class HttpRequest
{
    /**
     * Base url
     *
     * @access private
     * @param string
     */
    private $_url;

    /**
     * HTTP headers
     *
     * @access private
     * @param array
     */
    private $_headers;

    /**
     * HTTP request method
     *
     * @access private
     * @param string
     */
    private $_requestMethod;

    /**
     * Http request type
     *
     * @access private
     * @param string
     */
    private $_requestType;

    /**
     * Request parameters
     *
     * @access private
     * @var array
     */
    private $_params;

    /**
     * Http client wrapper for cUrl
     *
     * @param string $url
     * @param array $headers
     * @param string $requestMethod
     * @param array $params
     */
    public function __construct($url = null, $headers = [], $requestMethod = null, $params = [])
    {
        if (is_null($requestMethod)) {
            $requestMethod = HttpRequestMethod::GET;
        }

        $this->_url = $url;
        $this->_headers = $headers;
        $this->_requestMethod = $requestMethod;
        $this->_params = $params;
    }

    public function __destruct()
    {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    /**
     * Get the HttpRequest headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->_headers;
    }

    /**
     * Set the HttpRequest headers
     *
     * @param array $headers
     *
     * @return HttpRequest
     */
    public function setHeaders($headers = [])
    {
        $this->_headers = $headers;

        return $this;
    }

    /**
     * Get the HttpRequest method
     *
     * @return string
     */
    public function getRequestMethod()
    {
        return $this->_requestMethod;
    }

    /**
     * Set the HttpRequest method
     *
     * @param string $requestMethod
     *
     * @return HttpRequest
     */
    public function setRequestMethod($requestMethod)
    {
        $this->_requestMethod = $requestMethod;

        return $this;
    }

    /**
     * Get the HttpRequest URL
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * Set the HttpRequest URL
     *
     * @param string $url
     *
     * @return HttpRequest
     */
    public function setUrl($url = null)
    {
        $this->_url = $url;

        return $this;
    }

    /**
     * Get the HttpRequest parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * Set the HttpRequest parameters
     *
     * @param array $params
     *
     * @return HttpRequest
     */
    public function setParams($params)
    {
        $this->_params = $params;

        return $this;
    }

    /**
     * Get the request type
     *
     * @return string
     */
    public function getRequestBodyType()
    {
        return $this->_requestType;
    }

    /**
     * set the request type
     *
     * @param string $requestType
     *
     * @return HttpRequest
     */
    public function setRequestBodyType($requestType)
    {
        $this->_requestType = $requestType;

        return $this;
    }
}
