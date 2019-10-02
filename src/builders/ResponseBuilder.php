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

namespace Subsession\Http\Builders;

use Subsession\Http\Response;
use Subsession\Http\Builders\Mocks\MockResponse;

use Subsession\Http\Abstraction\{
    BuilderInterface,
    ResponseInterface
};
use Subsession\Http\Tools\Validator;

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian.moraru@live.com>
 */
class ResponseBuilder implements BuilderInterface
{
    /**
     * MockResponse instance
     *
     * Stores all the info needed to create the
     * ResponseInterface instance
     *
     * @var MockResponse
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
     * Default ResponseInterface implementation class
     *
     * @static
     * @access private
     * @var    string
     */
    private static $defaultImplementation = Response::class;

    public function __construct()
    {
        $this->config = new MockResponse();
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
     * @param string|null $implementation Fully qualified class name or NULL to
     *                                    reset to the default internal implementation
     *
     * @static
     * @throws \Subsession\Exceptions\InvalidArgumentException
     * @access public
     * @return void
     */
    public static function setImplementation($implementation)
    {
        if (null === $implementation) {
            $implementation = static::$defaultImplementation;
        } elseif (!Validator::implements($implementation, ResponseInterface::class)) {
            $error = "$implementation is not an instance of ResponseInterface";
            throw new \Subsession\Exceptions\InvalidArgumentException($error);
        }

        static::$implementation = $implementation;

        if (null !== static::$instance) {
            static::$instance = new static();
        }
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
        $this->config->statusCode = $statusCode;

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
        $this->config->headers = $headers;

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
        $this->config->body = $body;

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
        $this->config->error = $error;

        return $this;
    }

    /**
     * Build a ResponseInterface implementation
     *
     * @access public
     * @return ResponseInterface|Response
     */
    public function build()
    {
        /** @var string $implementation */
        $implementation = static::getImplementation();

        /** @var ResponseInterface $response */
        $response = new $implementation();

        $response->setStatusCode($this->config->statusCode)
            ->setHeaders($this->config->headers)
            ->setBody($this->config->body)
            ->setError($this->config->error);

        return $response;
    }
}
