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
 * Undocumented class
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
class HttpStreamAdapter extends HttpBaseAdapter
{
    /**
     * Stream context options
     *
     * @access private
     * @var    array
     */
    private $options;

    /**
     * Expected extensions for this HttpAdapterInterface implementation
     * to work properly
     *
     * @access public
     * @var    array
     */
    const EXPECTED_EXTENSIONS = [

    ];

    /**
     * Expected functions for this HttpAdapterInterface implementation
     * to work properly
     *
     * @access public
     * @var    array
     */
    const EXPECTED_FUNCTIONS = [
        "stream_context_create",
        "fopen",
        "fclose",
        "stream_get_meta_data",
        "stream_get_contents",
    ];

    /**
     * @inheritDoc
     */
    public function prepareUrl(HttpRequestInterface &$request)
    {
        if ($request->getMethod() !== HttpRequestMethod::GET) {
            return;
        }

        if (empty($request->getParams())) {
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
     */
    public function prepareHeaders(HttpRequestInterface &$request)
    {
        $this->options = [
            "http" => [
                "method" => $request->getMethod(),
                "header" => "",
            ],
        ];

        foreach ($request->getHeaders() as $key => $value) {
            $this->options["http"]["header"] .= $key . "=" . $value . ";";
        }

        if (!empty($bodyType = $request->getBodyType())) {
            $this->options["http"]["header"] .= "Content-Type: " . $bodyType . ";";
        }
    }

    /**
     * @inheritDoc
     */
    public function prepareParams(HttpRequestInterface &$request)
    {
        if (empty($request->getParams())) {
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

        if (empty($params) || null === $params) {
            throw new ArgumentException("Failed to parse request parameters");
        }

        $this->options["http"]["content"] = $params;
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

        $context = stream_context_create($this->options);

        $stream = @fopen($request->getUrl(), "r", false, $context);

        if ($stream) {
            $responseInfo = stream_get_meta_data($stream);
            $responseBody = stream_get_contents($stream);
            fclose($stream);
        } elseif (isset($http_response_header)) {
            $responseInfo["wrapper_data"] = $http_response_header;
        }

        if (isset($responseInfo["wrapper_data"])) {
            $headers = $responseInfo["wrapper_data"];

            // Set headers
            for ($i = 1; $i < count($headers); $i++) {
                $currentHeader = explode(":", $headers[$i], 2);
                $responseHeaders[trim($currentHeader[0])] = trim($currentHeader[1]);
            }

            // Set status code
            $match = [];
            $status_line = $responseInfo["wrapper_data"][0];

            preg_match("{HTTP\/\S*\s(\d{3})}", $status_line, $match);

            if (isset($match[1])) {
                $responseStatusCode = (integer) $match[1];
            }
        }

        $response = HttpResponseBuilder::build();
        $response
            ->setHeaders($responseHeaders)
            ->setStatusCode($responseStatusCode)
            ->setBody($responseBody)
            ->setError($responseError);

        return $response;
    }
}
