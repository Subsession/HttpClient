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
use Comertis\Http\Adapters\HttpAdapterInterface;

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
interface HttpClientInterface
{
    /**
     * Get the HttpRequestInterface instance
     *
     * @access public
     * @return HttpRequestInterface
     */
    public function getRequest();

    /**
     * Set the HttpRequestInterface instance
     *
     * @param HttpRequestInterface $request HttpRequestInterface instance
     *
     * @access public
     * @return self
     */
    public function setRequest(HttpRequestInterface $request);

    /**
     * Get the HttpResponse instance after executing
     * a HttpRequestInterface
     *
     * This returns null if called before executing
     * the HttpRequestInterface.
     *
     * @access public
     * @return HttpResponseInterface
     */
    public function getResponse();

    /**
     * Set the HttpResponseInterface instance
     *
     * This should never be used explicitly in
     * normal use-cases, this method exists for
     * consistency reasons.
     *
     * @param HttpResponseInterface $response HttpResponseInterface instance
     *
     * @access public
     * @return self
     */
    public function setResponse(HttpResponseInterface $response);

    /**
     * Get the explicitly specified HttpAdapterInterface implementation
     * used for requests
     *
     * @access public
     * @return HttpAdapterInterface|null
     */
    public function getAdapter();

    /**
     * Specify an explicit HttpAdapterInterface implementation to use
     * for requests, either just one, or a array with the preferred
     * order of the available implementations.
     *
     * @param string|HttpAdapterInterface $adapter
     *
     * @access public
     * @see    HttpAdapterInterface
     * @return self
     */
    public function setAdapter($adapter);

    /**
     * Handle the HttpRequestInterface
     *
     * This handles the HttpInterceptor calls and the
     * HttpAdapterInterface::handle() call.
     *
     * @param HttpRequestInterface $request
     *
     * @access public
     * @return HttpResponseInterface
     */
    public function handle(HttpRequestInterface $request);
}
