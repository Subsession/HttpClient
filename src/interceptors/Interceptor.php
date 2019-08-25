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

use Comertis\Http\Interceptors\RequestInterceptor;
use Comertis\Http\Interceptors\ResponseInterceptor;

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
class Interceptor
{
    /**
     * Request interceptor
     *
     * @access private
     * @var    RequestInterceptor
     */
    private $request;

    /**
     * Response interceptor
     *
     * @access private
     * @var    ResponseInterceptor
     */
    private $response;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->request = new RequestInterceptor();
        $this->response = new ResponseInterceptor();
    }

    /**
     * Get the request interceptor
     *
     * @access public
     * @return RequestInterceptor
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get the response interceptor
     *
     * @access public
     * @return ResponseInterceptor
     */
    public function getResponse()
    {
        return $this->response;
    }
}
