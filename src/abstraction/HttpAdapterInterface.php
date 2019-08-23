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

namespace Comertis\Http\Abstraction;

use Comertis\Http\Abstraction\HttpRequestInterface;
use Comertis\Http\Abstraction\HttpResponseInterface;

/**
 * Defines the minimum necessary for a HttpExecutor
 * implementation regardless of used library or extension
 *
 * @uses Comertis\Http\HttpRequestInterface
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
interface HttpAdapterInterface
{
    /**
     * Make any necessary changes to the HttpRequestInterface URL before executing
     *
     * @param HttpRequestInterface $request HttpRequestInterface instance, passed by reference
     *
     * @access public
     * @return void
     */
    public function prepareUrl(HttpRequestInterface &$request);

    /**
     * Make any necessary changes to the HttpRequestInterface headers before executing
     *
     * @param HttpRequestInterface $request HttpRequestInterface instance, passed by reference
     *
     * @access public
     * @return void
     */
    public function prepareHeaders(HttpRequestInterface &$request);

    /**
     * Make any necessary changes to the HttpRequestInterface parameters before executing
     *
     * @param HttpRequestInterface $request HttpRequestInterface instance, passed by reference
     *
     * @access public
     * @return void
     */
    public function prepareParams(HttpRequestInterface &$request);

    /**
     * Execute the HttpRequestInterface and return a HttpResponseInterface instance
     *
     * @param HttpRequestInterface $request HttpRequestInterface instance
     *
     * @access public
     * @return HttpResponseInterface
     */
    public function handle(HttpRequestInterface $request);
}
