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

use Comertis\Http\Abstraction\AdapterInterface;
use Comertis\Http\Abstraction\BuilderInterface;
use Comertis\Http\Adapters\CurlAdapter;

/**
 * Builder class for AdapterInterface implementations
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
class AdapterBuilder implements BuilderInterface
{
    /**
     * AdapterInterface implementation
     *
     * @access private
     * @var    AdapterInterface
     */
    private $adapter;

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
    private static $defaultImplementation = CurlAdapter::class;

    public function __construct()
    {
        $implementation = static::getImplementation();

        $this->adapter = new $implementation();
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

    public function updateImplementation($implementation)
    {
        $this->adapter = new $implementation();
    }

    /**
     * Build the AdapterInterface instance
     *
     * @access public
     * @return AdapterInterface
     */
    public function build()
    {
        return $this->adapter;
    }
}
