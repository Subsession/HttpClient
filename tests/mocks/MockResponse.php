<?php

namespace Comertis\Http\Tests\Mocks;

use Comertis\Http\Abstraction\ResponseInterface;
use Comertis\Http\HttpStatusCode;

class MockResponse implements ResponseInterface
{
    use \Comertis\Http\Extensions\StatusCode;
    use \Comertis\Http\Extensions\Headers;
    use \Comertis\Http\Extensions\Body;
    use \Comertis\Http\Extensions\Error;

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
