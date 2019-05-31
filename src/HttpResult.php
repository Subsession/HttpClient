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

namespace Comertis\Http;

use Comertis\Http\HttpRequest;
use Comertis\Http\HttpResponse;

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
class HttpResult
{
    /**
     * Original HttpRequest
     *
     * @access private
     * @var    HttpRequest
     */
    private $_request;

    /**
     * HttpResponse
     *
     * @access private
     * @var    HttpResponse
     */
    private $_response;

    /**
     * Create a new HttpResult
     *
     * @param HttpRequest  $request  HttpRequest instance
     * @param HttpResponse $response HttpResponse instance
     */
    public function __construct(HttpRequest $request, HttpResponse $response)
    {
        $this->_request = $request;
        $this->_response = $response;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    /**
     * Get the original sent HttpRequest
     *
     * @access public
     * @return HttpRequest
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * Set the HttpRequest
     *
     * @param HttpRequest $request HttpRequest instance
     *
     * @access public
     * @return HttpResult
     */
    public function setRequest(HttpRequest $request)
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * Get the HttpResponse
     *
     * @access public
     * @return HttpResponse
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * Set the HttpResponse
     *
     * @param HttpResponse $response HttpResponse instance
     *
     * @access public
     * @return HttpResult
     */
    public function setResponse(HttpResponse $response)
    {
        $this->_response = $response;
        return $this;
    }
}
