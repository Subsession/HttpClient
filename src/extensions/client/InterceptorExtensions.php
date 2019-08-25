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

namespace Comertis\Http\Extensions\Client;

use Comertis\Http\Abstraction\RequestInterface;
use Comertis\Http\Interceptors\Interceptor;

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
trait InterceptorExtensions
{
    /**
     * Request & Response interceptor
     *
     * @access private
     * @see Interceptor
     * @var Interceptor
     */
    private $interceptor = null;

    private function getInterceptor()
    {
        if (null === $this->interceptor) {
            $this->interceptor = new Interceptor();
        }

        return $this->interceptor;
    }

    /**
     * Intercept all RequestInterface before they are processed
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
     * Intercept all ResponseInterface before they are returned
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
     * Handle the RequestInterface
     *
     * This handles the Interceptor calls and the
     * AdapterInterface::handle() call.
     *
     * @param RequestInterface $request
     *
     * @access private
     * @return ResponseInterface
     */
    private function handle(RequestInterface $request)
    {
        // Handle RequestInterceptor call
        $this->getInterceptor()
            ->getRequest()
            ->handle($request);

        // Get ResponseInterface from the AdapterInterface
        $response = $this->getAdapter()->handle($request);
        $this->setResponse($response);

        // Handle ResponseInterceptor call
        $this->getInterceptor()
            ->getResponse()
            ->handle($response);

        // Return ResponseInterface
        return $response;
    }
}
