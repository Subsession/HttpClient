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

use Comertis\Http\Exceptions\HttpExecutorException;
use Comertis\Http\HttpRequest;
use Comertis\Http\HttpStatusCode;
use Comertis\Http\Internal\Executors\HttpExecutorFactory;

/**
 * Undocumented class
 *
 * @uses Comertis\Http\Exceptions\HttpExecutorException
 * @uses Comertis\Http\HttpRequest
 * @uses Comertis\Http\HttpStatusCode
 * @uses Comertis\Http\Internal\Executors\HttpExecutorFactory
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
class HttpExecutor
{
    /**
     * Request retry count
     *
     * @access private
     * @var    integer
     */
    private $_retry;

    /**
     * Specific IHttpExecutor implementation to use
     *
     * @access private
     * @var    string
     */
    private $_implementation;

    /**
     * Default number of retries for HttpRequests
     *
     * @access public
     * @var    integer
     */
    const DEFAULT_RETRY_COUNT = 1;

    /**
     * IHttpExecutor implementation instance,
     * used as a cache
     *
     * @access private
     * @var    IHttpExecutor
     */
    private $_executor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_retry = self::DEFAULT_RETRY_COUNT;
        $this->_implementation = null;
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
     * Get the configured retry count for requests
     *
     * @access public
     * @return integer
     */
    public function getRetryCount()
    {
        return $this->_retry;
    }

    /**
     * Set the number of times to retry a request
     * in case of failing to get a response
     *
     * @param integer $retryCount Number of retries
     *
     * @access public
     * @return HttpExecutor
     */
    public function setRetryCount($retryCount)
    {
        $this->_retry = $retryCount;

        return $this;
    }

    /**
     * Get the configured explicit IHttpExecutor implementation
     *
     * @access public
     * @return string|null
     */
    public function getExplicitExecutor()
    {
        return $this->_implementation;
    }

    /**
     * Specify a IHttpExecutor implementation to use
     *
     * It can be in the form of a single class
     *     Example: HttpCurlExecutor::class
     *
     * Or it can be an array of preferred implementations
     *     Example: [HttpCurlExecutor::class, HttpStreamExecutor::class]
     *
     * @param string|array $implementation IHttpExecutor implementation
     *
     * @access public
     * @return HttpExecutor
     */
    public function setImplementation($implementation)
    {
        $this->_implementation = $implementation;

        return $this;
    }

    /**
     * Execute the HttpRequest
     *
     * @param HttpRequest $request HttpRequest instance to execute
     *
     * @access public
     * @return HttpResult
     */
    public function execute(HttpRequest $request)
    {
        if (is_null($this->_executor)) {
            $this->_executor = HttpExecutorFactory::getExecutor($this->_implementation);
        }

        $this->_executor->prepareUrl($request);
        $this->_executor->prepareHeaders($request);
        $this->_executor->prepareParams($request);

        for ($i = 0; $i < $this->getRetryCount(); $i++) {
            $result = $this->_executor->execute($request);

            if ($result->getResponse()->getStatusCode() != HttpStatusCode::INTERNAL_SERVER_ERROR) {
                return $result;
            }
        }

        $message = "Failed to get response after " . $this->getRetryCount() . " tries.";
        throw new HttpExecutorException($message);
    }
}
