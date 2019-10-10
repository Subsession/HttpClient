<?php

namespace Subsession\Http\Tests\Unit\Builders;

use Subsession\Http\Builders\RequestBuilder;
use Subsession\Http\Request;
use Subsession\Http\Tests\Mocks\MockRequest;
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

        $this->assertSame(
            $url,
            $request->getUrl()
        );

        $this->assertSame(
            $headers,
            $request->getHeaders()
        );

        $this->assertSame(
            $method,
            $request->getMethod()
        );

        $this->assertSame(
            $bodyType,
            $request->getBodyType()
        );

        $this->assertSame(
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
            Request::class,
            $request
        );

        $this->assertSame(
            $url,
            $request->getUrl()
        );

        $this->assertSame(
            $headers,
            $request->getHeaders()
        );

        $this->assertSame(
            $method,
            $request->getMethod()
        );

        $this->assertSame(
            $bodyType,
            $request->getBodyType()
        );

        $this->assertSame(
            $params,
            $request->getParams()
        );

        // Make sure that `RequestBuilder::setImplementation(Request::class);`
        // is still honored
        $request = RequestBuilder::getInstance()->build();

        $this->assertInstanceOf(
            Request::class,
            $request
        );
    }

    public function testExpectRequestBuilderToFallbackToDefaultImplementation()
    {
        $default = Request::class;
        $custom = MockRequest::class;

        RequestBuilder::setImplementation($custom);

        $this->assertSame(
            $custom,
            RequestBuilder::getImplementation()
        );

        // Reset to default implementation
        RequestBuilder::setImplementation(null);

        $this->assertSame(
            $default,
            RequestBuilder::getImplementation()
        );
    }

    public function testExpectBuilderWithNoConfigToBuildDefaultInstance()
    {
        // Reset to default implementation
        RequestBuilder::setImplementation(Request::class);

        $expected = new Request();
        $actual = RequestBuilder::getInstance()->build();

        $this->assertEquals(
            $expected,
            $actual
        );
    }

    public function testExpectBuilderWithCustomConfigToBuildIdenticalInstanceAsClassConstructor()
    {
        RequestBuilder::setImplementation(MockRequest::class);

        $expected = new MockRequest();
        $actual = RequestBuilder::getInstance()->build();

        $this->assertEquals(
            $expected,
            $actual
        );
    }
}
