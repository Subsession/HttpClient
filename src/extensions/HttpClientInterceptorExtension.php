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

use Comertis\Http\Abstraction\HttpRequestInterface;
use Comertis\Http\Interceptors\HttpInterceptor;

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
trait HttpClientInterceptorExtension
{
    /**
     * HttpRequest & HttpResponse interceptor
     *
     * @access private
     * @see HttpInterceptor
     * @var HttpInterceptor
     */
    private $interceptor = null;

    private function getInterceptor()
    {
        if (null === $this->interceptor) {
            $this->interceptor = new HttpInterceptor();
        }

        return $this->interceptor;
    }

    /**
     * Intercept all HttpRequestInterface before they are processed
     *
     * @param callable $callable
     *
     * @access public
     * @return self
     */
    public function beforeRequest(callable $callable)
    {
        $this->getInterceptor()->getRequest()->intercept($callable);

        return $this;
    }

    /**
     * Intercept all HttpResponseInterface before they are returned
     *
     * @param callable $callable
     *
     * @access public
     * @return self
     */
    public function beforeResponse(callable $callable)
    {
        $this->getInterceptor()->getResponse()->intercept($callable);

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
        // Handle HttpRequestInterceptor call
        $this->getInterceptor()
            ->getRequest()
            ->handle($request);

        // Get HttpResponseInterface from the HttpAdapterInterface
        $response = $this->getAdapter()->handle($request);
        $this->setResponse($response);

        // Handle HttpResponseInterceptor call
        $this->getInterceptor()
            ->getResponse()
            ->handle($response);

        // Return HttpResponseInterface
        return $response;
    }
}
