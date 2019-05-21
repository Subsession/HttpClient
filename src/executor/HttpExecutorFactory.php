<?php

namespace Comertis\Http\Internal\Executors;

use Comertis\Http\HttpExecutorException;
use Comertis\Http\Internal\Executors\HttpCurlExecutor;
use Comertis\Http\Internal\Executors\HttpExecutorImplementation;
use Comertis\Http\Internal\Executors\HttpPeclExecutor;
use Comertis\Http\Internal\Executors\HttpStreamExecutor;

/**
 * Responsible for creating an implementation of IHttpExecutor
 * based on available PHP extensions and/or functions
 */
class HttpExecutorFactory
{
    /**
     * Instance of IHttpExecutor used to avoid
     * having to re-declare it on each fetch
     *
     * @static
     * @access private
     * @var IHttpExecutor|null
     */
    private static $_executor = null;

    /**
     * Create an instance of a IHttpExecutor based on loaded extensions
     * and/or available functions
     *
     * @static
     * @access public
     * @return IHttpExecutor
     * @throws HttpExecutorException
     */
    public static function getExecutor()
    {
        if (!isset(self::$_executor)) {
            self::$_executor = self::setExecutor();
        }

        if (is_null(self::$_executor)) {
            throw new HttpExecutorException("Failed to create an executor, missing necessary extensions/functions");
        }

        return self::$_executor;
    }

    /**
     * Load an instance of IHttpExecutor based on installed
     * PHP extensions and/or available functions
     *
     * @static
     * @access private
     * @return IHttpExecutor|null
     */
    private static function setExecutor()
    {
        /**
         * @var IHttpExecutor|null
         */
        $implementation = null;

        if (self::checkCurlImplementation()) {
            $implementation = new HttpCurlExecutor();
        } else if (self::checkPeclImplementation()) {
            $implementation = new HttpPeclExecutor();
        } else if (self::checkStreamImplementation()) {
            $implementation = new HttpStreamExecutor();
        }

        return $implementation;
    }

    /**
     * Check the requirements for the HttpCurlExecutor
     *
     * @static
     * @access private
     * @return bool
     */
    private static function checkCurlImplementation()
    {
        /**
         * @var bool
         */
        $toReturn = true;

        if (!extension_loaded(HttpExecutorImplementation::CURL)) {
            $toReturn = false;
        }

        if (!function_exists('curl_init') | !function_exists('curl_close')) {
            $toReturn = false;
        }

        if (!function_exists('curl_setopt')) {
            $toReturn = false;
        }

        if (!function_exists('curl_exec')) {
            $toReturn = false;
        }

        if (!function_exists('curl_errno')) {
            $toReturn = false;
        }

        if (!function_exists('curl_getinfo')) {
            $toReturn = false;
        }

        return $toReturn;
    }

    /**
     * Check the requirements for HttpPeclExecutor
     *
     * @static
     * @access private
     * @return bool
     */
    private static function checkPeclImplementation()
    {
        /**
         * @var bool
         */
        $toReturn = true;

        if (!extension_loaded(HttpExecutorImplementation::PECL)) {
            $toReturn = false;
        }

        return $toReturn;
    }

    /**
     * Check the requirements for HttpContextExecutor
     *
     * @static
     * @access private
     * @return bool
     */
    private static function checkStreamImplementation()
    {
        /**
         * @var bool
         */
        $toReturn = true;

        if (!function_exists('stream_context_create')) {
            $toReturn = false;
        }

        if (!function_exists('fopen') | !function_exists('fclose')) {
            $toReturn = false;
        }

        if (!function_exists('stream_get_meta_data')) {
            $toReturn = false;
        }

        if (!function_exists('stream_get_contents')) {
            $toReturn = false;
        }

        return $toReturn;
    }
}
