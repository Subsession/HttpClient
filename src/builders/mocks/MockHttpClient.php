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

namespace Subsession\Http\Builders\Mocks;

use Subsession\Http\Abstraction\AdapterInterface;
use Subsession\Http\Abstraction\RequestInterface;
use Subsession\Http\Abstraction\ResponseInterface;
use Subsession\Http\Abstraction\MiddlewareInterface;

/**
 * IMPORTANT: Do not use
 *
 * This class is intended for internal use only
 *
 * @category Http
 * @package  Subsession\Http
 * @author   Cristian Moraru <cristian.moraru@live.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Subsession/HttpClient
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
