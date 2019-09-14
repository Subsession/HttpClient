<?php
/**
 * PHP Version 7
 *
 * LICENSE:
 * Proprietary, see the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Subsession
 *
 * @category Http
 * @package  Subsession\Http
 * @author   Cristian Moraru <cristian.moraru@live.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  GIT: &Id&
 * @link     https://github.com/Subsession/HttpClient
 */

namespace Subsession\Http\Extensions;

use Subsession\Http\HttpStatusCode;

/**
 * Undocumented class
 *
 * @category Http
 * @package  Subsession\Http
 * @author   Cristian Moraru <cristian.moraru@live.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Subsession/HttpClient
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
        return (int) $this->statusCode;
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
