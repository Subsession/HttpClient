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

namespace Comertis\Http\Exceptions;

/**
 * Custom exception interface
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
interface IHttpException
{
    /**
     * Exception message
     *
     * @access public
     * @return string
     */
    public function getMessage();

    /**
     * User-defined Exception code
     *
     * @access public
     * @return integer|string
     */
    public function getCode();

    /**
     * Source filename
     *
     * @access public
     * @return string
     */
    public function getFile();

    /**
     * Source line
     *
     * @access public
     * @return integer|string
     */
    public function getLine();

    /**
     * An array of the backtrace()
     *
     * @access public
     * @return array
     */
    public function getTrace();

    /**
     * Formated string of trace
     *
     * @return string
     */
    public function getTraceAsString();

    /**
     * Formated string for display
     *
     * @return string
     */
    public function __toString();

    /**
     * Constructor
     *
     * @param string  $message Exception message
     * @param integer $code    Exception code
     */
    public function __construct($message = null, $code = 0);
}
