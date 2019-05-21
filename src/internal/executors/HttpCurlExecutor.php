<?php

namespace Comertis\Http\Internal\Executors;

require_once __DIR__ . '/IHttpExecutor.php';

use Comertis\Http\Exceptions\HttpClientException;
use Comertis\Http\HttpRequest;
use Comertis\Http\HttpRequestMethod;
use Comertis\Http\HttpRequestType;
use Comertis\Http\HttpResponse;
use Comertis\Http\HttpResult;
use Comertis\Http\Internal\Executors\IHttpExecutor;

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
                $request->addHeaders(["Content-Length" => strlen(implode($params))]);
            } else if (is_object($params)) {
                $request->addHeaders(["Content-Length" => strlen(serialize($params))]);
            } else {
                $request->addHeaders(["Content-Length" => strlen($params)]);
            }
        }

        switch ($request->getBodyType()) {
            case HttpRequestType::JSON:
                $request->addHeaders(["Content-Type" => HttpRequestType::JSON]);
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
                case HttpRequestType::JSON:
                    curl_setopt($this->_ch, CURLOPT_POSTFIELDS, json_encode($params));
                    break;

                case HttpRequestType::X_WWW_FORM_URLENCODED:
                default:
                    curl_setopt($this->_ch, CURLOPT_POSTFIELDS, http_build_query($params));
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
        /**
         * @var array
         */
        $responseHeaders = [];

        /**
         * @var string|bool
         */
        $responseBody = false;

        /**
         * @var array
         */
        $responseInfo = [];

        /**
         * @var int
         */
        $responseStatusCode = 500;

        /**
         * @var string|null
         */
        $responseError = null;

        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->_ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($this->_ch, CURLOPT_URL, $request->getUrl());
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $request->getHeaders());
        curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, $request->getMethod());

        curl_setopt($this->_ch, CURLOPT_HEADERFUNCTION, function ($curl, $header) use (&$responseHeaders) {
            $headerLength = strlen($header);
            $header = explode(':', $header, 2);

            if (count($header) < 2) {
                return $headerLength;
            }

            $responseHeaders[trim($header[0])] = trim($header[1]);

            return $headerLength;
        });

        $responseBody = curl_exec($this->_ch);

        if (curl_errno($this->_ch)) {
            $responseError = curl_error($this->_ch);
        }

        if (!$responseBody) {
            throw new HttpClientException("Failed to get response. Error: " . $responseError ?: "No error message to show.");
        }

        $responseInfo = curl_getinfo($this->_ch);
        $responseStatusCode = $responseInfo['http_code'];

        $response = new HttpResponse($responseHeaders, $responseStatusCode, $responseBody);
        $response->setTransactionTime($responseInfo['total_time'])
            ->setDownloadSpeed($responseInfo['speed_download'])
            ->setUploadSpeed($responseInfo['speed_upload'])
            ->setHeadersSize($responseInfo['header_size'])
            ->setError($responseError);

        return new HttpResult($request, $response);
    }
}
