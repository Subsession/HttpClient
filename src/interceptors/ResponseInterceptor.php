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
class ResponseInterceptor
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
     * Process the ResponseInterface with the provided callback function
     *
     * @param ResponseInterface $response
     *
     * @access public
     * @return ResponseInterface
     */
    public function handle(ResponseInterface &$response)
    {
        if (is_callable($this->callback)) {
            $callback = $this->callback;
            $callback($response);
        }

        return $response;
    }

    /**
     * Intercept ResponseInterface instances before they are processed
     *
     * @param callable $callback
     *
     * @access public
     * @return ResponseInterface
     */
    public function intercept(callable $callback)
    {
        $this->callback = $callback;
    }
}
