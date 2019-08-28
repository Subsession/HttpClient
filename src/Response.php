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
    use \Comertis\Http\Extensions\StatusCode;
    use \Comertis\Http\Extensions\Error;

    /**
     * Response instance for HttpClient
     *
     * @param array        $headers    Response headers
     * @param int          $statusCode Response status code
     * @param mixed|string $body       Response body
     */
    public function __construct($headers = [], $statusCode = null, $body = null)
    {
        if (null === $statusCode) {
            $statusCode = HttpStatusCode::OK;
        }

        $this->headers = $headers;
        $this->statusCode = $statusCode;
        $this->body = $body;
    }
}
