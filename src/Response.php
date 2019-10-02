<?php

/**
 * PHP Version 7
 *
 * LICENSE:
 * See the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Subsession
 *
 * @author Cristian Moraru <cristian@subsession.org>
 */

namespace Subsession\Http;

use JsonSerializable;

use Subsession\Http\{
    Abstraction\ResponseInterface,
    HttpStatusCode,
    Extensions as Extensions
};

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian@subsession.org>
 */
class Response implements ResponseInterface, JsonSerializable
{
    use Extensions\StatusCode;
    use Extensions\Headers;
    use Extensions\Body;
    use Extensions\Error;
    use Extensions\JsonSerializable;

    /**
     * Response instance for HttpClient
     *
     * @param int|null          $statusCode Response status code
     * @param array             $headers    Response headers
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
