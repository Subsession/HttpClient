<?php

namespace Subsession\Http\Tests\Mocks;

use Subsession\Http\Abstraction\ResponseInterface;
use Subsession\Http\HttpStatusCode;

class MockResponse implements ResponseInterface
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
}
