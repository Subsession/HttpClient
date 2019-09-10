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
abstract class BaseBuilder implements BuilderInterface
{
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
     * Get the fully qualified name of the class being built
     *
     * @static
     * @access public
     * @return string
     */
    public static function getImplementation()
    {
        return static::$implementation;
    }

    /**
     * Set the fully qualified name of the class to build
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
    }

    /**
     * @inheritDoc
     *
     * @abstract
     * @access public
     * @return object
     */
    abstract public function build();
}
