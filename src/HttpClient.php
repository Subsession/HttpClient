<?php

namespace Comertis\Http;

use Comertis\Http\Exceptions\HttpClientException;
use Comertis\Http\HttpRequest;
use Comertis\Http\HttpRequestMethod;
use Comertis\Http\HttpRequestType;
use Comertis\Http\HttpResponse;
use Comertis\Http\Internal\Executors\HttpExecutor;

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
     * @var HttpExecutor
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
        $this->_executor = new HttpExecutor();
    }

    public function __destruct()
    {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    /**
     * @see HttpRequest::getUrl()
     *
     * @access public
     * @return string
     */
    public function getUrl()
    {
        return $this->_request->getUrl();
    }

    /**
     * @see HttpRequest::setUrl()
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
     * @see HttpRequest::getHeaders()
     *
     * @access public
     * @return array
     */
    public function getHeaders()
    {
        return $this->_request->getHeaders();
    }

    /**
     * @see HttpRequest::setHeaders()
     *
     * @access public
     * @param array $headers
     * @return HttpClient
     */
    public function setHeaders(array $headers)
    {
        $this->_request->setHeaders($headers);

        return $this;
    }

    /**
     * @see HttpRequest::addHeaders()
     *
     * @param array $headers
     * @return HttpClient
     */
    public function addHeaders(array $headers)
    {
        $this->_request->addHeaders($headers);

        return $this;
    }

    /**
     * @see HttpRequest::setHeaders()
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
     * @see HttpExecutor::getRetryCount()
     *
     * @access public
     * @return int
     */
    public function getRetryCount()
    {
        return $this->_executor->getRetryCount();
    }

    /**
     * @see HttpExecutor::setRetryCount()
     *
     * @param int $retryCount Number of retries on a connection before giving up
     * @access public
     * @return HttpClient
     */
    public function setRetryCount($retryCount)
    {
        $this->_executor->setRetryCount($retryCount);

        return $this;
    }

    /**
     * Get the explicitly specified IHttpExecutor implementation
     * used for requests
     *
     * @access public
     * @return string|null
     */
    public function getExplicitExecutor()
    {
        return $this->_executor->getExplicitExecutor();
    }

    /**
     * Specify an explicit IHttpExecutor implementation to use
     * for requests
     *
     * @access public
     * @param string $executorImplementation
     * @return HttpClient
     */
    public function setExplicitExecutor($executorImplementation)
    {
        $this->_executor->setExplicitExecutor($executorImplementation);

        return $this;
    }

    /**
     * Execute a GET request
     *
     * @access public
     * @param array $params Parameters to include in the request
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
     * @param array $params Parameters to include in the request
     * @return HttpResponse
     */
    public function post($params = [])
    {
        $this->_request
            ->setMethod(HttpRequestMethod::POST)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a POST request with JSON formatted parameters
     *
     * @access public
     * @param array|mixed|object $params Parameters to include in the request
     * @throws HttpClientException
     * @return HttpResponse
     */
    public function postJson($params = [])
    {
        $this->_request
            ->setMethod(HttpRequestMethod::POST)
            ->setBodyType(HttpRequestType::JSON)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a PUT request
     *
     * @access public
     * @param array|mixed|object $params Parameters to include in the request
     * @return HttpResponse
     */
    public function put($params = [])
    {
        $this->_request
            ->setMethod(HttpRequestMethod::PUT)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a PUT request with JSON formatted parameters
     *
     * @access public
     * @param array|mixed|object $params Parameters to be json encoded
     * @return HttpResponse
     */
    public function putJson($params = [])
    {
        $this->_request
            ->setMethod(HttpRequestMethod::PUT)
            ->setBodyType(HttpRequestType::JSON)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a DELETE request
     *
     * @access public
     * @param array $params Parameters to include in the request
     * @return HttpResponse
     */
    public function delete($params = [])
    {
        $this->_request
            ->setMethod(HttpRequestMethod::DELETE)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a DELETE request with JSON encoded parameters
     *
     * @access public
     * @param array $params Parameters to be json encoded
     * @throws HttpClientException
     * @return HttpResponse
     */
    public function deleteJson($params = [])
    {
        $this->_request
            ->setMethod(HttpRequestMethod::DELETE)
            ->setBodyType(HttpRequestType::JSON)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }
}
