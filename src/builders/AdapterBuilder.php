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

use Subsession\Http\{
    Abstraction\AdapterInterface,
    Abstraction\BuilderInterface,
    Adapters\CurlAdapter
};
use Subsession\Http\Tools\Validator;

/**
 * Builder class for AdapterInterface implementations
 *
 * @author Cristian Moraru <cristian.moraru@live.com>
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
     * NULL resets to default internal implementation
     *
     * Example:
     * ```php
     * AdapterBuilder::setImplementation(CurlAdapter::class);
     * ```
     *
     * @param string|null $implementation Fully qualified class name
     *
     * @static
     * @access public
     * @throws \Subsession\Exceptions\InvalidArgumentException
     * @return void
     */
    public static function setImplementation($implementation)
    {
        if (null === $implementation) {
            $implementation = static::$defaultImplementation;
        } elseif (!Validator::implements($implementation, AdapterInterface::class)) {
            $error = "$implementation is not an instance of AdapterInterface";
            throw new \Subsession\Exceptions\InvalidArgumentException($error);
        }

        static::$implementation = $implementation;

        if (null !== static::$instance) {
            static::$instance->updateImplementation($implementation);
        }
    }

    /**
     * IMPORTANT: DO NOT USE
     *
     * Used to change the implementation class for the `AdapterInterface`
     *
     * @param string $implementation
     *
     * @return void
     */
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
