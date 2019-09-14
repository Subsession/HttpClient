<?php
/**
 * PHP Version 7
 *
 * LICENSE:
 * Proprietary, see the LICENSE file that was provided with the software.
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

namespace Subsession\Http\Abstraction;

use Subsession\Exceptions\InvalidOperationException;
use Subsession\Http\Abstraction\RequestInterface;
use Subsession\Http\Abstraction\ResponseInterface;

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
interface MiddlewareInterface
{
    /**
     * Handle the RequestInterface before it is processed
     *
     * @param RequestInterface $request
     *
     * @throws InvalidOperationException if the middleware fails to process the RequestInterface
     * @access public
     * @return void
     */
    public function onRequest(RequestInterface &$request);

    /**
     * Handle the ResponseInterface before it is returned
     *
     * @param ResponseInterface $response
     *
     * @throws InvalidOperationException if the middleware fails to process the ResponseInterface
     * @access public
     * @return void
     */
    public function onResponse(ResponseInterface &$response);
}
