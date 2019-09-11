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

use Comertis\Http\Abstraction\BuilderInterface;
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
class ResponseBuilder implements BuilderInterface
{
    /**
     * ResponseInterface implementation
     *
     * @access private
     * @var    ResponseInterface
     */
    private $response;

    /**
     * Self instance
     *
     * @static
     * @access protected
     * @var    static
     */
    protected static $instance = null;

    /**
     * Implementation class of whatever is being built
     *
     * @static
     * @access protected
     * @var    string
     */
    protected static $implementation = null;

    /**
     * Default ResponseInterface implementation class
     *
     * @static
     * @access private
     * @var    string
     */
    private static $defaultImplementation = Response::class;

    public function __construct()
    {
        $implementation = static::getImplementation();

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
    public static function getImplementation()
    {
        if (null === static::$implementation) {
            static::setImplementation(static::$defaultImplementation);
        }

        return static::$implementation;
    }

    /**
     * Set the ResponseInterface implementation class
     *
     * @param string $implementation
     *
     * @static
     * @access public
     * @return void
     */
    public static function setImplementation($implementation)
    {
        static::$implementation = $implementation;

        if (null !== static::$instance) {
            static::$instance->updateImplementationClass($implementation);
        }
    }

    private function updateImplementationClass($implementation)
    {
        $this->response = new $implementation();
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
