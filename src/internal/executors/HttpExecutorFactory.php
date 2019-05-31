<?php
/**
 * PHP Version 7
 *
 * LICENSE:
 * Permission is hereby granted, free of charge, to any
 * person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the
 * Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall
 * be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  GIT: &Id&
 * @link     https://github.com/Comertis/Cache
 */

namespace Comertis\Http\Internal\Executors;

use Comertis\Http\Exceptions\HttpExecutorException;
use Comertis\Http\Internal\Executors\HttpCurlExecutor;
use Comertis\Http\Internal\Executors\HttpPeclExecutor;
use Comertis\Http\Internal\Executors\HttpStreamExecutor;

/**
 * Responsible for creating an implementation of IHttpExecutor
 * based on available PHP extensions and/or functions
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/Cache
 */
class HttpExecutorFactory
{
    /**
     * Instance of IHttpExecutor used to avoid
     * having to re-declare it on each fetch
     *
     * @static
     * @access private
     * @var    IHttpExecutor|null
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
            self::$_executor = self::_setExecutor();
        }

        if (is_null(self::$_executor)) {
            $message = "Failed to create an executor, missing necessary extensions/functions";
            throw new HttpExecutorException($message);
        }

        return self::$_executor;
    }

    /**
     * Create an explicit implementation of IHttpExecutor
     *
     * @param string|array $implementation Executor implementation
     *
     * @static
     * @access public
     * @return IHttpExecutor|null
     */
    public static function getExplicitExecutor($implementation)
    {
        /**
         * Implementation of IHttpExecutor
         *
         * @var IHttpExecutor|null
         */
        $toReturn = null;

        if (is_array($implementation)) {
            return self::_getExplicitExecutorFromArray($implementation);
        }

        switch ($implementation) {
            case HttpCurlExecutor::class:
                if (self::_checkCurlImplementation()) {
                    $toReturn = new HttpCurlExecutor();
                }
                break;

            case HttpPeclExecutor::class:
                if (self::_checkPeclImplementation()) {
                    $toReturn = new HttpPeclExecutor();
                }
                break;

            case HttpStreamExecutor::class:
                if (self::_checkStreamImplementation()) {
                    $toReturn = new HttpStreamExecutor();
                }
                break;
            default:
                break;
        }

        return $toReturn;
    }

    /**
     * Create an explicit implementation of IHttpExecutor
     * given an array of preferred implementations
     *
     * @param array $implementations Executor implementations
     *
     * @static
     * @access public
     * @return IHttpExecutor|null
     */
    private static function _getExplicitExecutorFromArray($implementations)
    {
        /**
         * Implementation of IHttpExecutor
         *
         * @var IHttpExecutor|null
         */
        $toReturn = null;

        foreach ($implementations as $key => $value) {
            switch ($value) {
                case HttpCurlExecutor::class:
                    if (self::_checkCurlImplementation()) {
                        return new HttpCurlExecutor();
                    }
                    break;

                case HttpPeclExecutor::class:
                    if (self::_checkPeclImplementation()) {
                        return new HttpPeclExecutor();
                    }
                    break;

                case HttpStreamExecutor::class:
                    if (self::_checkStreamImplementation()) {
                        return new HttpStreamExecutor();
                    }
                    break;

                default:
                    break;
            }
        }

        return $toReturn;
    }

    /**
     * Load an instance of IHttpExecutor based on installed
     * PHP extensions and/or available functions
     *
     * @static
     * @access private
     * @return IHttpExecutor|null
     */
    private static function _setExecutor()
    {
        /**
         * IHttpExecutor implementation
         *
         * @var IHttpExecutor|null
         */
        $implementation = null;

        if (self::_checkCurlImplementation()) {
            $implementation = new HttpCurlExecutor();
        } else if (self::_checkPeclImplementation()) {
            $implementation = new HttpPeclExecutor();
        } else if (self::_checkStreamImplementation()) {
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
    private static function _checkCurlImplementation()
    {
        /**
         * Conditional
         *
         * @var bool
         */
        $toReturn = true;

        foreach (HttpCurlExecutor::EXPECTED_EXTENSIONS as $extension) {
            if (!extension_loaded($extension)) {
                $toReturn = false;
                break;
            }
        }

        foreach (HttpCurlExecutor::EXPECTED_FUNCTIONS as $function) {
            if (!function_exists($function)) {
                $toReturn = false;
                break;
            }
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
    private static function _checkPeclImplementation()
    {
        /**
         * Conditional
         *
         * @var bool
         */
        $toReturn = true;

        foreach (HttpPeclExecutor::EXPECTED_EXTENSIONS as $extension) {
            if (!extension_loaded($extension)) {
                $toReturn = false;
                break;
            }
        }

        foreach (HttpPeclExecutor::EXPECTED_FUNCTIONS as $function) {
            if (!function_exists($function)) {
                $toReturn = false;
                break;
            }
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
    private static function _checkStreamImplementation()
    {
        /**
         * Conditional
         *
         * @var bool
         */
        $toReturn = true;

        foreach (HttpStreamExecutor::EXPECTED_EXTENSIONS as $extension) {
            if (!extension_loaded($extension)) {
                $toReturn = false;
                break;
            }
        }

        foreach (HttpStreamExecutor::EXPECTED_FUNCTIONS as $function) {
            if (!function_exists($function)) {
                $toReturn = false;
                break;
            }
        }

        return $toReturn;
    }
}
