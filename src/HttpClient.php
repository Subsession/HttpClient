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

namespace Subsession\Http;

use Subsession\Http\Abstraction\HttpClientInterface;
use Subsession\Http\Abstraction\RequestInterface;
use Subsession\Http\Abstraction\ResponseInterface;
use Subsession\Http\Builders\AdapterBuilder;
use Subsession\Http\Builders\RequestBuilder;
use Subsession\Http\Builders\ResponseBuilder;
use Subsession\Http\Extensions\Client as Extensions;

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
class HttpClient implements HttpClientInterface
{
    use Extensions\RequestExtensions;
    use Extensions\ResponseExtensions;
    use Extensions\InterceptorExtensions;
    use Extensions\AdapterExtensions;
    use Extensions\MiddlewareExtensions;

    public function __construct()
    {
        $this->setAdapter(AdapterBuilder::getInstance()->build());
        $this->setRequest(RequestBuilder::getInstance()->build());
        $this->setResponse(ResponseBuilder::getInstance()->build());
        $this->setMiddlewares(static::$defaultMiddlewares);
    }

    /**
     * Handle the RequestInterface
     *
     * @param RequestInterface $request
     *
     * @throws InvalidOperationException if one of the middlewares throws
     * @access public
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        // Invoke onRequest() function on all registered MiddlewareInterface implementations
        $this->invokeOnRequest($request);

        // Get ResponseInterface from the AdapterInterface
        /** @var ResponseInterface $response */
        $response = $this->getAdapter()->handle($request);
        $this->setResponse($response);

        // Invoke onResponse() function on all registered MiddlewareInterface implementations
        $this->invokeOnResponse($response);

        // Return ResponseInterface
        return $response;
    }
}
