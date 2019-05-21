<?php

namespace Comertis\Http;

class HttpResponse
{
    /**
     * Response headers
     *
     * @access private
     * @var array
     */
    private $_headers;

    /**
     * Response HTTP status code
     *
     * @access private
     * @var int
     */
    private $_statusCode;

    /**
     * Response body
     *
     * @access private
     * @var mixed
     */
    private $_body;

    /**
     * Total transaction time in seconds for last transfer
     *
     * @access private
     * @var int
     */
    private $_transactionTime;

    /**
     * Average download speed
     *
     * @access private
     * @var string
     */
    private $_downloadSpeed;

    /**
     * Average upload speed
     *
     * @access private
     * @var string
     */
    private $_uploadSpeed;

    /**
     * Total size of all headers received
     *
     * @access private
     * @var string
     */
    private $_headerSize;

    /**
     * Response error message
     *
     * @access private
     * @var string
     */
    private $_error;

    /**
     * HttpResponse instance for HttpClient
     *
     * @param array $headers
     * @param int $statusCode
     * @param mixed|string $body
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

    public function __destruct()
    {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    /**
     * Get the HTTP response headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->_headers;
    }

    /**
     * Set the HTTP response headers
     *
     * @param array $headers
     *
     * @return HttpResponse
     */
    public function setHeaders($headers)
    {
        $this->_headers = $headers;

        return $this;
    }

    /**
     * Get the HTTP response status code
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->_statusCode;
    }

    /**
     * Set the HTTP response status code
     *
     * @param int $statusCode
     *
     * @return HttpResponse
     */
    public function setStatusCode($statusCode)
    {
        $this->_statusCode = $statusCode;

        return $this;
    }

    /**
     * Get the HTTP response body
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->_body;
    }

    /**
     * Set the HTTP response body
     *
     * @param string|mixed $body
     *
     * @return mixed
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
     * @return int
     */
    public function getTransactionTime()
    {
        return $this->_transactionTime;
    }

    /**
     * Total transaction time in seconds
     *
     * @param int $time
     * @access public
     * @return HttpResponse
     */
    public function setTransactionTime($time)
    {
        $this->_transactionTime = $time;

        return $this;
    }

    /**
     * Average download speed
     *
     * @access public
     * @return string
     */
    public function getDownloadSpeed()
    {
        return $this->_downloadSpeed;
    }

    /**
     * Average download speed
     *
     * @param string $downloadSpeed
     * @access public
     * @return HttpResponse
     */
    public function setDownloadSpeed($downloadSpeed)
    {
        $this->_downloadSpeed = $downloadSpeed;

        return $this;
    }

    /**
     * Average upload speed
     *
     * @access public
     * @return string
     */
    public function getUploadSpeed()
    {
        return $this->_uploadSpeed;
    }

    /**
     * Average upload speed
     *
     * @param string $uploadSpeed
     * @access public
     * @return HttpResponse
     */
    public function setUploadSpeed($uploadSpeed)
    {
        $this->_uploadSpeed = $uploadSpeed;

        return $this;
    }

    /**
     * Total size of all headers received
     *
     * @access public
     * @return string
     */
    public function getHeaderSize()
    {
        return $this->_headerSize;
    }

    /**
     * Total size of all headers received
     *
     * @param string $headerSize
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
     * @param int $error
     * @access public
     * @return HttpResponse
     */
    public function setError($error)
    {
        $this->_error = $error;

        return $this;
    }
}
