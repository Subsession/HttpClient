<?php

namespace Comertis\Http\Tests;

use Comertis\Http\Builders\ResponseBuilder;
use Comertis\Http\Response;
use Comertis\Http\Tests\Mocks\MockResponse;
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
        ResponseBuilder::setResponseClass(MockResponse::class);
        $response = ResponseBuilder::getInstance()
            ->withStatusCode(200)
            ->withHeaders([])
            ->withBody("")
            ->build();

        $this->assertInstanceOf(
            MockResponse::class,
            $response
        );

        // Make sure that `ResponseBuilder::setResponseClass(MockResponse::class);`
        // is still honored
        $response = ResponseBuilder::getInstance()
            ->build();

        $this->assertInstanceOf(
            MockResponse::class,
            $response
        );
    }

    public function testExpectResponseImplementationToBeResponseInstance()
    {
        ResponseBuilder::setResponseClass(Response::class);
        $response = ResponseBuilder::getInstance()
            ->withStatusCode(200)
            ->withHeaders([])
            ->withBody("")
            ->build();

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        // Make sure that `ResponseBuilder::setResponseClass(Response::class);`
        // is still honored
        $response = ResponseBuilder::getInstance()->build();

        $this->assertInstanceOf(
            Response::class,
            $response
        );
    }
}
