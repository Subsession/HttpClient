<?php

/**
 * PHP Version 7
 *
 * LICENSE:
 * See the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Subsession
 *
 * @author Cristian Moraru <cristian.moraru@live.com>
 */

namespace Subsession\Http\Middlewares;

use Subsession\Exceptions\ArgumentNullException;

use Subsession\Http\{
    Abstraction\MiddlewareInterface,
    Abstraction\RequestInterface,
    Abstraction\ResponseInterface,
};

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian.moraru@live.com>
 */
class ValidatorMiddleware implements MiddlewareInterface
{
    /**
     * @inheritDoc
     *
     * @param RequestInterface $request
     *
     * @throws ArgumentNullException If the Request URL is null
     * @throws ArgumentNullException If the Request method is null
     * @access public
     * @return void
     */
    public function onRequest(RequestInterface &$request)
    {
        if (null === $request->getUrl()) {
            throw new ArgumentNullException("Request URL cannot be null");
        }

        if (null === $request->getMethod()) {
            throw new ArgumentNullException("Request method cannot be null");
        }
    }

    /**
     * @inheritDoc
     *
     * @param ResponseInterface $request
     *
     * @throws InvalidOperationException
     * @access public
     * @return void
     */
    public function onResponse(ResponseInterface &$response)
    {
        // Not used
    }
}
