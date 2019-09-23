<?php

/**
 * PHP Version 7
 *
 * LICENSE:
 * See the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Subsession
 *
 * @category Http
 * @package  Subsession\Http
 * @author   Cristian Moraru <cristian.moraru@live.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  GIT: &Id&
 * @link     https://github.com/Subsession/HttpClient
 */

namespace Subsession\Http\Extensions\Client;

use Subsession\Http\Abstraction\RequestInterface;
use Subsession\Http\Interceptors\Interceptor;

/**
 * Undocumented class
 *
 * @category Http
 * @package  Subsession\Http
 * @author   Cristian Moraru <cristian.moraru@live.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Subsession/HttpClient
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
     * @return static
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
     * @return static
     */
    public function beforeResponse(callable $callable)
    {
        $this->getInterceptor()
            ->getResponse()
            ->setCallback($callable);

        return $this;
    }
}
