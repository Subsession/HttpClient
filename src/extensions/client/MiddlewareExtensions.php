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
     * Collection of middlewares
     *
     * @access private
     * @var    MiddlewareInterface[]
     */
    private $middlewares;

    /**
     * Get the middleware collection
     *
     * @access public
     * @return MiddlewareInterface[]
     */
    public function getMiddlewares()
    {
        if (null !== $this->middlewares) {
            $this->setMiddlewares([]);
        }

        return $this->middlewares;
    }

    /**
     * Set the middleware collection
     *
     * @param MiddlewareInterface[] $middlewares
     *
     * @access public
     * @return self
     */
    public function setMiddlewares(array $middlewares)
    {
        $this->middlewares = $middlewares;

        return $this;
    }

    /**
     * Add a middleware to the collection
     *
     * @param MiddlewareInterface $middleware
     *
     * @access public
     * @return self
     */
    public function addMiddleware(MiddlewareInterface $middleware)
    {
        $this->middlewares[] = $middleware;

        return $this;
    }
}
