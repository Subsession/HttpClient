<?php

/**
 * PHP Version 7
 *
 * LICENSE:
 * See the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Subsession
 *
 * @author Cristian Moraru <cristian.moraru@live.com>
 */

namespace Subsession\Http\Abstraction;

use Subsession\Exceptions\ArgumentNullException;
use Subsession\Http\HttpRequestMethod;

/**
 * Undocumented interface
 *
 * @author Cristian Moraru <cristian.moraru@live.com>
 */
interface RequestInterface
{
    /**
     * Get the Request headers
     *
     * @access public
     * @return array
     */
    public function getHeaders();

    /**
     * Set the Request headers
     *
     * @param array $headers Request headers
     *
     * @access public
     * @return static
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
     * Get the Request method
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
     * @return static
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
     * @throws ArgumentNullException If the URL is null or empty
     * @access public
     * @return static
     */
    public function setUrl($url);

    /**
     * Get the Request parameters
     *
     * @access public
     * @return array
     */
    public function getParams();

    /**
     * Set the Request parameters
     *
     * @param array $params Request parameters
     *
     * @access public
     * @return static
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
     * @return static
     */
    public function setBodyType($bodyType);
}
