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

namespace Subsession\Http\Builders\Mocks;

use Subsession\Http\Abstraction\{
    AdapterInterface,
    RequestInterface,
    ResponseInterface,
    MiddlewareInterface
};

/**
 * IMPORTANT: Do not use
 *
 * This class is intended for internal use only
 *
 * @internal
 * @author Cristian Moraru <cristian@subsession.org>
 */
class MockHttpClient
{
    /**
     * AdapterInterface implementation
     *
     * @var AdapterInterface
     */
    public $adapter = null;

    /**
     * RequestInterface instance
     *
     * @var RequestInterface
     */
    public $request = null;

    /**
     * ResponseInterface instance
     *
     * @var ResponseInterface
     */
    public $response = null;

    /**
     * MiddlewareInterface array
     *
     * @var MiddlewareInterface[]|string[]
     */
    public $middlewares = [];
}
