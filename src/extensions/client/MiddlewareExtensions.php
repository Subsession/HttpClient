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

namespace Comertis\Http\Extensions\Client;

use Comertis\Http\Abstraction\MiddlewareInterface;
use Comertis\Http\Abstraction\RequestInterface;
use Comertis\Http\Abstraction\ResponseInterface;
use Comertis\Http\Middlewares\BodyFormatterMiddleware;
use Comertis\Http\Middlewares\HeadersFormatterMiddleware;
use Comertis\Http\Middlewares\UrlFormatterMiddleware;

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
        $this->middlewares = $middlewares;

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
    private function onRequest(RequestInterface &$request)
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
    private function onResponse(ResponseInterface &$response)
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
