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

namespace Subsession\Http\Extensions\Client;

use Subsession\Http\Abstraction\{
    MiddlewareInterface,
    RequestInterface,
    ResponseInterface
};

use Subsession\Http\Middlewares\{
    BodyFormatterMiddleware,
    HeadersFormatterMiddleware,
    UrlFormatterMiddleware,
    ValidatorMiddleware
};

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian@subsession.org>
 */
trait MiddlewareExtensions
{
    /**
     * Collection of middlewares
     *
     * @access private
     * @var    MiddlewareInterface[]|string[]
     */
    private $middlewares = [
        UrlFormatterMiddleware::class => UrlFormatterMiddleware::class,
        HeadersFormatterMiddleware::class => HeadersFormatterMiddleware::class,
        BodyFormatterMiddleware::class => BodyFormatterMiddleware::class,
        ValidatorMiddleware::class => ValidatorMiddleware::class
    ];

    /**
     * Get the middleware collection
     *
     * @access public
     * @return MiddlewareInterface[]
     */
    public function getMiddlewares()
    {
        $this->addMiddlewares($this->middlewares);

        return $this->middlewares;
    }

    /**
     * Set the middleware collection
     *
     * @param MiddlewareInterface[]|string[] $middlewares
     *
     * @access public
     * @return static
     */
    public function setMiddlewares(array $middlewares)
    {
        $instances = [];

        foreach ($middlewares as $key => $middleware) {
            if ($middleware instanceof MiddlewareInterface) {
                $instances[$key] = $middleware;
            } elseif (is_string($middleware)) {
                $instances[$key] = new $middleware();
            } else {
                throw new InvalidArgumentException();
            }
        }

        $this->middlewares = array_merge($this->middlewares, $instances);

        return $this;
    }

    /**
     * Add a middleware to the collection
     *
     * Code example:
     * ```php
     * // @var HttpClient $client
     * // MiddlewareInterface
     * $client->addMiddleware(new InterceptorMiddleware());
     * // Or string
     * $client->addMiddleware(InterceptorMiddleware::class);
     * ```
     *
     * @param MiddlewareInterface|string $middleware
     *
     * @throws \Subsession\Exceptions\InvalidArgumentException
     * @access public
     * @return static
     */
    public function addMiddleware($middleware)
    {
        if ($middleware instanceof MiddlewareInterface) {
            $this->middlewares[get_class($middleware)] = $middleware;
        } elseif (is_string($middleware)) {
            $this->middlewares[$middleware] = new $middleware();
        } else {
            throw new \Subsession\Exceptions\InvalidArgumentException();
        }

        return $this;
    }

    /**
     * Add multiple middlewares to the collection
     *
     * Code example:
     * ```php
     * // MiddlewareInterface[]
     * $client->addMiddlewares([
     *     new InterceptorMiddleware(),
     *     new FormatterMiddleware(),
     * ]);
     * // Or string[]
     * $client->addMiddlewares([
     *     InterceptorMiddleware::class,
     *     FormatterMiddleware::class
     * ]);
     * ```
     *
     * @param MiddlewareInterface[]|string[] $middlewares
     *
     * @access public
     * @return static
     */
    public function addMiddlewares(array $middlewares)
    {
        foreach ($middlewares as $key => $middleware) {
            $this->addMiddleware($middleware);
        }
    }

    /**
     * Invoke middlewares before sending the request
     *
     * @throws InvalidOperationException if one of the middlewares throws
     * @access private
     * @return void
     */
    private function invokeOnRequest(RequestInterface &$request)
    {
        $middlewares = $this->getMiddlewares();

        /**
         * @var int                 $key
         * @var MiddlewareInterface $middleware
         */
        foreach ($middlewares as $key => $middleware) {
            $middleware->onRequest($request);
        }
    }

    /**
     * Invoke middlewares after receiving a response
     *
     * @throws InvalidOperationException if one of the middlewares throws
     * @access private
     * @return void
     */
    private function invokeOnResponse(ResponseInterface &$response)
    {
        $middlewares = $this->getMiddlewares();

        /**
         * @var int                 $key
         * @var MiddlewareInterface $middleware
         */
        foreach ($middlewares as $key => $middleware) {
            $middleware->onResponse($response);
        }
    }
}
