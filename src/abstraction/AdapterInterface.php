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

namespace Comertis\Http\Abstraction;

use Comertis\Http\Abstraction\RequestInterface;
use Comertis\Http\Abstraction\ResponseInterface;

/**
 * Defines the minimum necessary for a HttpExecutor
 * implementation regardless of used library or extension
 *
 * @uses Comertis\Http\RequestInterface
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
interface AdapterInterface
{
    /**
     * Make any necessary changes to the RequestInterface URL before executing
     *
     * @param RequestInterface $request RequestInterface instance, passed by reference
     *
     * @access public
     * @return void
     */
    public function prepareUrl(RequestInterface &$request);

    /**
     * Make any necessary changes to the RequestInterface headers before executing
     *
     * @param RequestInterface $request RequestInterface instance, passed by reference
     *
     * @access public
     * @return void
     */
    public function prepareHeaders(RequestInterface &$request);

    /**
     * Make any necessary changes to the RequestInterface parameters before executing
     *
     * @param RequestInterface $request RequestInterface instance, passed by reference
     *
     * @access public
     * @return void
     */
    public function prepareParams(RequestInterface &$request);

    /**
     * Execute the RequestInterface and return a ResponseInterface instance
     *
     * @param RequestInterface $request RequestInterface instance
     *
     * @access public
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request);
}
