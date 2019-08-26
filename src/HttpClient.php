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

use Comertis\Exceptions\InvalidOperationException;
use Comertis\Http\Abstraction\HttpClientInterface;
use Comertis\Http\Abstraction\MiddlewareInterface;
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
class HttpClient implements HttpClientInterface
{
    use \Comertis\Http\Extensions\Client\RequestExtensions;
    use \Comertis\Http\Extensions\Client\ResponseExtensions;
    use \Comertis\Http\Extensions\Client\InterceptorExtensions;
    use \Comertis\Http\Extensions\Client\AdapterExtensions;
    use \Comertis\Http\Extensions\Client\MiddlewareExtensions;

    /**
     * Handle the RequestInterface
     *
     * This handles the Interceptor calls and the
     * AdapterInterface::handle() call.
     *
     * @param RequestInterface $request
     *
     * @throws InvalidOperationException if one of the middlewares throws
     * @access public
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        /**
         * @var int                 $key
         * @var MiddlewareInterface $middleware
         */
        foreach ($this->getMiddlewares() as $key => $middleware) {
            $middleware->handle($request);
        }

        // Handle RequestInterceptor call
        $this->getInterceptor()
            ->getRequest()
            ->intercept($request);

        // Get ResponseInterface from the AdapterInterface
        $response = $this->getAdapter()->handle($request);
        $this->setResponse($response);

        // Handle ResponseInterceptor call
        $this->getInterceptor()
            ->getResponse()
            ->intercept($response);

        // Return ResponseInterface
        return $response;
    }
}
