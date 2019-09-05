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

use Comertis\Exceptions\NullReferenceException;
use Comertis\Http\Abstraction\AdapterInterface;
use Comertis\Http\Adapters\CurlAdapter;
use Comertis\Http\Adapters\PeclAdapter;
use Comertis\Http\Adapters\StreamAdapter;

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
class AdapterBuilder
{
    /**
     * AdapterInterface implementation
     *
     * @access private
     * @var    AdapterInterface
     */
    private $adapter;

    public function __construct()
    {
        $this->adapter = null;
    }

    /**
     * Initialize the AdapterBuilder
     *
     * @static
     * @access public
     * @return static
     */
    public static function init()
    {
        return new static();
    }

    /**
     * Set the adapter implementation
     *
     * @param string $implementation
     *
     * @access public
     * @return static
     */
    public function withImplementation($implementation)
    {
        $this->adapter = static::build($implementation);

        return $this;
    }

    /**
     * Create an instance of a AdapterInterface based on loaded extensions
     * and/or available functions
     *
     * @param string|array $implementation Explicit AdapterInterface implementation
     *
     * @static
     * @access public
     * @throws NullReferenceException
     * @return AdapterInterface
     */
    public static function build($implementation = null)
    {
        $adapter = null;

        if (null === $implementation) {
            $adapter = static::getAdapter();
        } else {
            $adapter = static::getAdapterImplementation($implementation);
        }

        if (null === $adapter) {
            $message = "Failed to create an adapter, missing necessary extensions/functions";
            throw new NullReferenceException($message);
        }

        return $adapter;
    }

    /**
     * Create an explicit implementation of AdapterInterface
     *
     * @param string|array $adapter Adapter implementation
     *
     * @static
     * @access public
     * @return AdapterInterface|null
     */
    public static function getAdapterImplementation($adapter)
    {
        if (is_array($adapter)) {
            foreach ($adapter as $key => $value) {
                // Recursive call until one adapter || null is returned
                $implementation = self::getAdapterImplementation($value);

                if ($implementation instanceof AdapterInterface) {
                    return $implementation;
                }
            }
        }

        switch ($adapter) {
            case CurlAdapter::class:
                if (CurlAdapter::isAvailable()) {
                    return new CurlAdapter();
                }
                break;

            case PeclAdapter::class:
                if (PeclAdapter::isAvailable()) {
                    return new PeclAdapter();
                }
                break;

            case StreamAdapter::class:
                if (StreamAdapter::isAvailable()) {
                    return new StreamAdapter();
                }
                break;
            default:
                return null;
                break;
        }

        return null;
    }

    /**
     * Load an instance of AdapterInterface based on installed
     * PHP extensions and/or available functions
     *
     * @static
     * @access private
     * @return AdapterInterface|null
     */
    private static function getAdapter()
    {
        if (CurlAdapter::isAvailable()) {
            return new CurlAdapter();
        } elseif (StreamAdapter::isAvailable()) {
            return new StreamAdapter();
        }

        return null;
    }
}
