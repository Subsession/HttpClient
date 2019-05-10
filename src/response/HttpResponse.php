<?php

namespace Comertis\Http;

class HttpResponse
{
    /**
     * Response headers
     *
     * @var array
     */
    private $_headers;

    /**
     * Response HTTP status code
     *
     * @var int
     */
    private $_statusCode;

    /**
     * Response body
     *
     * @var mixed
     */
    private $_body;

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
}
