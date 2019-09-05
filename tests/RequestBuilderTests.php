<?php

namespace Comertis\Http\Tests;

use Comertis\Http\Abstraction\RequestInterface;
use Comertis\Http\Builders\RequestBuilder;
use Comertis\Http\Request;
use Comertis\Http\Tests\Mocks\MockRequest;
use PHPUnit\Framework\TestCase;

class RequestBuilderTests extends TestCase
{
    /**
     * RequestInterface implementation instance
     *
     * @access private
     * @var RequestInterface
     */
    private $request;

    public function setUp()
    {
        //
    }

    public function tearDown()
    {
        //
    }

    public function testExpectRequestImplementationToBeMockRequestInstance()
    {
        RequestBuilder::setRequestClass(MockRequest::class);
        $request = RequestBuilder::getInstance()
            ->withUrl("test")
            ->withHeaders([])
            ->withMethod("POST")
            ->withBodyType("application/json")
            ->build();

        $this->assertInstanceOf(
            MockRequest::class,
            $request
        );

        // Make sure that `RequestBuilder::setRequestClass(MockRequest::class);`
        // is still honored
        $request = RequestBuilder::getInstance()->build();

        $this->assertInstanceOf(
            MockRequest::class,
            $request
        );
    }

    public function testExpectRequestImplementationToBeRequestInstance()
    {
        RequestBuilder::setRequestClass(Request::class);
        $request = RequestBuilder::getInstance()
            ->withBodyType("application/json")
            ->withMethod("POST")
            ->withUrl("test")
            ->withHeaders([])
            ->build();

        $this->assertInstanceOf(
            Request::class,
            $request
        );

        // Make sure that `RequestBuilder::setRequestClass(Request::class);`
        // is still honored
        $request = RequestBuilder::getInstance()->build();

        $this->assertInstanceOf(
            Request::class,
            $request
        );
    }
}
