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

namespace Comertis\Http\Extensions;

use Comertis\Http\Abstraction\HttpResponseInterface;
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
trait HttpClientRequestExtensions
{
    use \Comertis\Http\Extensions\HttpClientRequestJsonExtensions;

    /**
     * Base URL for all requests
     *
     * @access private
     * @var    string|null
     */
    private $baseUrl = null;

    /**
     * Get the request URL
     *
     * @access public
     * @see    HttpRequest::getUrl()
     * @return string
     */
    public function getUrl()
    {
        return $this->request->getUrl();
    }

    /**
     * Set the request URL.
     *
     * Absolute URL if base url is null,
     * Relative URL if base url is set
     *
     * @param string $url Request URL
     *
     * @access public
     * @see    HttpClient::setBaseUrl()
     * @see    HttpRequest::setUrl()
     * @return self
     */
    public function setUrl($url)
    {
        if (null !== $this->getBaseUrl()) {
            $url = $this->getBaseUrl() . $url;
        }

        $this->request->setUrl($url);

        return $this;
    }

    /**
     * Get the request headers
     *
     * @access public
     * @see    HttpRequest::getHeaders()
     * @return array
     */
    public function getHeaders()
    {
        return $this->request->getHeaders();
    }

    /**
     * Set the request headers
     *
     * @param array $headers Array of (Key => Value) pairs
     *
     * @access public
     * @see    HttpRequest::setHeaders()
     * @return self
     */
    public function setHeaders(array $headers)
    {
        $this->request->setHeaders($headers);

        return $this;
    }

    /**
     * Add headers to the request
     *
     * @param array $headers Array of (Key => Value) pairs
     *
     * @access public
     * @see    HttpRequest::addHeaders()
     * @return self
     */
    public function addHeaders(array $headers)
    {
        $this->request->addHeaders($headers);

        return $this;
    }

    /**
     * Clear all headers from the request
     *
     * @access public
     * @see    HttpRequest::setHeaders()
     * @return self
     */
    public function clearHeaders()
    {
        $this->request->setHeaders([]);

        return $this;
    }

    /**
     * Get the configured base URL for all requests
     *
     * @access public
     * @return string|null
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Set the base URL for all requests
     *
     * @param string|null $url Base URL | Null to remove
     *
     * @access public
     * @return self
     */
    public function setBaseUrl($url)
    {
        $this->baseUrl = $url;
        $this->request->setUrl($this->getBaseUrl());

        return $this;
    }

    /**
     * Execute a HEAD request
     *
     * @param array $params Parameters to include in the request.
     *                      These parameters will be added to the URL
     *
     * @access public
     * @return HttpResponseInterface
     */
    public function head($params = [])
    {
        $this->request
            ->setMethod(HttpRequestMethod::HEAD)
            ->setParams($params);

        return $this->handle($this->request);
    }

    /**
     * Execute a GET request
     *
     * @param array $params Parameters to include in the request
     *
     * @access public
     * @return HttpResponseInterface
     */
    public function get($params = [])
    {
        $this->request
            ->setMethod(HttpRequestMethod::GET)
            ->setParams($params);

        return $this->handle($this->request);
    }

    /**
     * Execute a POST request
     *
     * @param array $params Parameters to include in the request
     *
     * @access public
     * @return HttpResponseInterface
     */
    public function post($params = [])
    {
        $this->request
            ->setMethod(HttpRequestMethod::POST)
            ->setParams($params);

        return $this->handle($this->request);
    }

    /**
     * Execute a PUT request
     *
     * @param array|mixed|object $params Parameters to include in the request
     *
     * @access public
     * @return HttpResponseInterface
     */
    public function put($params = [])
    {
        $this->request
            ->setMethod(HttpRequestMethod::PUT)
            ->setParams($params);

        return $this->handle($this->request);
    }

    /**
     * Execute a DELETE request
     *
     * @param array $params Parameters to include in the request
     *
     * @access public
     * @return HttpResponseInterface
     */
    public function delete($params = [])
    {
        $this->request
            ->setMethod(HttpRequestMethod::DELETE)
            ->setParams($params);

        return $this->handle($this->request);
    }
}
