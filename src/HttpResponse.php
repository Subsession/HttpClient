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
class HttpResponse
{
    /**
     * Response headers
     *
     * @access private
     * @var    array
     */
    private $_headers;

    /**
     * Response HTTP status code
     *
     * @access private
     * @var    integer
     */
    private $_statusCode;

    /**
     * Response body
     *
     * @access private
     * @var    mixed
     */
    private $_body;

    /**
     * Total transaction time in seconds for last transfer
     *
     * @access private
     * @var    integer
     */
    private $_transactionTime;

    /**
     * Average download speed
     *
     * @access private
     * @var    string
     */
    private $_downloadSpeed;

    /**
     * Average upload speed
     *
     * @access private
     * @var    string
     */
    private $_uploadSpeed;

    /**
     * Total size of all headers received
     *
     * @access private
     * @var    string
     */
    private $_headerSize;

    /**
     * Response error message
     *
     * @access private
     * @var    string
     */
    private $_error;

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

        $this->_headers = $headers;
        $this->_statusCode = $statusCode;
        $this->_body = $body;
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
     * Get the response headers
     *
     * @access public
     * @return array
     */
    public function getHeaders()
    {
        return $this->_headers;
    }

    /**
     * Set the response headers
     *
     * @param array $headers Response headers
     *
     * @access public
     * @return HttpResponse
     */
    public function setHeaders($headers)
    {
        $this->_headers = $headers;

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
        return $this->_statusCode;
    }

    /**
     * Set the response status code
     *
     * @param integer $statusCode Status code
     *
     * @access public
     * @see    HttpStatusCode
     * @return HttpResponse
     */
    public function setStatusCode($statusCode)
    {
        $this->_statusCode = $statusCode;

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
        return $this->_body;
    }

    /**
     * Set the response body
     *
     * @param string|mixed $body Response body
     *
     * @access public
     * @return HttpResponse
     */
    public function setBody($body)
    {
        $this->_body = $body;

        return $this;
    }

    /**
     * Total transaction time in seconds
     *
     * @access public
     * @return integer
     */
    public function getTransactionTime()
    {
        return $this->_transactionTime;
    }

    /**
     * Total transaction time in seconds
     *
     * @param integer $time Transaction time in seconds
     *
     * @access public
     * @return HttpResponse
     */
    public function setTransactionTime($time)
    {
        $this->_transactionTime = $time;

        return $this;
    }

    /**
     * Get the average download speed
     *
     * @access public
     * @return string
     */
    public function getDownloadSpeed()
    {
        return $this->_downloadSpeed;
    }

    /**
     * Set the average download speed
     *
     * @param string $downloadSpeed Download speed
     *
     * @access public
     * @return HttpResponse
     */
    public function setDownloadSpeed($downloadSpeed)
    {
        $this->_downloadSpeed = $downloadSpeed;

        return $this;
    }

    /**
     * Get the average upload speed
     *
     * @access public
     * @return string
     */
    public function getUploadSpeed()
    {
        return $this->_uploadSpeed;
    }

    /**
     * Set the average upload speed
     *
     * @param string $uploadSpeed Upload speed
     *
     * @access public
     * @return HttpResponse
     */
    public function setUploadSpeed($uploadSpeed)
    {
        $this->_uploadSpeed = $uploadSpeed;

        return $this;
    }

    /**
     * Get the total size of all headers received
     *
     * @access public
     * @return string
     */
    public function getHeaderSize()
    {
        return $this->_headerSize;
    }

    /**
     * Set the total size of all headers received
     *
     * @param string $headerSize Header size
     *
     * @access public
     * @return HttpResponse
     */
    public function setHeadersSize($headerSize)
    {
        $this->_headerSize = $headerSize;

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
        return $this->_error;
    }

    /**
     * Set the response error
     *
     * @param integer $error Error message
     *
     * @access public
     * @return HttpResponse
     */
    public function setError($error)
    {
        $this->_error = $error;

        return $this;
    }
}
