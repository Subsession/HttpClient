<?php

namespace Subsession\Http\Tests\Builders;

use Subsession\Http\Builders\ResponseBuilder;
use Subsession\Http\Response;
use Subsession\Http\Tests\Mocks\MockResponse;
use PHPUnit\Framework\TestCase;

class ResponseBuilderTests extends TestCase
{
    public function setUp()
    {
        //
    }

    public function tearDown()
    {
        //
    }

    public function testExpectResponseImplementationToBeMockResponseInstance()
    {
        // Set the ResponseInterface implementation class to use
        // This is important as it needs to be honored until the
        // execution ends.
        ResponseBuilder::setImplementation(MockResponse::class);

        $statusCode = 200;
        $headers = [];
        $body = "test";

        $response = ResponseBuilder::getInstance()
            ->withStatusCode($statusCode)
            ->withHeaders($headers)
            ->withBody($body)
            ->build();

        $this->assertInstanceOf(
            MockResponse::class,
            $response
        );

        $this->assertEquals(
            $statusCode,
            $response->getStatusCode()
        );

        $this->assertEquals(
            $headers,
            $response->getHeaders()
        );

        $this->assertEquals(
            $body,
            $response->getBody()
        );

        // Make sure that `ResponseBuilder::setImplementation(MockResponse::class);`
        // is still honored
        $response = ResponseBuilder::getInstance()->build();

        $this->assertInstanceOf(
            MockResponse::class,
            $response
        );
    }

    public function testExpectResponseImplementationToBeResponseInstance()
    {
        // Set the ResponseInterface implementation class to use
        // This is important as it needs to be honored until the
        // execution ends.
        ResponseBuilder::setImplementation(Response::class);

        $statusCode = 200;
        $headers = [];
        $body = "test";

        /** @var ResponseInterface $response */
        $response = ResponseBuilder::getInstance()
            ->withStatusCode($statusCode)
            ->withHeaders($headers)
            ->withBody($body)
            ->build();

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        $this->assertEquals(
            $statusCode,
            $response->getStatusCode()
        );

        $this->assertEquals(
            $headers,
            $response->getHeaders()
        );

        $this->assertEquals(
            $body,
            $response->getBody()
        );

        // Make sure that `ResponseBuilder::setImplementation(Response::class);`
        // is still honored
        $response = ResponseBuilder::getInstance()->build();

        $this->assertInstanceOf(
            Response::class,
            $response
        );
    }
}
