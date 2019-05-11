<?php

namespace Comertis\Http;

use Comertis\Http\HttpClientException;
use Comertis\Http\HttpRequest;
use Comertis\Http\HttpRequestBodyType;
use Comertis\Http\HttpRequestMethod;
use Comertis\Http\HttpResponse;
use Comertis\Http\HttpResult;
use Comertis\Http\HttpStatusCode;

class HttpRequestExecutor
{
    /**
     * cURL instance
     *
     * @access private
     */
    private $_ch;

    /**
     * Request retry count
     *
     * @access private
     * @var int
     */
    private $_retry;

    public function __construct()
    {
        $this->_ch = curl_init();
        $this->_retry = 1;
    }

    public function __destruct()
    {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
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
     * @return HttpRequestExecutor
     */
    public function setRetryCount($retryCount = 1)
    {
        $this->_retry = $retryCount;

        return $this;
    }

    /**
     * Execute the HttpRequest
     *
     * @access private
     * @param HttpRequest $request
     * @throws HttpClientException
     * @return HttpResult
     */
    public function execute(HttpRequest $request)
    {
        $responseHeaders = [];
        $responseStatusCode = 200;

        $this->_prepareUrl($request);
        $this->_prepareHeaders($request);
        $this->_prepareParams($request);

        \curl_setopt($this->_ch, CURLOPT_URL, $request->getUrl());
        \curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $request->getHeaders());
        \curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, $request->getMethod());

        \curl_setopt($this->_ch, CURLOPT_HEADERFUNCTION, function ($curl, $header) use (&$responseHeaders) {
            $headerLength = \strlen($header);
            $header = \explode(':', $header, 2);

            if (\count($header) < 2) {
                return $headerLength;
            }

            $key = \trim($header[0]);
            $value = \trim($header[1]);

            $responseHeaders[$key] = $value;

            return $headerLength;
        });

        for ($i = 0; $i < $this->getRetryCount(); $i++) {
            $responseBody = \curl_exec($this->_ch);
            $responseInfo = \curl_getinfo($this->_ch);
            $responseStatusCode = $responseInfo['http_code'];

            if ($responseStatusCode !== HttpStatusCode::INTERNAL_SERVER_ERROR) {
                break;
            }

            \sleep(1);
        }

        if (!isset($responseBody) || !$responseBody) {
            throw new HttpClientException("Failed to get response after " . $this->getRetryCount() . " tries. Status code: " . $responseStatusCode);
        }

        $response = new HttpResponse($responseHeaders, $responseStatusCode, $responseBody);

        return new HttpResult($request, $response);
    }

    /**
     * Prepare the request URL based on the request type
     *
     * @param HttpRequest $request
     * @access private
     * @return void
     */
    private function _prepareUrl(HttpRequest &$request)
    {
        $params = null;
        if (empty($params = $request->getParams())) {
            return;
        }

        if ($request->getMethod() == HttpRequestMethod::GET) {
            $request->setUrl($this->_urlEncodeParams($request->getUrl(), $params));
        }
    }

    /**
     * Prepare the request headers based on the request type and parameters
     *
     * @param HttpRequest $request
     * @access private
     * @return void
     */
    private function _prepareHeaders(HttpRequest &$request)
    {
        if (!empty($params = $request->getParams())) {
            $request->addHeaders(["Content-Length" => \strlen($params)]);
        }

        switch ($request->getBodyType()) {
            case HttpRequestBodyType::JSON:
                $request->addHeaders(["Content-Type" => HttpRequestBodyType::JSON]);
                break;

            default:
                break;
        }
    }

    /**
     * Prepare the request parameters based on the request tyoe
     *
     * @param HttpRequest $request
     * @access private
     * @return void
     */
    private function _prepareParams(HttpRequest &$request)
    {
        if (!empty($params = $request->getParams())) {
            switch ($request->getBodyType()) {
                case HttpRequestBodyType::JSON:
                    \curl_setopt($this->_ch, CURLOPT_POSTFIELDS, \json_encode($params));
                    break;

                default:
                    \curl_setopt($this->_ch, CURLOPT_POSTFIELDS, \http_build_query($params));
                    break;
            }
        }
    }

    /**
     * Encode request parameters into the URL
     *
     * @param string $url
     * @param array $params
     * @return string
     */
    private function _urlEncodeParams($url, array $params)
    {
        $url .= "?";

        foreach ($params as $key => $value) {
            $url .= $key . "=" . $value . "&";
        }

        $url = trim($url, "&");

        return $url;
    }
}
