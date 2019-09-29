<?php

namespace Subsession\Http\Tests\Builders;

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

    /**
     * @covers RequestBuilder::setImplementation
     * @covers RequestBuilder::getInstance
     * @covers RequestBuilder::withUrl
     * @covers MockRequest::setUrl
     * @covers RequestBuilder::withHeaders
     * @covers MockRequest::setHeaders
     * @covers RequestBuilder::withMethod
     * @covers MockRequest::setMethod
     * @covers RequestBuilder::withBodyType
     * @covers MockRequest::setBodyType
     * @covers RequestBuilder::withParams
     * @covers MockRequest::setParams
     * @covers RequestBuilder::build
     *
     * @covers MockRequest::getUrl
     * @covers MockRequest::getHeaders
     * @covers MockRequest::getMethod
     * @covers MockRequest::getBodyType
     * @covers MockRequest::getParams
     *
     * @return void
     */
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

    /**
     * @covers RequestBuilder::setImplementation
     * @covers RequestBuilder::getInstance
     * @covers RequestBuilder::withUrl
     * @covers Request::setUrl
     * @covers RequestBuilder::withHeaders
     * @covers Request::setHeaders
     * @covers RequestBuilder::withMethod
     * @covers Request::setMethod
     * @covers RequestBuilder::withBodyType
     * @covers Request::setBodyType
     * @covers RequestBuilder::withParams
     * @covers Request::setParams
     * @covers RequestBuilder::build
     *
     * @covers Request::getUrl
     * @covers Request::getHeaders
     * @covers Request::getMethod
     * @covers Request::getBodyType
     * @covers Request::getParams
     *
     * @return void
     */
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

        $this->assertEquals(
            $custom,
            RequestBuilder::getImplementation()
        );

        // Reset to default implementation
        RequestBuilder::setImplementation(null);

        $this->assertEquals(
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
