<?php

namespace Comertis\Http;

use Comertis\Http\HttpClientException;
use Comertis\Http\HttpRequest;
use Comertis\Http\HttpRequestExecutor;
use Comertis\Http\HttpRequestMethod;
use Comertis\Http\HttpResponse;

/**
 * Http client wrapper for cURL
 */
class HttpClient
{
    /**
     * Holds the request information
     *
     * @access private
     * @var HttpRequest
     */
    private $_request;

    /**
     * Holds the response information once a request has been executed
     *
     * @access private
     * @var HttpResponse
     */
    private $_response;

    /**
     * Responsible for executing a HttpRequest
     *
     * @access private
     * @var HttpRequestExecutor
     */
    private $_executor;

    /**
     * @param string|null $url
     */
    public function __construct($url = null)
    {
        $this->_request = new HttpRequest();
        $this->_request->setUrl($url);

        $this->_response = new HttpResponse();
        $this->_executor = new HttpRequestExecutor();
    }

    public function __destruct()
    {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    /**
     * Get the endpoint URL
     *
     * @access public
     * @return string
     */
    public function getUrl()
    {
        return $this->_request->getUrl();
    }

    /**
     * Set the endpoint URL
     *
     * @access public
     * @param string $url
     * @return HttpClient
     */
    public function setUrl($url = null)
    {
        $this->_request->setUrl($url);

        return $this;
    }

    /**
     * Get the HttpRequest headers
     *
     * @access public
     * @return array
     */
    public function getHeaders()
    {
        return $this->_request->getHeaders();
    }

    /**
     * Set the request headers
     *
     * @access public
     * @param array $headers
     * @return HttpClient
     */
    public function setHeaders(array $headers)
    {
        $this->_request->addHeaders($headers);

        return $this;
    }

    /**
     * Clear the request headers
     *
     * @return HttpClient
     */
    public function clearHeaders()
    {
        $this->_request->setHeaders([]);

        return $this;
    }

    /**
     * Get the HttpClient request
     *
     * @access public
     * @return HttpRequest
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * Set the HttpClient request
     *
     * @access public
     * @param HttpRequest $request
     * @return HttpClient
     */
    public function setRequest(HttpRequest $request)
    {
        $this->_request = $request;

        return $this;
    }

    /**
     * Get the configured retry count in case a connection
     * failes to respond
     *
     * @access public
     * @return int
     */
    public function getRetryCount()
    {
        return $this->_executor->getRetryCount();
    }

    /**
     * Set the number of times to retry a request in case
     * of failing to get a response
     *
     * @param int $retryCount
     * @access public
     * @return HttpClient
     */
    public function setRetryCount($retryCount)
    {
        $this->_executor->setRetryCount($retryCount);

        return $this;
    }

    /**
     * Execute a GET request
     *
     * @access public
     * @param array $params
     * @return HttpResponse
     */
    public function get(array $params = [])
    {
        $this->_request
            ->setMethod(HttpRequestMethod::GET)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a POST request
     *
     * @access public
     * @param array $params
     * @return HttpResponse
     */
    public function post(array $params = [])
    {
        $this->_request
            ->setMethod(HttpRequestMethod::POST)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a POST request against the endpoint with JSON formatted parameters
     *
     * @access public
     * @param array $params
     * @throws HttpClientException
     * @return HttpResponse
     */
    public function postJson(array $params = [])
    {
        if (!empty($params)) {
            $params = json_encode($params);

            if (empty($params)) {
                throw new HttpClientException("Failed to json_encode post parameters");
            }
        }

        $this->_request
            ->setMethod(HttpRequestMethod::POST)
            ->setBodyType(HttpRequestBodyType::JSON)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a PUT request
     *
     * @access public
     * @param array $params
     * @return HttpResponse
     */
    public function put(array $params)
    {
        $this->_request
            ->setMethod(HttpRequestMethod::PUT)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a DELETE request
     *
     * @access public
     * @param array $params Array of parameters to include in the request
     * @return HttpResponse
     */
    public function delete(array $params = [])
    {
        $this->_request
            ->setMethod(HttpRequestMethod::DELETE)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a DELETE request with json encoded parameters
     *
     * @access public
     * @param array $params Array of parameters to be json encoded
     * @throws HttpClientException
     * @return HttpResponse
     */
    public function deleteJson(array $params = [])
    {
        if (!empty($params)) {
            $params = json_encode($params);

            if (empty($params)) {
                throw new HttpClientException("Failed to json_encode request parameters");
            }
        }

        $this->_request
            ->setMethod(HttpRequestMethod::DELETE)
            ->setBodyType(HttpRequestBodyType::JSON)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }
}
