<?php
/**
 * PHP Version 7
 *
 * LICENSE:
 * Proprietary, see the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Comertis <info@comertis.com>
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
 * @version  GIT: &Id&
 * @link     https://github.com/Comertis/HttpClient
 */

namespace Comertis\Http;

use Comertis\Http\Abstraction\ResponseInterface;
use Comertis\Http\HttpStatusCode;

/**
 * Undocumented class
 *
 * @uses Comertis\Http\HttpStatusCode
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
class Response implements ResponseInterface
{
    use \Comertis\Http\Extensions\Headers;
    use \Comertis\Http\Extensions\Body;

    /**
     * Response HTTP status code
     *
     * @access private
     * @var    integer
     */
    private $statusCode;

    /**
     * Response error message
     *
     * @access private
     * @var    string
     */
    private $error;

    /**
     * Response instance for HttpClient
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
     * @return static
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

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
     * @return static
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
