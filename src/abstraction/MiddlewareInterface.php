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

namespace Comertis\Http\Abstraction;

use Comertis\Exceptions\InvalidOperationException;
use Comertis\Http\Abstraction\RequestInterface;
use Comertis\Http\Abstraction\ResponseInterface;

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