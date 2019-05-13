<?php

namespace Comertis\Http\Internal;

use Comertis\Http\HttpExecutorException;
use Comertis\Http\Internal\HttpCurlExecutor;
use Comertis\Http\Internal\HttpPeclExecutor;
use Comertis\Http\Internal\HttpStreamExecutor;
use Comertis\Http\Internal\HttpExecutorImplementation;

class HttpExecutorFactory
{
    /**
     * Instance of IHttpExecutor used to avoid
     * having to re-declare it on each fetch
     *
     * @var IHttpExecutor|null
     */
    private static $_executor = null;

    /**
     * Create an instance of a IHttpExecutor
     * based on loaded extensions
     *
     * @access public
     * @return IHttpExecutor
     * @throws HttpExecutorException
     */
    public static function getExecutor()
    {
        if (!isset(self::$_executor)) {
            self::$_executor = self::setExecutor();
        }

        if (\is_null(self::$_executor)) {
            throw new HttpExecutorException("Failed to create an executor, missing necessary extensions");
        }

        return self::$_executor;
    }

    /**
     * Load an instance of IHttpExecutor based on installed
     * PHP extensions
     *
     * @access private
     * @return void
     */
    private static function setExecutor()
    {
        if (\extension_loaded(HttpExecutorImplementation::CURL)) {
            return new HttpCurlExecutor();
        } else if (\extension_loaded(HttpExecutorImplementation::PECL)) {
            return new HttpPeclExecutor();
        } else {
            return new HttpStreamExecutor();
        }
    }
}
