<?php

namespace Comertis\Http\Internal;

use Comertis\Http\HttpClientException;
use Comertis\Http\HttpRequest;
use Comertis\Http\HttpRequestBodyType;
use Comertis\Http\HttpRequestMethod;
use Comertis\Http\HttpResponse;
use Comertis\Http\HttpResult;

/**
 * IHttpExecutor implementation using the cURL
 * php extension
 */
class HttpCurlExecutor implements IHttpExecutor
{
    /**
     * cURL instance
     *
     * @access private
     * @var resource
     */
    private $_ch;

    public function __construct()
    {
        $this->_ch = curl_init();
    }

    public function __destruct()
    {
        curl_close($this->_ch);
    }

    /**
     * @see IHttpExecutor::prepareUrl()
     *
     * @param HttpRequest $request
     * @access public
     * @return void
     */
    public function prepareUrl(HttpRequest &$request)
    {
        $params = null;
        if (empty($params = $request->getParams())) {
            return;
        }

        if ($request->getMethod() == HttpRequestMethod::GET) {

            $url = $request->getUrl();
            $url .= "?";

            foreach ($params as $key => $value) {
                $url .= $key . "=" . $value . "&";
            }

            $url = trim($url, "&");

            $request->setUrl($url);
        }
    }

    /**
     * @see IHttpExecutor::prepareHeaders()
     *
     * @param HttpRequest $request
     * @access public
     * @return void
     */
    public function prepareHeaders(HttpRequest &$request)
    {
        $params = null;
        if (!empty($params = $request->getParams())) {
            if (is_array($params)) {
                $request->addHeaders(["Content-Length" => \strlen(implode($params))]);
            } else if (is_object($params)) {
                $request->addHeaders(["Content-Length" => \strlen(serialize($params))]);
            } else {
                $request->addHeaders(["Content-Length" => \strlen($params)]);
            }
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
     * @see IHttpExecutor::prepareParams()
     *
     * @param HttpRequest $request
     * @access public
     * @return void
     */
    public function prepareParams(HttpRequest &$request)
    {
        $params = null;
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
     * @see IHttpExecutor::execute()
     *
     * @access private
     * @param HttpRequest $request
     * @throws HttpClientException
     * @return HttpResult
     */
    public function execute(HttpRequest $request)
    {
        $responseHeaders = [];
        $responseBody = false;
        $responseInfo = [];
        $responseStatusCode = 500;

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

        $responseBody = \curl_exec($this->_ch);
        $responseInfo = \curl_getinfo($this->_ch);
        $responseStatusCode = $responseInfo['http_code'];

        if (!isset($responseBody) || !$responseBody) {
            throw new HttpClientException("Failed to get response after " . $this->getRetryCount() . " tries. Status code: " . $responseStatusCode);
        }

        $response = new HttpResponse($responseHeaders, $responseStatusCode, $responseBody);
        $response->setTransactionTime($responseInfo['total_time'])
            ->setDownloadSpeed($responseInfo['speed_download'])
            ->setUploadSpeed($responseInfo['speed_upload'])
            ->setHeadersSize($responseInfo['header_size']);

        return new HttpResult($request, $response);
    }
}
