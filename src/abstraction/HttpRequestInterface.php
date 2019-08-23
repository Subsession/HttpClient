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

use Comertis\Http\Exceptions\HttpClientException;
use Comertis\Http\HttpRequestMethod;

/**
 * Undocumented interface
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
interface HttpRequestInterface
{
    /**
     * Get the HttpRequest headers
     *
     * @access public
     * @return array
     */
    public function getHeaders();

    /**
     * Set the HttpRequest headers
     *
     * @param array $headers Request headers
     *
     * @access public
     * @return self
     */
    public function setHeaders($headers);

    /**
     * Add headers to the request.
     * IMPORTANT: Overrides existing headers if
     * duplicate found
     *
     * @param array $headers Request headers
     *
     * @access public
     * @return void
     */
    public function addHeaders($headers);

    /**
     * Get the HttpRequest method
     *
     * @access public
     * @return string
     */
    public function getMethod();

    /**
     * Set the request method
     *
     * @param string $requestMethod Request method: GET|POST|PUT|DELETE
     *
     * @access public
     * @see    HttpRequestMethod
     * @return self
     */
    public function setMethod($requestMethod);
    /**
     * Get the request URL
     *
     * @access public
     * @return string
     */
    public function getUrl();

    /**
     * Set the request URL
     *
     * @param string $url URL
     *
     * @access public
     * @throws HttpClientException If the URL is null or empty
     * @return self
     */
    public function setUrl($url);

    /**
     * Get the HttpRequest parameters
     *
     * @access public
     * @return array
     */
    public function getParams();

    /**
     * Set the HttpRequest parameters
     *
     * @param array $params Request parameters
     *
     * @access public
     * @return self
     */
    public function setParams($params);

    /**
     * Get the request body type
     *
     * @access public
     * @return string
     */
    public function getBodyType();

    /**
     * Set the request body type
     *
     * @param string $bodyType Request body type
     *
     * @access public
     * @see    HttpRequestType
     * @return self
     */
    public function setBodyType($bodyType);
}
