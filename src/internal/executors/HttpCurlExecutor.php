<?php
/**
 * PHP Version 7
 *
 * LICENSE:
 * Permission is hereby granted, free of charge, to any
 * person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the
 * Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall
 * be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  GIT: &Id&
 * @link     https://github.com/Comertis/HttpClient
 */

namespace Comertis\Http\Internal\Executors;

require_once __DIR__ . '/IHttpExecutor.php';

use Comertis\Http\Exceptions\HttpExecutorException;
use Comertis\Http\HttpRequest;
use Comertis\Http\HttpRequestMethod;
use Comertis\Http\HttpRequestType;
use Comertis\Http\HttpResponse;
use Comertis\Http\HttpResult;
use Comertis\Http\Internal\Executors\IHttpExecutor;

/**
 * IHttpExecutor implementation using the CURL
 * PHP extension
 *
 * @uses Comertis\Http\Exceptions\HttpExecutorException
 * @uses Comertis\Http\HttpRequest
 * @uses Comertis\Http\HttpRequestMethod
 * @uses Comertis\Http\HttpRequestType
 * @uses Comertis\Http\HttpResponse
 * @uses Comertis\Http\HttpResult
 * @uses Comertis\Http\Internal\Executors\IHttpExecutor
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
class HttpCurlExecutor implements IHttpExecutor
{
    /**
     * CURL instance
     *
     * @access private
     * @var    resource
     */
    private $_ch;

    /**
     * Expected extensions for this IHttpExecutor implementation
     * to work properly
     *
     * @access public
     * @var    array
     */
    const EXPECTED_EXTENSIONS = [
        "curl",
    ];

    /**
     * Expected functions for this IHttpExecutor implementation
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
        $this->_ch = curl_init();
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        curl_close($this->_ch);
    }

    /**
     * @inheritDoc
     */
    public function prepareUrl(HttpRequest &$request)
    {
        if ($request->getMethod() !== HttpRequestMethod::GET) {
            return;
        }

        $params = $request->getParams();

        if (empty($params) | is_null($params)) {
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
    public function prepareHeaders(HttpRequest &$request)
    {
        if (empty($request->getParams())) {
            return;
        }

        $params = $request->getParams();

        if (is_array($params)) {
            $request->addHeaders(["Content-Length" => strlen(implode($params))]);
        } else if (is_object($params)) {
            $request->addHeaders(["Content-Length" => strlen(serialize($params))]);
        } else {
            $request->addHeaders(["Content-Length" => strlen($params)]);
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
     * @inheritDoc
     */
    public function prepareParams(HttpRequest &$request)
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

        if (empty($params) | is_null($params)) {
            throw new HttpExecutorException("Failed to parse request parameters");
        }

        curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $params);
    }

    /**
     * @inheritDoc
     */
    public function execute(HttpRequest $request)
    {
        /**
         * Response headers
         *
         * @var array
         */
        $responseHeaders = [];

        /**
         * Response body
         *
         * @var string|bool
         */
        $responseBody = false;

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

        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->_ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($this->_ch, CURLOPT_URL, $request->getUrl());
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $request->getHeaders());
        curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, $request->getMethod());

        curl_setopt(
            $this->_ch,
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

        $responseBody = curl_exec($this->_ch);

        if (curl_errno($this->_ch)) {
            $responseError = curl_error($this->_ch);
        }

        $responseInfo = curl_getinfo($this->_ch);
        $responseStatusCode = $responseInfo['http_code'];

        $response = new HttpResponse($responseHeaders, $responseStatusCode);
        $response->setBody($responseBody)
            ->setTransactionTime($responseInfo['total_time'])
            ->setDownloadSpeed($responseInfo['speed_download'])
            ->setUploadSpeed($responseInfo['speed_upload'])
            ->setHeadersSize($responseInfo['header_size'])
            ->setError($responseError);

        return new HttpResult($request, $response);
    }
}
