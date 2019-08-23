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
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  GIT: &Id&
 * @link     https://github.com/Comertis/HttpClient
 */

namespace Comertis\Http\Exceptions;

use Exception;

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
class HttpNotImplementedException extends Exception
{
    /**
     * Constructor
     *
     * @param string    $message  Error message
     * @param integer   $code     Error code
     * @param Exception $previous Previous Exception
     */
    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        if (is_null($message) | empty($message)) {
            $message = "This function is not yet implemented";
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * __toString() override
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
