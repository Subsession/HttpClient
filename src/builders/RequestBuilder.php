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
class RequestBuilder
{
    /**
     * Request instance
     *
     * @access private
     * @var    RequestInterface
     */
    private $request;

    /**
     * RequestInterface class implementation
     *
     * @static
     * @access private
     * @var    string
     */
    private static $requestClass;

    /**
     * Default RequestInterface implementation class
     *
     * @static
     * @access private
     * @var    string
     */
    private static $defaultRequestClass = Request::class;

    /**
     * Self instance
     *
     * @static
     * @access private
     * @var    static
     */
    private static $instance = null;

    public function __construct()
    {
        $implementation = static::getRequestClass();

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
        if (static::$instance === null) {
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
    public static function getRequestClass()
    {
        if (null === static::$requestClass) {
            static::setRequestClass(static::$defaultRequestClass);
        }

        return static::$requestClass;
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
    public static function setRequestClass($className)
    {
        static::$requestClass = $className;

        if (null !== static::$instance) {
            static::$instance->updateRequestClass($className);
        }
    }

    private function updateRequestClass($className)
    {
        $this->response = new $className();
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
