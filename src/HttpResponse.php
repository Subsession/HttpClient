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

namespace Comertis\Http;

use Comertis\Http\HttpStatusCode;
use Comertis\Http\Internal\HttpResponseInterface;

/**
 * Undocumented class
 *
 * @uses Comertis\Http\HttpStatusCode
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
class HttpResponse implements HttpResponseInterface
{
    /**
     * Response headers
     *
     * @access private
     * @var    array
     */
    private $headers;

    /**
     * Response HTTP status code
     *
     * @access private
     * @var    integer
     */
    private $statusCode;

    /**
     * Response body
     *
     * @access private
     * @var    mixed
     */
    private $body;

    /**
     * Response error message
     *
     * @access private
     * @var    string
     */
    private $error;

    /**
     * HttpResponse instance for HttpClient
     *
     * @param array        $headers    Response headers
     * @param integer      $statusCode Response status code
     * @param mixed|string $body       Response body
     */
    public function __construct($headers = [], $statusCode = null, $body = null)
    {
        if (is_null($statusCode)) {
            $statusCode = HttpStatusCode::OK;
        }

        $this->headers = $headers;
        $this->statusCode = $statusCode;
        $this->body = $body;
    }

    /**
     * Get the response headers
     *
     * @access public
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set the response headers
     *
     * @param array $headers Response headers
     *
     * @access public
     * @return self
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Get the response status code
     *
     * @access public
     * @return integer
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the response status code
     *
     * @param integer $statusCode Status code
     *
     * @access public
     * @see    HttpStatusCode
     * @return self
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Get the response body
     *
     * @access public
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the response body
     *
     * @param string|mixed $body Response body
     *
     * @access public
     * @return self
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get the response error
     *
     * @access public
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set the response error
     *
     * @param integer $error Error message
     *
     * @access public
     * @return self
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Flag indicating that the response is in the 1xx status range
     *
     * @access public
     * @return boolean
     */
    public function isInformational()
    {
        return in_array($this->getStatusCode(), HttpStatusCode::INFORMATIONAL);
    }

    /**
     * Flag indicating that the response is in the 2xx status range
     *
     * @access public
     * @return boolean
     */
    public function isSuccess()
    {
        return in_array($this->getStatusCode(), HttpStatusCode::SUCCESS);
    }

    /**
     * Flag indicating that the response is in the 3xx status range
     *
     * @access public
     * @return boolean
     */
    public function isRedirect()
    {
        return in_array($this->getStatusCode(), HttpStatusCode::REDIRECTION);
    }

    /**
     * Flag indicating that the response is in the 4xx status range
     *
     * @access public
     * @return boolean
     */
    public function isClientError()
    {
        return in_array($this->getStatusCode(), HttpStatusCode::CLIENT_ERRORS);
    }

    /**
     * Flag indicating that the response is in the 5xx status range
     *
     * @access public
     * @return boolean
     */
    public function isServerError()
    {
        return in_array($this->getStatusCode(), HttpStatusCode::SERVER_ERRORS);
    }
}
