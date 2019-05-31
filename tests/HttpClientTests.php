<?php

namespace Comertis\Http\Tests;

use Comertis\Http\HttpClient;
use Comertis\Http\HttpStatusCode;
use PHPUnit\Framework\TestCase;

final class HttpClientTests extends TestCase
{
    private $_httpClient;

    const BASE_URL = "http://jsonplaceholder.typicode.com/";

    public function __construct()
    {
        $this->_httpClient = new HttpClient();
    }

    public function testExpect200Response()
    {
        $response = $this->_httpClient
            ->setUrl(self::BASE_URL . "posts/1")
            ->get();

        $this->assertEqual(
            HttpStatusCode::OK,
            $response->getStatusCode()
        );

        $this->assertNotEmpty(
            $response->getBody()
        );
    }

    public function testExpect404Response()
    {
        $response = $this->_httpClient
            ->setUrl(self::BASE_URL . "post/222222")
            ->get();

        $this->assertEqual(
            HttpStatusCode::NOT_FOUND,
            $response->getStatusCode()
        );
    }

    public function testExpectResponseBodyToHaveContent()
    {
        $response = $this->_httpClient
            ->setUrl(self::BASE_URL . "posts/1")
            ->get();

        $this->assertEquals(
            HttpStatusCode::OK,
            $response->getStatusCode()
        );

        $this->assertNotEmpty(
            $response->getBody()
        );
    }

    public function testExpectResponseBodyToBeEmpty()
    {
        $response = $this->_httpClient
            ->setUrl(self::BASE_URL . "posts/2222")
            ->get();

        $this->assertEquals(
            HttpStatusCode::NOT_FOUND,
            $response->getStatusCode()
        );

        $this->assertEqual(
            '{}',
            $response->getBody()
        );
    }

    public function testExpectResponseHeadersToContainContentTypeApplicationJson()
    {
        $contentType = "Content-Type";
        $applicationJson = "application/json; charset=utf-8";

        $response = $this->_httpClient
            ->setUrl(self::BASE_URL . "posts/1")
            ->get();

        $responseHeaders = $response->getHeaders();

        $this->assertArrayHasKey(
            $contentType,
            $responseHeaders
        );

        $this->assertEquals(
            $responseHeaders[$contentType],
            $applicationJson
        );
    }
}
