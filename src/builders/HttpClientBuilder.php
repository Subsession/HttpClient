<?php

/**
 * PHP Version 7
 *
 * LICENSE:
 * See the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Subsession
 *
 * @author Cristian Moraru <cristian@subsession.org>
 */

namespace Subsession\Http\Builders;

use Subsession\Http\HttpClient;

use Subsession\Http\Builders\{
    AdapterBuilder,
    Mocks\MockHttpClient
};

use Subsession\Http\Abstraction\{
    AdapterInterface,
    BuilderInterface,
    RequestInterface,
    ResponseInterface,
    HttpClientInterface,
};
use Subsession\Http\Tools\Validator;

/**
 * Builder class for HttpClientInterface implementations
 *
 * @author Cristian Moraru <cristian@subsession.org>
 */
class HttpClientBuilder implements BuilderInterface
{
    /**
     * MockHttpClient instance
     *
     * Stores all the info needed to create the
     * HttpClientInterface instance
     *
     * @var MockHttpClient
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
     * Default implementation class to use in case none is specified
     *
     * @static
     * @access private
     * @var    string
     */
    private static $defaultImplementation = HttpClient::class;

    public function __construct()
    {
        $this->config = new MockHttpClient();
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
     * @inheritDoc
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
     * @inheritDoc
     *
     * Example:
     * ```php
     * AdapterBuilder::setImplementation(CurlAdapter::class);
     * ```
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
        } elseif (!Validator::implements($implementation, HttpClientInterface::class)) {
            $error = "$implementation is not an instance of HttpClientInterface";
            throw new \Subsession\Exceptions\InvalidArgumentException($error);
        }

        static::$implementation = $implementation;

        if (null !== static::$instance) {
            static::$instance = new static();
        }
    }

    /**
     * Set the AdapterInterface instance to use
     *
     * @param AdapterInterface|string $adapter
     *
     * @access public
     * @return static
     */
    public function withAdapter($adapter)
    {
        if (!$adapter instanceof AdapterInterface) {
            AdapterBuilder::setImplementation($adapter);
            $adapter = AdapterBuilder::getInstance()->build();
        }

        $this->config->adapter = $adapter;

        return $this;
    }

    /**
     * Set the RequestInterface instance to use
     *
     * @param RequestInterface $request
     * @return static
     */
    public function withRequest(RequestInterface $request)
    {
        $this->config->request = $request;

        return $this;
    }

    /**
     * Set the ResponseInterface to use
     *
     * @param ResponseInterface $response
     * @return static
     */
    public function withResponse(ResponseInterface $response)
    {
        $this->config->response = $response;

        return $this;
    }

    /**
     * Build a HttpClientInterface instance
     *
     * @access public
     * @return HttpClientInterface|HttpClient
     */
    public function build()
    {
        /** @var string $implementation */
        $implementation = static::getImplementation();

        /** @var HttpClientInterface $client */
        $client = new $implementation();

        if (null !== ($adapter = $this->config->adapter)) {
            $client->setAdapter($adapter);
        }

        if (null !== ($request = $this->config->request)) {
            $client->setRequest($request);
        }

        if (null !== ($response = $this->config->response)) {
            $client->setResponse($response);
        }

        return $client;
    }
}
