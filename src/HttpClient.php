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

use Comertis\Http\Abstraction\HttpRequestInterface;
use Comertis\Http\Abstraction\HttpResponseInterface;
use Comertis\Http\Adapters\HttpAdapterInterface;
use Comertis\Http\Builders\HttpAdapterBuilder;
use Comertis\Http\Builders\HttpRequestBuilder;
use Comertis\Http\Builders\HttpResponseBuilder;

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
class HttpClient
{
    use \Comertis\Http\Extensions\HttpClientRequestExtensions;
    use \Comertis\Http\Extensions\HttpClientInterceptorExtension;

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
     * Constructor
     */
    public function __construct()
    {
        $this->request = HttpRequestBuilder::build();
        $this->response = HttpResponseBuilder::build();
        $this->adapter = HttpAdapterBuilder::build();
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
     * Handle the HttpRequestInterface
     *
     * This handles the HttpInterceptor calls and the
     * HttpAdapterInterface::handle() call.
     *
     * @param HttpRequestInterface $request
     *
     * @access private
     * @return HttpResponseInterface
     */
    private function handle(HttpRequestInterface $request)
    {
        $response = $this->adapter->handle($request);
        $this->setResponse($response);

        return $response;
    }
}
