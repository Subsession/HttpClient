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
     * @see    Interceptor
     * @var    Interceptor
     */
    private $interceptor = null;

    /**
     * Get the Interceptor instance
     *
     * @access private
     * @return Interceptor
     */
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
        $this->getInterceptor()
            ->getRequest()
            ->setCallback($callable);

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
        $this->getInterceptor()
            ->getResponse()
            ->setCallback($callable);

        return $this;
    }
}
