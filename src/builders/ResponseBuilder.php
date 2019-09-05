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

namespace Comertis\Http\Builders;

use Comertis\Http\Abstraction\ResponseInterface;
use Comertis\Http\Response;

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
class ResponseBuilder
{
    /**
     * ResponseInterface implementation
     *
     * @access private
     * @var    ResponseInterface
     */
    private $response;

    /**
     * ResponseInterface class implementation
     *
     * @static
     * @access private
     * @var    string
     */
    private static $responseClass;

    /**
     * Default ResponseInterface implementation class
     *
     * @static
     * @access private
     * @var    string
     */
    private static $defaultResponseClass = Response::class;

    /**
     * Self instance
     *
     * @static
     * @access private
     * @var    static
     */
    private static $instance = null;

    public function __construct($implementation = null)
    {
        $implementation = $implementation ?? static::getResponseClass();

        $this->response = new $implementation();
    }

    /**
     * Get instance of self
     *
     * @static
     * @access public
     * @return static
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Get the implementation class for ResponseInterface
     *
     * @static
     * @access public
     * @return string
     */
    public static function getResponseClass()
    {
        if (null === static::$responseClass) {
            static::setResponseClass(static::$defaultResponseClass);
        }

        return static::$responseClass;
    }

    /**
     * Set the ResponseInterface implementation class
     *
     * @param string $className
     *
     * @static
     * @access public
     * @return void
     */
    public static function setResponseClass($className)
    {
        static::$responseClass = $className;

        static::$instance = new static(static::$responseClass);
    }

    /**
     * Set the response status code
     *
     * @param int $statusCode
     *
     * @access public
     * @return static
     */
    public function withStatusCode($statusCode)
    {
        $this->response->setStatusCode($statusCode);

        return $this;
    }

    /**
     * Set the response headers
     *
     * @param array $headers
     *
     * @access public
     * @return static
     */
    public function withHeaders($headers)
    {
        $this->response->setHeaders($headers);

        return $this;
    }

    /**
     * Set the response body
     *
     * @param mixed $body
     *
     * @access public
     * @return static
     */
    public function withBody($body)
    {
        $this->response->setBody($body);

        return $this;
    }

    /**
     * Set the response error
     *
     * @param mixed $error
     *
     * @access public
     * @return static
     */
    public function withError($error)
    {
        $this->response->setError($error);

        return $this;
    }

    /**
     * Build a ResponseInterface implementation
     *
     * @access public
     * @return ResponseInterface
     */
    public function build()
    {
        return $this->response;
    }
}
