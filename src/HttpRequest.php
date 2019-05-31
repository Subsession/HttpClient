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

namespace Comertis\Http;

use Comertis\Http\Exceptions\HttpClientException;
use Comertis\Http\HttpRequestMethod;

/**
 * Undocumented class
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
class HttpRequest
{
    /**
     * Base url
     *
     * @access private
     * @var    string
     */
    private $_url;

    /**
     * HTTP headers
     *
     * @access private
     * @var    array
     */
    private $_headers;

    /**
     * HTTP request method
     *
     * @access private
     * @var    string
     */
    private $_method;

    /**
     * Http request type
     *
     * @access private
     * @var    string
     */
    private $_bodyType;

    /**
     * Request parameters
     *
     * @access private
     * @var    array
     */
    private $_params;

    /**
     * Constructor
     *
     * @param string $url     Request URL
     * @param array  $headers Request headers
     * @param string $method  Request method
     * @param array  $params  Request parameters
     */
    public function __construct($url = null, $headers = [], $method = null, $params = [])
    {
        if (is_null($method)) {
            $method = HttpRequestMethod::GET;
        }

        $this->_url = $url;
        $this->_headers = $headers;
        $this->_method = $method;
        $this->_params = $params;

        $this->addHeaders(
            [
                "Cache-Control" => "max-age=0",
                "Connection" => "keep-alive",
                "Keep-Alive" => "300",
                "Accept" => "application/json,text/xml,application/xml,application/xhtml+xml,text/html,text/plain,image/png,*/*",
                "Accept-Charset" => "utf-8,ISO-8859-1",
            ]
        );
    }

    /**
     * Destructor
     */
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
     * @param array $headers Request headers
     *
     * @access public
     * @return HttpRequest
     */
    public function setHeaders($headers)
    {
        $this->_headers = $headers;

        return $this;
    }

    /**
     * Add headers to the request.
     * IMPORTANT: Overrides existing headers if
     * duplicate found
     *
     * @param array $headers Request headers
     *
     * @access public
     * @throws HttpClientException
     * @return void
     */
    public function addHeaders($headers)
    {
        if (empty($headers)) {
            throw new HttpClientException("Headers cannot be empty");
        }

        foreach ($headers as $key => $value) {
            $this->_headers[$key] = $value;
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
     * Set the request method
     *
     * @param string $requestMethod Request method: GET|POST|PUT|DELETE
     *
     * @access public
     * @see    HttpRequestMethod
     * @return HttpRequest
     */
    public function setMethod($requestMethod)
    {
        $this->_method = $requestMethod;

        return $this;
    }

    /**
     * Get the request URL
     *
     * @access public
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * Set the request URL
     *
     * @param string $url URL
     *
     * @access public
     * @throws HttpClientException If the URL is null or empty
     * @return HttpRequest
     */
    public function setUrl($url)
    {
        if (is_null($url)) {
            throw new HttpClientException("URL cannot be null");
        }

        if (empty($url)) {
            throw new HttpClientException("URL cannot be empty");
        }

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
     * @param array $params Request parameters
     *
     * @access public
     * @return HttpRequest
     */
    public function setParams($params)
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
     * @param string $bodyType Request body type
     *
     * @access public
     * @see    HttpRequestType
     * @return HttpRequest
     */
    public function setBodyType($bodyType)
    {
        $this->_bodyType = $bodyType;

        return $this;
    }
}
