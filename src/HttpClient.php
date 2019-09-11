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

namespace Comertis\Http;

use Comertis\Http\Abstraction\HttpClientInterface;
use Comertis\Http\Abstraction\RequestInterface;
use Comertis\Http\Abstraction\ResponseInterface;
use Comertis\Http\Builders\AdapterBuilder;
use Comertis\Http\Builders\RequestBuilder;
use Comertis\Http\Builders\ResponseBuilder;
use Comertis\Http\Extensions\Client as Extensions;

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
