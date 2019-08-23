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

use Comertis\Http\Interceptors\HttpRequestInterceptor;
use Comertis\Http\Interceptors\HttpResponseInterceptor;

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
class HttpInterceptor
{
    /**
     * Request interceptor
     *
     * @access private
     * @var    HttpRequestInterceptor
     */
    private $request;

    /**
     * Response interceptor
     *
     * @access private
     * @var    HttpResponseInterceptor
     */
    private $response;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->request = new HttpRequestInterceptor();
        $this->response = new HttpResponseInterceptor();
    }

    /**
     * Get the request interceptor
     *
     * @access public
     * @return HttpRequestInterceptor
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get the response interceptor
     *
     * @access public
     * @return HttpResponseInterceptor
     */
    public function getResponse()
    {
        return $this->response;
    }
}
