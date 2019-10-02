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

namespace Subsession\Http;

use JsonSerializable;

use Subsession\Http\{
    Abstraction\HttpClientInterface,
    Abstraction\RequestInterface,
    Abstraction\ResponseInterface,
    Extensions as Extensions
};

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian.moraru@live.com>
 */
class HttpClient implements HttpClientInterface, JsonSerializable
{
    use Extensions\Client\RequestExtensions;
    use Extensions\Client\ResponseExtensions;
    use Extensions\Client\AdapterExtensions;
    use Extensions\Client\MiddlewareExtensions;
    use Extensions\JsonSerializable;

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
