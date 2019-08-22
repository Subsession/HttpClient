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

use Comertis\Http\HttpRequest;

/**
 * Defines the minimum necessary for a HttpExecutor
 * implementation regardless of used library or extension
 *
 * @uses Comertis\Http\HttpRequest
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
interface HttpAdapterInterface
{
    /**
     * Make any necessary changes to the HttpRequest URL before executing
     *
     * @param HttpRequest $request HttpRequest instance, passed by reference
     *
     * @access public
     * @return void
     */
    public function prepareUrl(HttpRequest &$request);

    /**
     * Make any necessary changes to the HttpRequest headers before executing
     *
     * @param HttpRequest $request HttpRequest instance, passed by reference
     *
     * @access public
     * @return void
     */
    public function prepareHeaders(HttpRequest &$request);

    /**
     * Make any necessary changes to the HttpRequest parameters before executing
     *
     * @param HttpRequest $request HttpRequest instance, passed by reference
     *
     * @access public
     * @return void
     */
    public function prepareParams(HttpRequest &$request);

    /**
     * Get the configured retry count for requests
     *
     * @access public
     * @return integer
     */
    public function getRetryCount();

    /**
     * Set the number of times to retry a request
     * in case of failing to get a response
     *
     * @access public
     * @return integer
     */
    public function setRetryCount();

    /**
     * Checks if the adapter can be used
     *
     * @access public
     * @return boolean
     */
    public function isAvailable();

    /**
     * Execute the HttpRequest and return a HttpResponse
     *
     * @param HttpRequest $request HttpRequest instance
     *
     * @access public
     * @return HttpResponse
     */
    public function handle(HttpRequest $request);
}
