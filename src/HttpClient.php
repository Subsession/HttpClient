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

use Comertis\Http\Adapters\HttpAdapterBuilder;
use Comertis\Http\Adapters\HttpAdapterInterface;
use Comertis\Http\Exceptions\HttpClientException;
use Comertis\Http\HttpRequest;
use Comertis\Http\HttpRequestMethod;
use Comertis\Http\HttpRequestType;
use Comertis\Http\HttpResponse;
use Comertis\Http\Internal\HttpRequestInterface;
use Comertis\Http\Internal\HttpResponseInterface;

/**
 * Undocumented class
 *
 * @uses Comertis\Http\Exceptions\HttpClientException
 * @uses Comertis\Http\HttpRequest
 * @uses Comertis\Http\HttpRequestMethod
 * @uses Comertis\Http\HttpRequestType
 * @uses Comertis\Http\HttpResponse
 * @uses Comertis\Http\Internal\Executors\HttpHandler
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
class HttpClient
{
    /**
     * Holds the request information
     *
     * @access private
     * @see    HttpRequest
     * @var    HttpRequestInterface
     */
    private $request;

    /**
     * Holds the response information once a request has been executed
     *
     * @access private
     * @see    HttpResponse
     * @var    HttpResponseInterface
     */
    private $response;

    /**
     * Responsible for executing a HttpRequest
     *
     * @access private
     * @see    HttpAdapterInterface
     * @var    HttpAdapterInterface
     */
    private $adapter;

    /**
     * Base URL for all requests
     *
     * @access private
     * @var    string|null
     */
    private $baseUrl;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->request = new HttpRequest();
        $this->response = new HttpResponse();
        $this->adapter = HttpAdapterBuilder::build();
        $this->baseUrl = null;
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
     * Get the HttpRequestInterface instance
     *
     * @access public
     * @return HttpRequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set the HttpRequestInterface instance
     *
     * @param HttpRequestInterface $request HttpRequestInterface instance
     *
     * @access public
     * @return self
     */
    public function setRequest(HttpRequestInterface $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get the HttpResponse instance after executing
     * a HttpRequestInterface
     *
     * This returns null if called before executing
     * the HttpRequestInterface.
     *
     * @access public
     * @return HttpResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set the HttpResponseInterface instance
     *
     * This should never be used explicitly in
     * normal use-cases, this method exists for
     * consistency reasons.
     *
     * @param HttpResponseInterface $response HttpResponseInterface instance
     *
     * @access public
     * @return self
     */
    public function setResponse(HttpResponseInterface $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get the explicitly specified HttpAdapterInterface implementation
     * used for requests
     *
     * @access public
     * @return HttpAdapterInterface|null
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Specify an explicit HttpAdapterInterface implementation to use
     * for requests, either just one, or a array with the preferred
     * order of the available implementations.
     *
     * @param string|HttpAdapterInterface $adapter
     *
     * @access public
     * @see    HttpAdapterInterface
     * @return self
     */
    public function setAdapter($adapter)
    {
        if ($adapter instanceof HttpAdapterInterface) {
            $this->adapter = $adapter;
        } else {
            $this->adapter = HttpAdapterBuilder::build($adapter);
        }

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

        $this->response = $this->adapter->handle($this->request);

        return $this->getResponse();
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

        $this->response = $this->adapter->handle($this->request);

        return $this->getResponse();
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

        $this->response = $this->adapter->handle($this->request);

        return $this->getResponse();
    }

    /**
     * Execute a POST request with JSON formatted parameters
     *
     * @param array|mixed|object $params Parameters to include in the request
     *
     * @access public
     * @throws HttpClientException
     * @return HttpResponseInterface
     */
    public function postJson($params = [])
    {
        $this->request
            ->setMethod(HttpRequestMethod::POST)
            ->setBodyType(HttpRequestType::JSON)
            ->setParams($params);

        $this->response = $this->adapter->handle($this->request);

        return $this->getResponse();
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

        $this->response = $this->adapter->handle($this->request);

        return $this->getResponse();
    }

    /**
     * Execute a PUT request with JSON formatted parameters
     *
     * @param array|mixed|object $params Parameters to be json encoded
     *
     * @access public
     * @return HttpResponseInterface
     */
    public function putJson($params = [])
    {
        $this->request
            ->setMethod(HttpRequestMethod::PUT)
            ->setBodyType(HttpRequestType::JSON)
            ->setParams($params);

        $this->response = $this->adapter->handle($this->request);

        return $this->getResponse();
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

        $this->response = $this->adapter->handle($this->request);

        return $this->getResponse();
    }

    /**
     * Execute a DELETE request with JSON encoded parameters
     *
     * @param array $params Parameters to be json encoded
     *
     * @access public
     * @throws HttpClientException
     * @return HttpResponseInterface
     */
    public function deleteJson($params = [])
    {
        $this->request
            ->setMethod(HttpRequestMethod::DELETE)
            ->setBodyType(HttpRequestType::JSON)
            ->setParams($params);

        $this->response = $this->adapter->handle($this->request);

        return $this->getResponse();
    }
}
