<?php

/**
 * PHP Version 7
 *
 * LICENSE:
 * See the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Subsession
 *
 * @category Http
 * @package  Subsession\Http
 * @author   Cristian Moraru <cristian.moraru@live.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  GIT: &Id&
 * @link     https://github.com/Subsession/HttpClient
 */

namespace Subsession\Http\Builders;

use Subsession\Http\Abstraction\BuilderInterface;
use Subsession\Http\Abstraction\RequestInterface;
use Subsession\Http\Builders\Mocks\MockRequest;
use Subsession\Http\Request;

/**
 * Builds RequestInterface instances
 *
 * @category Http
 * @package  Subsession\Http
 * @author   Cristian Moraru <cristian.moraru@live.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Subsession/HttpClient
 */
class RequestBuilder implements BuilderInterface
{
    /**
     * MockRequest instance
     *
     * Stores all the info needed to build the
     * RequestInterface instance
     *
     * @var MockRequest
     */
    private $config = null;

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
        $this->config = new MockRequest();
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
     * @param string|null $implementation Fully qualified class name or NULL to
     *                                    reset to the default internal implementation
     *
     * @static
     * @access public
     * @return void
     */
    public static function setImplementation($implementation)
    {
        if (null === $implementation) {
            $implementation = static::$defaultImplementation;
        } elseif (!in_array(RequestInterface::class, class_implements($implementation))) {
            $error = "$implementation is not an instance of RequestInterface";
            throw new \Subsession\Exceptions\InvalidArgumentException($error);
        }

        static::$implementation = $implementation;

        if (null !== static::$instance) {
            static::$instance = new static();
        }
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
        $this->config->url = $url;

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
        $this->config->headers = $headers;

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
        $this->config->method = $method;

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
        $this->config->bodyType = $bodyType;

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
        $this->config->params = $params;

        return $this;
    }

    /**
     * Build a RequestInterface implementation
     * @access public
     * @return RequestInterface|Request
     */
    public function build()
    {
        /** @var string $implementation */
        $implementation = static::getImplementation();

        /** @var RequestInterface $request */
        $request = new $implementation();

        $request->setUrl($this->config->url)
            ->setHeaders($this->config->headers)
            ->setMethod($this->config->method)
            ->setParams($this->config->params)
            ->setBodyType($this->config->bodyType);

        return $request;
    }
}
