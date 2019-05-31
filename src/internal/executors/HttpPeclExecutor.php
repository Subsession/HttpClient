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

require_once __DIR__ . '/../IHttpExecutor.php';

use Comertis\Http\Exceptions\HttpNotImplementedException;
use Comertis\Http\HttpRequest;
use Comertis\Http\Internal\IHttpExecutor;

/**
 * Undocumented class
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/Cache
 */
class HttpPeclExecutor implements IHttpExecutor
{

    /**
     * Expected extensions for this IHttpExecutor implementation
     * to work properly
     *
     * @access public
     * @var    array
     */
    const EXPECTED_EXTENSIONS = [

    ];

    /**
     * Expected functions for this IHttpExecutor implementation
     * to work properly
     *
     * @access public
     * @var    array
     */
    const EXPECTED_FUNCTIONS = [

    ];

    /**
     * Prepare the request URL
     *
     * @param HttpRequest $request HttpRequest instance, passed by reference
     *
     * @access public
     * @see    IHttpExecutor::prepareUrl()
     * @throws HttpNotImplementedException
     * @return void
     */
    public function prepareUrl(HttpRequest &$request)
    {
        throw new HttpNotImplementedException("This function is not yet implemented");
    }

    /**
     * Prepare the request headers
     *
     * @param HttpRequest $request HttpRequest instance, passed by reference
     *
     * @access public
     * @see    IHttpExecutor::prepareHeaders()
     * @throws HttpNotImplementedException
     * @return void
     */
    public function prepareHeaders(HttpRequest &$request)
    {
        throw new HttpNotImplementedException();
    }

    /**
     * Prepare the request parameters
     *
     * @param HttpRequest $request HttpRequest instance, passed by reference
     *
     * @access public
     * @see    IHttpExecutor::prepareParams()
     * @throws HttpNotImplementedException
     * @return void
     */
    public function prepareParams(HttpRequest &$request)
    {
        throw new HttpNotImplementedException();
    }

    /**
     * Execute the request
     *
     * @param HttpRequest $request HttpRequest instance to execute
     *
     * @access private
     * @see    IHttpExecutor::execute()
     * @throws HttpNotImplementedException
     * @return HttpResult
     */
    public function execute(HttpRequest $request)
    {
        throw new HttpNotImplementedException();
    }
}
