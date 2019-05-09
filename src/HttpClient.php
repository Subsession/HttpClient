<?php

namespace Comertis\Http;

use Comertis\Http\HttpClientException;
use Comertis\Http\HttpRequest;
use Comertis\Http\HttpRequestBodyType;
use Comertis\Http\HttpRequestMethod;
use Comertis\Http\HttpResponse;
use Comertis\Http\HttpResult;
use Comertis\Http\HttpStatusCode;

/**
 * Http client wrapper for cURL
 */
class HttpClient
{
    /**
     * cURL instance
     *
     * @access private
     */
    private $_ch;

    /**
     * HttpRequest instance
     *
     * @access private
     * @property HttpRequest
     */
    private $_request;

    /**
     * HttpResponse instance
     *
     * @access private
     * @property HttpResponse
     */
    private $_response;

    /**
     * Request retry count
     *
     * @access private
     * @property int
     */
    private $_retry;

    /**
     * @param string|null $url
     */
    public function __construct($url = null)
    {
        $this->_request = new HttpRequest();
        $this->_request->setUrl($url);

        $this->_response = new HttpResponse();

        $this->_ch = curl_init($this->_request->getUrl());
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        curl_close($this->_ch);

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
     * Set the curl headers
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
     * Get the configured retry count
     *
     * @access public
     * @return int
     */
    public function getRetryCount()
    {
        return $this->_retry;
    }

    /**
     * Set the retry count for requests
     *
     * @access public
     * @param int $retryCount
     * @return HttpClient
     */
    public function setRetryCount($retryCount = 1)
    {
        $this->_retry = $retryCount;

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
            ->setRequestMethod(HttpRequestMethod::GET)
            ->setParams($params);

        $result = $this->_execute($this->_request);

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
            ->setRequestMethod(HttpRequestMethod::POST)
            ->setParams($params);

        $result = $this->_execute($this->_request);

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
            ->setRequestMethod(HttpRequestMethod::POST)
            ->setRequestBodyType(HttpRequestBodyType::JSON)
            ->setParams($params);

        $result = $this->_execute($this->_request);

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
            ->setRequestMethod(HttpRequestMethod::PUT)
            ->setParams($params);

        $result = $this->_execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a DELETE request
     *
     * @access public
     * @param array $params Array of parameters to include in the request
     * @return HttpResponse
     */
    public function delete(array $params)
    {
        $this->_request
            ->setRequestMethod(HttpRequestMethod::DELETE)
            ->setParams($params);

        $result = $this->_execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a DELETE request with json encoded parameters
     *
     * @access public
     * @param array $params Array of parameters to be json encoded
     *
     * @return HttpResponse
     */
    public function deleteJson(array $params)
    {
        $jsonParams = json_encode($params);

        if (empty($jsonParams)) {
            throw new QuiterException("Failed to json_encode request parameters");
        }

        $this->_request
            ->setRequestMethod(HttpRequestMethod::DELETE)
            ->setRequestBodyType(HttpRequestBodyType::JSON)
            ->setParams($jsonParams);

        $result = $this->_execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute the HttpRequest
     *
     * @access private
     * @param HttpRequest $request
     * @throws HttpClientException
     * @return HttpResult
     */
    private function _execute(HttpRequest $request)
    {
        $responseHeaders = [];
        $statusCode = 200;

        if (!empty($params = $request->getParams())) {
            if ($request->getRequestMethod() == HttpRequestMethod::GET) {

                $url = $request->getUrl();
                $url .= "?";

                foreach ($params as $key => $value) {
                    $url .= $key . "=" . $value . "&";
                }

                $url = trim($url, "&");

                $request->setUrl($url);

            } else {
                switch ($request->getRequestBodyType()) {
                    case HttpRequestBodyType::JSON:
                        curl_setopt($this->_ch, CURLOPT_POSTFIELDS, json_encode($params));
                        break;

                    default:
                        curl_setopt($this->_ch, CURLOPT_POSTFIELDS, http_build_query($params));
                        break;
                }
            }
        }

        curl_setopt($this->_ch, CURLOPT_URL, $request->getUrl());
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $request->getHeaders());
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, $request->getRequestMethod());

        curl_setopt($this->_ch, CURLOPT_HEADERFUNCTION, function ($curl, $header) use (&$responseHeaders) {
            $headerLength = strlen($header);
            $header = explode(':', $header, 2);

            if (count($header) < 2) {
                return $headerLength;
            }

            $name = strtolower(trim($header[0]));

            if (!array_key_exists($name, $responseHeaders)) {
                $responseHeaders[$name] = [trim($header[1])];
            } else {
                $responseHeaders[$name][] = trim($header[1]);
            }

            return $headerLength;
        });

        for ($i = 0; $i < $this->getRetryCount(); $i++) {
            $responseBody = curl_exec($this->_ch);
            $responseInfo = curl_getinfo($this->_ch);
            $responseStatusCode = $responseInfo['http_code'];

            $statusCode = $responseStatusCode;

            if ($responseStatusCode !== HttpStatusCode::INTERNAL_SERVER_ERROR) {
                break;
            }

            sleep(1);
        }

        if (!isset($responseBody) || !$responseBody) {
            throw new HttpClientException("Failed to get response after " . $this->getRetryCount() . " tries.");
        }

        $this->_response = new HttpResponse($responseHeaders, $statusCode, $responseBody);

        return new HttpResult($this->_request, $this->_response);
    }
}
