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

use Comertis\Http\HttpStatusCode;

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
interface ResponseInterface
{
    /**
     * Get the response headers
     *
     * @access public
     * @return array
     */
    public function getHeaders();

    /**
     * Set the response headers
     *
     * @param array $headers Response headers
     *
     * @access public
     * @return static
     */
    public function setHeaders($headers);

    /**
     * Get the response status code
     *
     * @access public
     * @return integer
     */
    public function getStatusCode();

    /**
     * Set the response status code
     *
     * @param integer $statusCode Status code
     *
     * @access public
     * @see    HttpStatusCode
     * @return static
     */
    public function setStatusCode($statusCode);

    /**
     * Get the response body
     *
     * @access public
     * @return mixed|null
     */
    public function getBody();

    /**
     * Set the response body
     *
     * @param string|mixed $body Response body
     *
     * @access public
     * @return static
     */
    public function setBody($body);

    /**
     * Get the response error
     *
     * @access public
     * @return string|null
     */
    public function getError();

    /**
     * Set the response error
     *
     * @param string $error Error message
     *
     * @access public
     * @return static
     */
    public function setError($error);

    /**
     * Flag indicating that the response is in the 1xx status range
     *
     * @access public
     * @return boolean
     */
    public function isInformational();

    /**
     * Flag indicating that the response is in the 2xx status range
     *
     * @access public
     * @return boolean
     */
    public function isSuccess();

    /**
     * Flag indicating that the response is in the 3xx status range
     *
     * @access public
     * @return boolean
     */
    public function isRedirect();

    /**
     * Flag indicating that the response is in the 4xx status range
     *
     * @access public
     * @return boolean
     */
    public function isClientError();

    /**
     * Flag indicating that the response is in the 5xx status range
     *
     * @access public
     * @return boolean
     */
    public function isServerError();
}
