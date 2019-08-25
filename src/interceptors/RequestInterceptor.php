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

namespace Comertis\Http\Interceptors;

use Comertis\Http\Abstraction\RequestInterface;

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
class RequestInterceptor
{
    /**
     * Callable function
     *
     * @var callable|null
     */
    private $callback;

    public function __construct()
    {
        $this->callback = null;
    }

    /**
     * Process the RequestInterface with the provided callback function
     *
     * @param RequestInterface $request
     *
     * @access public
     * @return RequestInterface
     */
    public function handle(RequestInterface &$request)
    {
        if (is_callable($this->callback)) {
            $callback = $this->callback;
            $callback($request);
        }

        return $request;
    }

    /**
     * Intercept RequestInterface instances before they are processed
     *
     * @param callable $callback
     *
     * @access public
     * @return RequestInterface
     */
    public function intercept(callable $callback)
    {
        $this->callback = $callback;
    }
}
