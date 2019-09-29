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

namespace Subsession\Http\Middlewares;

use Subsession\Exceptions\ArgumentException;
use Subsession\Exceptions\ArgumentNullException;
use Subsession\Http\Abstraction\MiddlewareInterface;
use Subsession\Http\Abstraction\RequestInterface;
use Subsession\Http\Abstraction\ResponseInterface;
use Subsession\Http\HttpRequestMethod;
use Subsession\Http\HttpRequestType;

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
class ValidatorMiddleware implements MiddlewareInterface
{
    /**
     * @inheritDoc
     *
     * @param RequestInterface $request
     *
     * @access public
     * @throws ArgumentNullException If the Request URL is null
     * @throws ArgumentNullException If the Request method is null
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
