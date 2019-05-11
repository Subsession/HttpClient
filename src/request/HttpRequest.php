<?php

namespace Comertis\Http;

use Comertis\Http\HttpRequestMethod;

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
    private $_method;

    /**
     * Http request type
     *
     * @access private
     * @param string
     */
    private $_bodyType;

    /**
     * Request parameters
     *
     * @access private
     * @param array
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
        $this->_method = $requestMethod;
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
     * @access public
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
     * @access public
     * @return HttpRequest
     */
    public function setHeaders(array $headers = [])
    {
        $this->_headers = $headers;

        return $this;
    }

    /**
     * Add headers to the request
     * if they are not already present
     *
     * @param array $headers
     * @access public
     * @return void
     */
    public function addHeaders(array $headers = [])
    {
        foreach ($headers as $key => $value) {
            if (!\array_key_exists($key, $this->_headers)) {
                $this->_headers[$key] = $value;
            }
        }
    }

    /**
     * Get the HttpRequest method
     *
     * @access public
     * @return string
     */
    public function getMethod()
    {
        return $this->_method;
    }

    /**
     * Set the HttpRequest method
     *
     * @param string $requestMethod
     * @access public
     * @return HttpRequest
     */
    public function setMethod($requestMethod)
    {
        $this->_method = $requestMethod;

        return $this;
    }

    /**
     * Get the HttpRequest URL
     *
     * @access public
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
     * @access public
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
     * @access public
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
     * @access public
     * @return HttpRequest
     */
    public function setParams(array $params)
    {
        $this->_params = $params;

        return $this;
    }

    /**
     * Get the request body type
     *
     * @access public
     * @return string
     */
    public function getBodyType()
    {
        return $this->_bodyType;
    }

    /**
     * Set the request body type
     *
     * @param string $bodyType
     * @access public
     * @return HttpRequest
     */
    public function setBodyType($bodyType)
    {
        $this->_bodyType = $bodyType;

        return $this;
    }
}
