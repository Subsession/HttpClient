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

use Comertis\Http\Adapters\AbstractAdapter;
use Comertis\Http\Exceptions\HttpNotImplementedException;
use Comertis\Http\Internal\HttpRequestInterface;

/**
 * Undocumented class
 *
 * @uses Comertis\Http\Exceptions\HttpNotImplementedException
 * @uses Comertis\Http\HttpRequest
 * @uses Comertis\Http\Adapters\HttpAdapterInterface
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
class HttpPeclAdapter extends AbstractAdapter
{

    /**
     * Expected extensions for this HttpAdapterInterface implementation
     * to work properly
     *
     * @access public
     * @var    array
     */
    const EXPECTED_EXTENSIONS = [

    ];

    /**
     * Expected functions for this HttpAdapterInterface implementation
     * to work properly
     *
     * @access public
     * @var    array
     */
    const EXPECTED_FUNCTIONS = [

    ];

    /**
     * @inheritDoc
     * @throws     HttpNotImplementedException
     */
    public function prepareUrl(HttpRequestInterface &$request)
    {
        throw new HttpNotImplementedException("This function is not yet implemented");
    }

    /**
     * @inheritDoc
     * @throws     HttpNotImplementedException
     */
    public function prepareHeaders(HttpRequestInterface &$request)
    {
        throw new HttpNotImplementedException();
    }

    /**
     * @inheritDoc
     * @throws     HttpNotImplementedException
     */
    public function prepareParams(HttpRequestInterface &$request)
    {
        throw new HttpNotImplementedException();
    }

    /**
     * @inheritDoc
     * @throws     HttpNotImplementedException
     */
    public function execute(HttpRequestInterface $request)
    {
        throw new HttpNotImplementedException();
    }
}
