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

    /**
     * @covers ResponseBuilder::setImplementation
     * @covers ResponseBuilder::getInstance
     * @covers ResponseBuilder::withStatusCode
     * @covers MockResponse::setStatusCode
     * @covers ResponseBuilder::withHeaders
     * @covers MockResponse::setHeaders
     * @covers ResponseBuilder::withBody
     * @covers MockResponse::setBody
     * @covers ResponseBuilder::build
     *
     * @covers MockResponse::getStatusCode
     * @covers MockResponse::getHeaders
     * @covers MockResponse::getBody
     *
     * @return void
     */
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

    /**
     * @covers ResponseBuilder::setImplementation
     * @covers ResponseBuilder::getInstance
     * @covers ResponseBuilder::withStatusCode
     * @covers Response::setStatusCode
     * @covers ResponseBuilder::withHeaders
     * @covers Response::setHeaders
     * @covers ResponseBuilder::withBody
     * @covers Response::setBody
     * @covers ResponseBuilder::build
     *
     * @covers Response::getStatusCode
     * @covers Response::getHeaders
     * @covers Response::getBody
     *
     * @return void
     */
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
