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

namespace Comertis\Http\Middlewares;

use Comertis\Exceptions\InvalidOperationException;
use Comertis\Http\Abstraction\MiddlewareInterface;
use Comertis\Http\Abstraction\RequestInterface;

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
class InterceptorMiddleware implements MiddlewareInterface
{
    /**
     * @inheritDoc
     *
     * @param RequestInterface $request
     *
     * @throws InvalidOperationException
     * @access public
     * @return void
     */
    public function handle(RequestInterface &$request)
    {
        print_r("Interceptor middleware called");
    }
}
