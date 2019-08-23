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

use Comertis\Http\Adapters\HttpCurlAdapter;
use Comertis\Http\Adapters\HttpPeclAdapter;
use Comertis\Http\Adapters\HttpStreamAdapter;
use Comertis\Http\Exceptions\HttpAdapterException;

/**
 * Builder class for HttpAdapterInterface implementations
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
class HttpAdapterBuilder
{
    /**
     * Create an instance of a HttpAdapterInterface based on loaded extensions
     * and/or available functions
     *
     * @param string|array $implementation Explicit HttpAdapterInterface implementation
     *
     * @static
     * @access public
     * @throws HttpAdapterException
     * @return HttpAdapterInterface
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
            throw new HttpAdapterException($message);
        }

        return $adapter;
    }

    /**
     * Create an explicit implementation of HttpAdapterInterface
     *
     * @param string|array $adapter Adapter implementation
     *
     * @static
     * @access public
     * @return HttpAdapterInterface|null
     */
    public static function getAdapterImplementation($adapter)
    {
        if (is_array($adapter)) {
            foreach ($adapter as $key => $value) {
                // Recursive call until one adapter | null is returned
                return self::getAdapterImplementation($value);
            }
        }

        switch ($adapter) {
            case HttpCurlAdapter::class:
                if (HttpCurlAdapter::isAvailable()) {
                    return new HttpCurlAdapter();
                }
                break;

            case HttpPeclAdapter::class:
                if (HttpPeclAdapter::isAvailable()) {
                    return new HttpPeclAdapter();
                }
                break;

            case HttpStreamAdapter::class:
                if (HttpStreamAdapter::isAvailable()) {
                    return new HttpStreamAdapter();
                }
                break;
            default:
                return null;
                break;
        }

        return null;
    }

    /**
     * Load an instance of HttpAdapterInterface based on installed
     * PHP extensions and/or available functions
     *
     * @static
     * @access private
     * @return HttpAdapterInterface|null
     */
    private static function getAdapter()
    {
        if (HttpCurlAdapter::isAvailable()) {
            return new HttpCurlAdapter();
        } elseif (self::checkPeclImplementation()) {
            return new HttpPeclAdapter();
        } elseif (HttpStreamAdapter::isAvailable()) {
            return new HttpStreamAdapter();
        }

        return null;
    }
}
