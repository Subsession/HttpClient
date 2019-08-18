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

namespace Comertis\Http\Adapters;

use Comertis\Http\Adapters\HttpCurlAdapter;
use Comertis\Http\Adapters\HttpPeclAdapter;
use Comertis\Http\Adapters\HttpStreamAdapter;
use Comertis\Http\Exceptions\HttpExecutorException;

/**
 * Undocumented class
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
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
     * @throws HttpExecutorException
     * @return HttpAdapterInterface
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
     * Create an explicit implementation of HttpAdapterInterface
     *
     * @param string|array $implementation Executor implementation
     *
     * @static
     * @access public
     * @return HttpAdapterInterface|null
     */
    public static function getExplicitExecutor($implementation)
    {
        /**
         * Implementation of HttpAdapterInterface
         *
         * @var HttpAdapterInterface|null
         */
        $adapter = null;

        if (is_array($implementation)) {
            foreach ($implementation as $key => $value) {
                // Recursive call until one executor implementation is returned
                $adapter = self::getExplicitExecutor($value);

                if (!is_null($adapter)) {
                    return $adapter;
                }
            }
        }

        switch ($implementation) {
            case HttpCurlAdapter::class:
                if (self::checkCurlImplementation()) {
                    $adapter = new HttpCurlAdapter();
                }
                break;

            case HttpPeclAdapter::class:
                if (self::checkPeclImplementation()) {
                    $adapter = new HttpPeclAdapter();
                }
                break;

            case HttpStreamAdapter::class:
                if (self::checkStreamImplementation()) {
                    $adapter = new HttpStreamAdapter();
                }
                break;
            default:
                break;
        }

        return $adapter;
    }

    /**
     * ATTENTION: Do NOT use this method to generate a HttpAdapterInterface
     * instance, use HttpExecutorFactory::build() instead
     *
     * Load an instance of HttpAdapterInterface based on installed
     * PHP extensions and/or available functions
     *
     * @static
     * @access public
     * @see    HttpExecutorFactory::build()
     * @return HttpAdapterInterface|null
     */
    public static function getExecutor()
    {
        /**
         * HttpAdapterInterface implementation
         *
         * @var HttpAdapterInterface|null
         */
        $executor = null;

        if (self::checkCurlImplementation()) {
            $executor = new HttpCurlAdapter();
        } elseif (self::checkPeclImplementation()) {
            $executor = new HttpPeclAdapter();
        } elseif (self::checkStreamImplementation()) {
            $executor = new HttpStreamAdapter();
        }

        return $executor;
    }

    /**
     * Check the requirements for the HttpCurlAdapter
     *
     * @static
     * @access private
     * @return bool
     */
    private static function checkCurlImplementation()
    {
        /**
         * Conditional
         *
         * @var bool
         */
        $toReturn = true;

        foreach (HttpCurlAdapter::EXPECTED_EXTENSIONS as $extension) {
            if (!extension_loaded($extension)) {
                $toReturn = false;
                break;
            }
        }

        foreach (HttpCurlAdapter::EXPECTED_FUNCTIONS as $function) {
            if (!function_exists($function)) {
                $toReturn = false;
                break;
            }
        }

        return $toReturn;
    }

    /**
     * Check the requirements for HttpPeclAdapter
     *
     * @static
     * @access private
     * @return bool
     */
    private static function checkPeclImplementation()
    {
        /**
         * Conditional
         *
         * @var bool
         */
        $toReturn = true;

        foreach (HttpPeclAdapter::EXPECTED_EXTENSIONS as $extension) {
            if (!extension_loaded($extension)) {
                $toReturn = false;
                break;
            }
        }

        foreach (HttpPeclAdapter::EXPECTED_FUNCTIONS as $function) {
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
    private static function checkStreamImplementation()
    {
        /**
         * Conditional
         *
         * @var bool
         */
        $toReturn = true;

        foreach (HttpStreamAdapter::EXPECTED_EXTENSIONS as $extension) {
            if (!extension_loaded($extension)) {
                $toReturn = false;
                break;
            }
        }

        foreach (HttpStreamAdapter::EXPECTED_FUNCTIONS as $function) {
            if (!function_exists($function)) {
                $toReturn = false;
                break;
            }
        }

        return $toReturn;
    }
}
