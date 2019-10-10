<?php

namespace Subsession\Http\Tests\Unit\Builders;

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

        $this->assertSame(
            $statusCode,
            $response->getStatusCode()
        );

        $this->assertSame(
            $headers,
            $response->getHeaders()
        );

        $this->assertSame(
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

        $this->assertSame(
            $statusCode,
            $response->getStatusCode()
        );

        $this->assertSame(
            $headers,
            $response->getHeaders()
        );

        $this->assertSame(
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

    public function testExpectBuilderWithNoConfigToBuildDefaultInstance()
    {
        // Reset to default implementation
        ResponseBuilder::setImplementation(Response::class);

        $expected = new Response();
        $actual = ResponseBuilder::getInstance()->build();

        $this->assertEquals(
            $expected,
            $actual
        );
    }

    public function testExpectBuilderWithCustomConfigToBuildIdenticalInstanceAsClassConstructor()
    {
        ResponseBuilder::setImplementation(MockResponse::class);

        $expected = new MockResponse();
        $actual = ResponseBuilder::getInstance()->build();

        $this->assertEquals(
            $expected,
            $actual
        );
    }
}
