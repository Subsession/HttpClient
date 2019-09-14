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

namespace Subsession\Http;

use Subsession\Http\Abstraction\ResponseInterface;
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
class Response implements ResponseInterface
{
    use \Subsession\Http\Extensions\StatusCode;
    use \Subsession\Http\Extensions\Headers;
    use \Subsession\Http\Extensions\Body;
    use \Subsession\Http\Extensions\Error;

    /**
     * Response instance for HttpClient
     *
     * @param array             $headers    Response headers
     * @param int|null          $statusCode Response status code
     * @param mixed|string|null $body       Response body
     * @param string|null       $error      Response error message
     */
    public function __construct($statusCode = null, $headers = [], $body = null, $error = null)
    {
        if (null === $statusCode) {
            $statusCode = HttpStatusCode::OK;
        }

        $this->headers = $headers;
        $this->statusCode = $statusCode;
        $this->body = $body;
        $this->error = $error;
    }

    /**
     * Override __toString()
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        $string = "";

        $string .= $this->getStatusCode() . PHP_EOL;
        $string .= PHP_EOL;

        foreach ($this->getHeaders() as $key => $value) {
            $string .= $key . ":" . $value . PHP_EOL;
        }
        $string .= PHP_EOL;

        $string .= $this->getBody() . PHP_EOL;
        $string .= PHP_EOL;

        if (null !== $this->getError()) {
            $string .= "Error:" . PHP_EOL;
            $string .= $this->getError() . PHP_EOL;
            $string .= PHP_EOL;
        }

        return $string;
    }
}
