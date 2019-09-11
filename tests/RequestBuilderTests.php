<?php

namespace Comertis\Http\Tests;

use Comertis\Http\Builders\RequestBuilder;
use Comertis\Http\Request;
use Comertis\Http\Tests\Mocks\MockRequest;
use PHPUnit\Framework\TestCase;

class RequestBuilderTests extends TestCase
{
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
        // Set the RequestInterface implementation class to use
        // This is important as it needs to be honored until the
        // execution ends.
        RequestBuilder::setImplementation(MockRequest::class);

        $url = "test";
        $headers = [
            "header1" => "value1"
        ];
        $method = "POST";
        $bodyType = "application/json";
        $params = [
            "param1" => "value1"
        ];

        $request = RequestBuilder::getInstance()
            ->withUrl($url)
            ->withHeaders($headers)
            ->withMethod($method)
            ->withBodyType($bodyType)
            ->withParams($params)
            ->build();

        $this->assertInstanceOf(
            MockRequest::class,
            $request
        );

        $this->assertEquals(
            $url,
            $request->getUrl()
        );

        $this->assertEquals(
            $headers,
            $request->getHeaders()
        );

        $this->assertEquals(
            $method,
            $request->getMethod()
        );

        $this->assertEquals(
            $bodyType,
            $request->getBodyType()
        );

        $this->assertEquals(
            $params,
            $request->getParams()
        );

        // Make sure that `RequestBuilder::setImplementation(MockRequest::class);`
        // is still honored
        $request = RequestBuilder::getInstance()->build();

        $this->assertInstanceOf(
            MockRequest::class,
            $request
        );
    }

    public function testExpectRequestImplementationToBeRequestInstance()
    {
        // Set the RequestInterface implementation class to use
        // This is important as it needs to be honored until the
        // execution ends.
        RequestBuilder::setImplementation(Request::class);

        $url = "test";
        $headers = [];
        $method = "POST";
        $bodyType = "application/json";

        $request = RequestBuilder::getInstance()
            ->withUrl($url)
            ->withHeaders($headers)
            ->withMethod($method)
            ->withBodyType($bodyType)
            ->build();

        $this->assertInstanceOf(
            Request::class,
            $request
        );

        $this->assertEquals(
            $url,
            $request->getUrl()
        );

        $this->assertEquals(
            $headers,
            $request->getHeaders()
        );

        $this->assertEquals(
            $method,
            $request->getMethod()
        );

        $this->assertEquals(
            $bodyType,
            $request->getBodyType()
        );

        // Make sure that `RequestBuilder::setImplementation(Request::class);`
        // is still honored
        $request = RequestBuilder::getInstance()->build();

        $this->assertInstanceOf(
            Request::class,
            $request
        );
    }
}
