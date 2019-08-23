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

use Comertis\Http\Exceptions\IHttpException;
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
class HttpClientException extends Exception implements IHttpException
{
    /**
     * Exception message
     *
     * @access protected
     * @var    string
     */
    protected $message = 'Unknown exception';

    /**
     * User-defined exception code
     *
     * @access protected
     * @var    integer
     */
    protected $code = 0;

    /**
     * Source filename of exception
     *
     * @access protected
     * @var    string
     */
    protected $file;

    /**
     * Source line of exception
     *
     * @access protected
     * @var    integer
     */
    protected $line;

    /**
     * Constructor
     *
     * @param string  $message Exception message
     * @param integer $code    Exception code
     */
    public function __construct($message = null, $code = 0)
    {
        if (!$message) {
            throw new $this('Unknown ' . get_class($this));
        }

        parent::__construct($message, $code);
    }

    /**
     * Override __toString()
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        return get_class($this) . "
            '{$this->message}' in {$this->file}({$this->line})\n"
            . "{$this->getTraceAsString()}";
    }
}
