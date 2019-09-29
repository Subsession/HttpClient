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

namespace Subsession\Http\Extensions\Client;

use Subsession\Http\Abstraction\MiddlewareInterface;
use Subsession\Http\Abstraction\RequestInterface;
use Subsession\Http\Abstraction\ResponseInterface;
use Subsession\Http\Middlewares\BodyFormatterMiddleware;
use Subsession\Http\Middlewares\HeadersFormatterMiddleware;
use Subsession\Http\Middlewares\UrlFormatterMiddleware;
use Subsession\Http\Middlewares\ValidatorMiddleware;

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
trait MiddlewareExtensions
{
    /**
     * Default middlewares
     *
     * @static
     * @access private
     * @var    array
     */
    private static $defaultMiddlewares = [
        UrlFormatterMiddleware::class,
        HeadersFormatterMiddleware::class,
        BodyFormatterMiddleware::class,
        ValidatorMiddleware::class
    ];

    /**
     * Collection of middlewares
     *
     * @access private
     * @var    MiddlewareInterface[]
     */
    private $middlewares = [];

    /**
     * Get the middleware collection
     *
     * @access public
     * @return MiddlewareInterface[]
     */
    public function getMiddlewares()
    {
        if (empty($this->middlewares)) {
            $this->addMiddlewares(static::$defaultMiddlewares);
        }

        return $this->middlewares;
    }

    /**
     * Set the middleware collection
     *
     * @param MiddlewareInterface[] $middlewares
     *
     * @access public
     * @return static
     */
    public function setMiddlewares(array $middlewares)
    {
        $instances = [];

        foreach ($middlewares as $key => $middleware) {
            if ($middleware instanceof MiddlewareInterface) {
                $instances[] = $middleware;
            } elseif (is_string($middleware)) {
                $instances[] = new $middleware();
            }
        }

        $this->middlewares = $instances;

        return $this;
    }

    /**
     * Add a middleware to the collection
     *
     * ```php
     * // MiddlewareInterface
     * $client->addMiddleware(new InterceptorMiddleware());
     * // Or string
     * $client->addMiddleware(InterceptorMiddleware::class);
     * ```
     *
     * @param MiddlewareInterface|string $middleware
     *
     * @access public
     * @return static
     */
    public function addMiddleware($middleware)
    {
        if ($middleware instanceof MiddlewareInterface) {
            $this->middlewares[] = $middleware;
        } else {
            $this->middlewares[] = new $middleware();
        }

        return $this;
    }

    /**
     * Add multiple middlewares to the collection
     *
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
        /**
         * @var int                 $key
         * @var MiddlewareInterface $middleware
         */
        foreach ($this->getMiddlewares() as $key => $middleware) {
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
        /**
         * @var int                 $key
         * @var MiddlewareInterface $middleware
         */
        foreach ($this->getMiddlewares() as $key => $middleware) {
            $middleware->onResponse($response);
        }
    }
}
