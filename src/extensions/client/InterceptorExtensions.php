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
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  GIT: &Id&
 * @link     https://github.com/Comertis/HttpClient
 */

namespace Comertis\Http\Extensions\Client;

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
trait InterceptorExtensions
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
