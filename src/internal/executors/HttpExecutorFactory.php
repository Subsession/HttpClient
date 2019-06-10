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
 * @link     https://github.com/Comertis/HttpClient
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
 * @uses Comertis\Http\Exceptions\HttpExecutorException
 * @uses Comertis\Http\Internal\Executors\HttpCurlExecutor
 * @uses Comertis\Http\Internal\Executors\HttpPeclExecutor
 * @uses Comertis\Http\Internal\Executors\HttpStreamExecutor
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
class HttpExecutorFactory
{
    /**
     * Create an instance of a IHttpExecutor based on loaded extensions
     * and/or available functions
     *
     * @param string|array $implementation Explicit IHttpExecutor implementation
     *
     * @static
     * @access public
     * @throws HttpExecutorException
     * @return IHttpExecutor
     */
    public static function build($implementation = null)
    {
        $executor = null;

        if (!is_null($implementation)) {
            $executor = self::getExplicitExecutor($implementation);
        } else {
            $executor = self::getExecutor();
        }

        if (is_null($executor)) {
            $message = "Failed to create an executor, missing necessary extensions/functions";
            throw new HttpExecutorException($message);
        }

        return $executor;
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
        $executor = null;

        if (is_array($implementation)) {
            foreach ($implementation as $key => $value) {

                // Recursive call until one executor implementation is returned
                $executor = self::getExplicitExecutor($value);

                if (!is_null($executor)) {
                    return $executor;
                }
            }
        }

        switch ($implementation) {
            case HttpCurlExecutor::class:
                if (self::_checkCurlImplementation()) {
                    $executor = new HttpCurlExecutor();
                }
                break;

            case HttpPeclExecutor::class:
                if (self::_checkPeclImplementation()) {
                    $executor = new HttpPeclExecutor();
                }
                break;

            case HttpStreamExecutor::class:
                if (self::_checkStreamImplementation()) {
                    $executor = new HttpStreamExecutor();
                }
                break;
            default:
                break;
        }

        return $executor;
    }

    /**
     * ATTENTION: Do NOT use this method to generate a IHttpExecutor
     * instance, use HttpExecutorFactory::build() instead
     *
     * Load an instance of IHttpExecutor based on installed
     * PHP extensions and/or available functions
     *
     * @static
     * @access public
     * @see    HttpExecutorFactory::build()
     * @return IHttpExecutor|null
     */
    public static function getExecutor()
    {
        /**
         * IHttpExecutor implementation
         *
         * @var IHttpExecutor|null
         */
        $executor = null;

        if (self::_checkCurlImplementation()) {
            $executor = new HttpCurlExecutor();
        } else if (self::_checkPeclImplementation()) {
            $executor = new HttpPeclExecutor();
        } else if (self::_checkStreamImplementation()) {
            $executor = new HttpStreamExecutor();
        }

        return $executor;
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
