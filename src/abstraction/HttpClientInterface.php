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
use Comertis\Http\Adapters\AdapterInterface;

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
interface HttpClientInterface
{
    /**
     * Get the RequestInterface instance
     *
     * @access public
     * @return RequestInterface
     */
    public function getRequest();

    /**
     * Set the RequestInterface instance
     *
     * @param RequestInterface $request RequestInterface instance
     *
     * @access public
     * @return self
     */
    public function setRequest(RequestInterface $request);

    /**
     * Get the Response instance after executing
     * a RequestInterface
     *
     * This returns null if called before executing
     * the RequestInterface.
     *
     * @access public
     * @return ResponseInterface
     */
    public function getResponse();

    /**
     * Set the ResponseInterface instance
     *
     * This should never be used explicitly in
     * normal use-cases, this method exists for
     * consistency reasons.
     *
     * @param ResponseInterface $response ResponseInterface instance
     *
     * @access public
     * @return self
     */
    public function setResponse(ResponseInterface $response);

    /**
     * Get the explicitly specified AdapterInterface implementation
     * used for requests
     *
     * @access public
     * @return AdapterInterface|null
     */
    public function getAdapter();

    /**
     * Specify an explicit AdapterInterface implementation to use
     * for requests, either just one, or a array with the preferred
     * order of the available implementations.
     *
     * @param string|AdapterInterface $adapter
     *
     * @access public
     * @see    AdapterInterface
     * @return self
     */
    public function setAdapter($adapter);

    /**
     * Handle the RequestInterface
     *
     * This handles the Interceptor calls and the
     * AdapterInterface::handle() call.
     *
     * @param RequestInterface $request
     *
     * @access public
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request);
}
