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
 * @link     https://github.com/Comertis/Cache
 */

namespace Comertis\Http;

use Comertis\Http\Exceptions\HttpClientException;
use Comertis\Http\HttpRequest;
use Comertis\Http\HttpRequestMethod;
use Comertis\Http\HttpRequestType;
use Comertis\Http\HttpResponse;
use Comertis\Http\Internal\Executors\HttpExecutor;

/**
 * Undocumented class
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/Cache
 */
class HttpClient
{
    /**
     * Holds the request information
     *
     * @access private
     * @see    HttpRequest
     * @var    HttpRequest
     */
    private $_request;

    /**
     * Holds the response information once a request has been executed
     *
     * @access private
     * @see    HttpResponse
     * @var    HttpResponse
     */
    private $_response;

    /**
     * Responsible for executing a HttpRequest
     *
     * @access private
     * @see    HttpExecutor
     * @var    HttpExecutor
     */
    private $_executor;

    /**
     * Constructor
     *
     * @param string|null $url Base url
     */
    public function __construct($url = null)
    {
        $this->_request = new HttpRequest();

        if (!is_null($url)) {
            $this->_request->setUrl($url);
        }

        $this->_response = new HttpResponse();
        $this->_executor = new HttpExecutor();
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
     * Get the request URL
     *
     * @see HttpRequest::getUrl()
     *
     * @access public
     * @return string
     */
    public function getUrl()
    {
        return $this->_request->getUrl();
    }

    /**
     * Set the request URL
     *
     * @param string $url Request URL
     *
     * @access public
     * @see    HttpRequest::setUrl()
     * @return HttpClient
     */
    public function setUrl($url)
    {
        $this->_request->setUrl($url);

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
        return $this->_request->getHeaders();
    }

    /**
     * Set the request headers
     *
     * @param array $headers Key => Value pair array of headers
     *
     * @access public
     * @see    HttpRequest::setHeaders()
     * @return HttpClient
     */
    public function setHeaders(array $headers)
    {
        $this->_request->setHeaders($headers);

        return $this;
    }

    /**
     * Add headers to the request
     *
     * @param array $headers Key => Value pair array of headers
     *
     * @access public
     * @see    HttpRequest::addHeaders()
     * @return HttpClient
     */
    public function addHeaders(array $headers)
    {
        $this->_request->addHeaders($headers);

        return $this;
    }

    /**
     * Clear all headers from the request
     *
     * @access public
     * @see    HttpRequest::setHeaders()
     * @return HttpClient
     */
    public function clearHeaders()
    {
        $this->_request->setHeaders([]);

        return $this;
    }

    /**
     * Get the HttpClient request
     *
     * @access public
     * @see    HttpClient
     * @return HttpRequest
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * Set the HttpClient request
     *
     * @param HttpRequest $request HttpRequest instance
     *
     * @access public
     * @return HttpClient
     */
    public function setRequest(HttpRequest $request)
    {
        $this->_request = $request;

        return $this;
    }

    /**
     * Get the configured retry count for requests
     *
     * @access public
     * @see    HttpExecutor::getRetryCount()
     * @return integer
     */
    public function getRetryCount()
    {
        return $this->_executor->getRetryCount();
    }

    /**
     * Set the retry count for requests
     *
     * @param integer $retryCount Number of retries on a connection before giving up
     *
     * @access public
     * @see    HttpExecutor::setRetryCount()
     * @return HttpClient
     */
    public function setRetryCount($retryCount)
    {
        $this->_executor->setRetryCount($retryCount);

        return $this;
    }

    /**
     * Get the explicitly specified IHttpExecutor implementation
     * used for requests
     *
     * @access public
     * @return string|null
     */
    public function getExplicitExecutor()
    {
        return $this->_executor->getExplicitExecutor();
    }

    /**
     * Specify an explicit IHttpExecutor implementation to use
     * for requests, either just one, or a array with the preferred
     * order of the available implementations.
     *
     * @param string|array $executorImplementation HttpExecutorImplementation
     *                                             implementation
     *
     * @access public
     * @see    HttpExecutorImplementation
     * @return HttpClient
     */
    public function setExplicitExecutor($executorImplementation)
    {
        $this->_executor->setExplicitExecutor($executorImplementation);

        return $this;
    }

    /**
     * Execute a GET request
     *
     * @param array $params Parameters to include in the request
     *
     * @access public
     * @return HttpResponse
     */
    public function get($params = [])
    {
        $this->_request
            ->setMethod(HttpRequestMethod::GET)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a POST request
     *
     * @param array $params Parameters to include in the request
     *
     * @access public
     * @return HttpResponse
     */
    public function post($params = [])
    {
        $this->_request
            ->setMethod(HttpRequestMethod::POST)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a POST request with JSON formatted parameters
     *
     * @param array|mixed|object $params Parameters to include in the request
     *
     * @access public
     * @throws HttpClientException
     * @return HttpResponse
     */
    public function postJson($params = [])
    {
        $this->_request
            ->setMethod(HttpRequestMethod::POST)
            ->setBodyType(HttpRequestType::JSON)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a PUT request
     *
     * @param array|mixed|object $params Parameters to include in the request
     *
     * @access public
     * @return HttpResponse
     */
    public function put($params = [])
    {
        $this->_request
            ->setMethod(HttpRequestMethod::PUT)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a PUT request with JSON formatted parameters
     *
     * @param array|mixed|object $params Parameters to be json encoded
     *
     * @access public
     * @return HttpResponse
     */
    public function putJson($params = [])
    {
        $this->_request
            ->setMethod(HttpRequestMethod::PUT)
            ->setBodyType(HttpRequestType::JSON)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a DELETE request
     *
     * @param array $params Parameters to include in the request
     *
     * @access public
     * @return HttpResponse
     */
    public function delete($params = [])
    {
        $this->_request
            ->setMethod(HttpRequestMethod::DELETE)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }

    /**
     * Execute a DELETE request with JSON encoded parameters
     *
     * @param array $params Parameters to be json encoded
     *
     * @access public
     * @throws HttpClientException
     * @return HttpResponse
     */
    public function deleteJson($params = [])
    {
        $this->_request
            ->setMethod(HttpRequestMethod::DELETE)
            ->setBodyType(HttpRequestType::JSON)
            ->setParams($params);

        $result = $this->_executor->execute($this->_request);

        return $result->getResponse();
    }
}
