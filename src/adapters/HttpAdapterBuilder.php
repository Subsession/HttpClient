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
use Comertis\Http\Exceptions\HttpAdapterException;

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
     * @throws HttpAdapterException
     * @return HttpAdapterInterface
     */
    public static function build($implementation = null)
    {
        $adapter = null;

        if (!is_null($implementation)) {
            $adapter = self::getAdapter($implementation);
        } else {
            $adapter = self::getExecutor();
        }

        if (is_null($adapter)) {
            $message = "Failed to create an adapter, missing necessary extensions/functions";
            throw new HttpAdapterException($message);
        }

        return $adapter;
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
    public static function getAdapter($implementation)
    {
        if (is_array($implementation)) {
            foreach ($implementation as $key => $value) {
                // Recursive call until one executor implementation is returned
                return self::getAdapter($value);
            }
        }

        switch ($implementation) {
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
