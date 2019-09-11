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
use Comertis\Http\Abstraction\RequestInterface;
use Comertis\Http\Request;

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
class RequestBuilder implements BuilderInterface
{
    /**
     * Request instance
     *
     * @access private
     * @var    RequestInterface
     */
    private $request;

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
     * Default RequestInterface implementation class
     *
     * @static
     * @access private
     * @var    string
     */
    private static $defaultImplementation = Request::class;

    public function __construct()
    {
        $implementation = static::getImplementation();

        $this->request = new $implementation();
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
     * Get the implementation class for RequestInterface
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
     * Set the RequestInterface implementation class
     *
     * @param string $className
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
        $this->request = new $implementation();
    }

    /**
     * Set the request url
     *
     * @param string $url
     *
     * @access public
     * @return static
     */
    public function withUrl($url)
    {
        $this->request->setUrl($url);

        return $this;
    }

    /**
     * Set the request headers
     *
     * @param array $headers
     *
     * @access public
     * @return static
     */
    public function withHeaders(array $headers)
    {
        $this->request->setHeaders($headers);

        return $this;
    }

    /**
     * Set the request method
     *
     * @param string $method
     *
     * @access public
     * @return static
     */
    public function withMethod($method)
    {
        $this->request->setMethod($method);

        return $this;
    }

    /**
     * Set the request body type
     *
     * @param string $bodyType
     *
     * @access public
     * @return static
     */
    public function withBodyType($bodyType)
    {
        $this->request->setBodyType($bodyType);

        return $this;
    }

    /**
     * Set the request params
     *
     * @param array $params
     *
     * @access public
     * @return static
     */
    public function withParams($params)
    {
        $this->request->setParams($params);

        return $this;
    }

    /**
     * Build a RequestInterface implementation
     * @access public
     * @return RequestInterface
     */
    public function build()
    {
        return $this->request;
    }
}
