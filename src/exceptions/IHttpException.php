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

namespace Comertis\Http\Exceptions;

/**
 * Custom exception interface
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
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
