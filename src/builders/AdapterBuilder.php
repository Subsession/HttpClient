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
use ReflectionClass;

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
            $implementation = self::getFirstAdapterImplementation();
            if ($implementation::isAvailable()) {
                $adapter = new $implementation();
            }
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
            $implementation = null;
            foreach ($adapter as $key => $value) {
                // Recursive call until one adapter || null is returned
                $implementation = self::getAdapterImplementation($value);

                if ($implementation instanceof AdapterInterface) {
                    return $implementation;
                }
            }

            return $implementation;
        }

        if ($adapter::isAvailable()) {
            return new $adapter();
        }

        return null;
    }

    private static function getFirstAdapterImplementation()
    {
        foreach (get_declared_classes() as $className) {
            if (in_array(AdapterInterface::class, class_implements($className))) {
                $adapter = new ReflectionClass($className);

                if ($adapter->isInstantiable()) {
                    return $className;
                }
            }
        }
    }
}
