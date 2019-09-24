<?php

namespace Subsession\Http\Tests\Middlewares;

use PHPUnit\Framework\TestCase;
use Subsession\Http\Builders\RequestBuilder;
use Subsession\Http\HttpRequestMethod;
use Subsession\Http\Middlewares\UrlFormatterMiddleware;

class UrlFormatterMiddlewareTests extends TestCase
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
     * @covers RequestBuilder::getInstance
     * @covers RequestBuilder::withUrl
     * @covers RequestBuilder::withParams
     * @covers RequestBuilder::withMethod
     * @covers RequestBuilder::build
     *
     * @covers Request::getUrl
     *
     * @covers UrlFormatterMiddleware::onRequest
     *
     * @dataProvider getGet_HeadRequestMethods
     *
     * @return void
     */
    public function testUrlFormatterModifiesGET_HEADRequests($requestMethod)
    {
        $url = "test";
        $params = ["param" => "value"];
        $modifiedUrl = $url . "?" . http_build_query($params);

        $request = RequestBuilder::getInstance()
            ->withUrl($url)
            ->withParams($params)
            ->withMethod($requestMethod)
            ->build();

        $this->assertEquals(
            $url,
            $request->getUrl()
        );

        $urlFormatter = new UrlFormatterMiddleware();
        $urlFormatter->onRequest($request);

        $this->assertEquals(
            $modifiedUrl,
            $request->getUrl()
        );
    }

    /**
     * @covers RequestBuilder::getInstance
     * @covers RequestBuilder::withUrl
     * @covers RequestBuilder::withParams
     * @covers RequestBuilder::withMethod
     * @covers RequestBuilder::build
     *
     * @covers Request::getUrl
     *
     * @covers UrlFormatterMiddleware::onRequest
     *
     * @dataProvider getPost_Put_DeleteRequestMethods
     *
     * @return void
     */
    public function testUrlFormatterDoesNotModifyPOST_PUT_DELETERequests($requestMethod)
    {
        $url = "test";
        $params = ["param" => "value"];

        $request = RequestBuilder::getInstance()
            ->withUrl($url)
            ->withParams($params)
            ->withMethod($requestMethod)
            ->build();

        $this->assertEquals(
            $url,
            $request->getUrl()
        );

        $urlFormatter = new UrlFormatterMiddleware();
        $urlFormatter->onRequest($request);

        $this->assertEquals(
            $url,
            $request->getUrl()
        );
    }

    public function getGet_HeadRequestMethods()
    {
        return [
            [HttpRequestMethod::GET],
            [HttpRequestMethod::HEAD]
        ];
    }

    public function getPost_Put_DeleteRequestMethods()
    {
        return [
            [HttpRequestMethod::POST],
            [HttpRequestMethod::PUT],
            [HttpRequestMethod::DELETE]
        ];
    }
}
