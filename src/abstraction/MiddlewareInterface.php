<?php

/**
 * PHP Version 7
 *
 * LICENSE:
 * See the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Subsession
 *
 * @author Cristian Moraru <cristian@subsession.org>
 */

namespace Subsession\Http\Abstraction;

use Subsession\Exceptions\InvalidOperationException;

use Subsession\Http\Abstraction\{
    RequestInterface,
    ResponseInterface
};

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian@subsession.org>
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
