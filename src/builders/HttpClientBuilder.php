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

use Comertis\Http\Abstraction\HttpClientInterface;
use Comertis\Http\Abstraction\BuilderInterface;
use Comertis\Http\HttpClient;

/**
 * Builder class for HttpClientInterface implementations
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
class HttpClientBuilder implements BuilderInterface
{
    /**
     * HttpClient instance
     *
     * @access private
     * @var    HttpClientInterface
     */
    private $client;

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
        $implementation = static::getImplementation();

        $this->client = new $implementation();
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
     * @param string $implementation Fully qualified class name
     *
     * @static
     * @access public
     * @return void
     */
    public static function setImplementation($implementation)
    {
        static::$implementation = $implementation;

        if (null !== static::$instance) {
            static::$instance->updateImplementation($implementation);
        }
    }

    /**
     * Build a HttpClientInterface instance
     *
     * @static
     * @access public
     * @return HttpClient
     */
    public static function build()
    {
        return $this->client;
    }
}
