<?php

/**
 * PHP Version 7
 *
 * LICENSE:
 * See the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Subsession
 *
 * @author Cristian Moraru <cristian.moraru@live.com>
 */

namespace Subsession\Http\Extensions;

use Subsession\Http\HttpStatusCode;

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian.moraru@live.com>
 */
trait StatusCode
{
    /**
     * Response HTTP status code
     *
     * @access private
     * @var    int
     */
    private $statusCode;

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
     * Flag indicating that the response is in the 1xx status range
     *
     * @access public
     * @return boolean
     */
    public function isInformational()
    {
        return isset(HttpStatusCode::INFORMATIONAL[$this->getStatusCode()]);
    }

    /**
     * Flag indicating that the response is in the 2xx status range
     *
     * @access public
     * @return boolean
     */
    public function isSuccess()
    {
        return isset(HttpStatusCode::SUCCESS[$this->getStatusCode()]);
    }

    /**
     * Flag indicating that the response is in the 3xx status range
     *
     * @access public
     * @return boolean
     */
    public function isRedirect()
    {
        return isset(HttpStatusCode::REDIRECTION[$this->getStatusCode()]);
    }

    /**
     * Flag indicating that the response is in the 4xx status range
     *
     * @access public
     * @return boolean
     */
    public function isClientError()
    {
        return isset(HttpStatusCode::CLIENT_ERRORS[$this->getStatusCode()]);
    }

    /**
     * Flag indicating that the response is in the 5xx status range
     *
     * @access public
     * @return boolean
     */
    public function isServerError()
    {
        return isset(HttpStatusCode::SERVER_ERRORS[$this->getStatusCode()]);
    }
}
