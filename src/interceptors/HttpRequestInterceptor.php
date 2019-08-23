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
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  GIT: &Id&
 * @link     https://github.com/Comertis/HttpClient
 */

namespace Comertis\Http\Interceptors;

use Comertis\Http\Abstraction\HttpRequestInterface;

/**
 * Undocumented class
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
class HttpRequestInterceptor
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
     * Process the HttpRequestInterface with the provided callback function
     *
     * @param HttpRequestInterface $request
     *
     * @access public
     * @return HttpRequestInterface
     */
    public function handle(HttpRequestInterface &$request)
    {
        if (is_callable($this->callback)) {
            $callback = $this->callback;
            $callback($request);
        }

        return $request;
    }

    /**
     * Intercept HttpRequestInterface instances before they are processed
     *
     * @param callable $callback
     *
     * @access public
     * @return HttpRequestInterface
     */
    public function intercept(callable $callback)
    {
        $this->callback = $callback;
    }
}
