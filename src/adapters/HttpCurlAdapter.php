<?php
/**
 * PHP Version 7
 *
 * LICENSE:
 * Proprietary, see the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Comertis <info@comertis.com>
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
 * @version  GIT: &Id&
 * @link     https://github.com/Comertis/HttpClient
 */

namespace Comertis\Http\Adapters;

use Comertis\Exceptions\ArgumentException;
use Comertis\Http\Abstraction\HttpRequestInterface;
use Comertis\Http\Adapters\HttpBaseAdapter;
use Comertis\Http\Builders\HttpResponseBuilder;
use Comertis\Http\HttpRequestMethod;
use Comertis\Http\HttpRequestType;

/**
 * HttpAdapterInterface implementation using the CURL
 * PHP extension
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
class HttpCurlAdapter extends HttpBaseAdapter
{
    /**
     * CURL instance
     *
     * @access private
     * @var    resource
     */
    private $ch;

    /**
     * Expected extensions for this HttpAdapterInterface implementation
     * to work properly
     *
     * @access public
     * @var    array
     */
    const EXPECTED_EXTENSIONS = [
        "curl",
    ];

    /**
     * Expected functions for this HttpAdapterInterface implementation
     * to work properly
     *
     * @access public
     * @var    array
     */
    const EXPECTED_FUNCTIONS = [
        "curl_init",
        "curl_close",
        "curl_setopt",
        "curl_exec",
        "curl_errno",
        "curl_getinfo",
    ];

    /**
     * Constructor
     */
    public function __construct()
    {
        try {
            $this->ch = curl_init();
        } catch (\Throwable $exception) {
            // Ignored for now
        }
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        if (is_resource($this->ch)) {
            curl_close($this->ch);
        }
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function prepareUrl(HttpRequestInterface &$request)
    {
        $method = $request->getMethod();

        if ($method !== HttpRequestMethod::GET || $method !== HttpRequestMethod::HEAD) {
            return;
        }

        $params = $request->getParams();

        if (empty($params) || null === $params) {
            return;
        }

        $url = $request->getUrl();

        $separator = "?";

        // If "?" already exists in the url
        if (strpos($url, $separator) !== false) {
            $separator = "&";
        }

        $url .= $separator . http_build_query($params);

        $request->setUrl($url);
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function prepareHeaders(HttpRequestInterface &$request)
    {
        if (empty($request->getParams())) {
            return;
        }

        $method = $request->getMethod();

        if ($method === HttpRequestMethod::GET || $method === HttpRequestMethod::HEAD) {
            return;
        }

        $params = $request->getParams();
        $contentLength = 0;

        if (is_array($params)) {
            foreach ($params as $key => $value) {
                if (is_object($value)) {
                    $contentLength += strlen(serialize($value));
                } else {
                    $contentLength += strlen($value);
                }
            }
        } elseif (is_object($params)) {
            $contentLength = strlen(serialize($params));
        } else {
            $contentLength = strlen($params);
        }

        $request->addHeaders(["Content-Length" => $contentLength]);

        switch ($request->getBodyType()) {
            case HttpRequestType::JSON:
                $request->addHeaders(["Content-Type" => HttpRequestType::JSON]);
                break;

            default:
                break;
        }
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function prepareParams(HttpRequestInterface &$request)
    {
        if (empty($request->getParams())) {
            return;
        }

        $method = $request->getMethod();

        if ($method === HttpRequestMethod::GET || $method === HttpRequestMethod::HEAD) {
            return;
        }

        $params = $request->getParams();

        switch ($request->getBodyType()) {
            case HttpRequestType::JSON:
                $params = json_encode($params);
                break;

            case HttpRequestType::X_WWW_FORM_URLENCODED:
            default:
                $params = http_build_query($params);
                break;
        }

        if (empty($params) | is_null($params)) {
            throw new ArgumentException("Failed to parse request parameters");
        }

        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
    }

    /**
     * @inheritDoc
     */
    public function handle(HttpRequestInterface $request)
    {
        parent::handle($request);

        /**
         * Response headers
         *
         * @var array
         */
        $responseHeaders = [];

        /**
         * Response body
         *
         * @var string|null
         */
        $responseBody = null;

        /**
         * Response metadata
         *
         * @var array
         */
        $responseInfo = [];

        /**
         * Response status code
         *
         * @var integer
         */
        $responseStatusCode = 500;

        /**
         * Response error message
         *
         * @var string|null
         */
        $responseError = null;

        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($this->ch, CURLOPT_URL, $request->getUrl());
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $request->getHeaders());
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $request->getMethod());

        curl_setopt(
            $this->ch,
            CURLOPT_HEADERFUNCTION,
            function ($curl, $header) use (&$responseHeaders) {
                $headerLength = strlen($header);
                $header = explode(':', $header, 2);

                if (count($header) < 2) {
                    return $headerLength;
                }

                $responseHeaders[trim($header[0])] = trim($header[1]);

                return $headerLength;
            }
        );

        $responseBody = curl_exec($this->ch);

        if (curl_errno($this->ch)) {
            $responseError = curl_error($this->ch);
        }

        $responseInfo = curl_getinfo($this->ch);
        $responseStatusCode = $responseInfo['http_code'];

        $response = HttpResponseBuilder::build();
        $response
            ->setHeaders($responseHeaders)
            ->setStatusCode($responseStatusCode)
            ->setBody($responseBody)
            ->setError($responseError);

        return $response;
    }
}
