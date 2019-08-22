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

namespace Comertis\Http\Extensions;

use Comertis\Http\Abstraction\HttpResponseInterface;
use Comertis\Http\HttpRequestMethod;
use Comertis\Http\HttpRequestType;

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
trait HttpClientRequestJsonExtensions
{
    /**
     * Execute a POST request with JSON formatted parameters
     *
     * @param array|mixed|object $params Parameters to include in the request
     *
     * @access public
     * @return HttpResponseInterface
     */
    public function postJson($params = [])
    {
        $this->request
            ->setMethod(HttpRequestMethod::POST)
            ->setBodyType(HttpRequestType::JSON)
            ->setParams($params);

        return $this->handle($this->request);
    }

    /**
     * Execute a PUT request with JSON formatted parameters
     *
     * @param array|mixed|object $params Parameters to be json encoded
     *
     * @access public
     * @return HttpResponseInterface
     */
    public function putJson($params = [])
    {
        $this->request
            ->setMethod(HttpRequestMethod::PUT)
            ->setBodyType(HttpRequestType::JSON)
            ->setParams($params);

        return $this->handle($this->request);
    }

    /**
     * Execute a DELETE request with JSON encoded parameters
     *
     * @param array $params Parameters to be json encoded
     *
     * @access public
     * @return HttpResponseInterface
     */
    public function deleteJson($params = [])
    {
        $this->request
            ->setMethod(HttpRequestMethod::DELETE)
            ->setBodyType(HttpRequestType::JSON)
            ->setParams($params);

        return $this->handle($this->request);
    }
}
