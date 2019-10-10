<?php

namespace Subsession\Http\Tests\Unit\Middlewares;

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
     * @dataProvider getRequestMethodsThatModifyTheUrl
     *
     * @return void
     */
    public function testUrlFormatterModifiesRequests($requestMethod)
    {
        $url = "test";
        $params = ["param" => "value"];
        $modifiedUrl = $url . "?" . http_build_query($params);

        $request = RequestBuilder::getInstance()
            ->withUrl($url)
            ->withParams($params)
            ->withMethod($requestMethod)
            ->build();

        $this->assertSame(
            $url,
            $request->getUrl()
        );

        $urlFormatter = new UrlFormatterMiddleware();
        $urlFormatter->onRequest($request);

        $this->assertSame(
            $modifiedUrl,
            $request->getUrl()
        );
    }

    /**
     * @dataProvider getRequestMethodsThatDoNotModifyTheUrl
     *
     * @return void
     */
    public function testUrlFormatterDoesNotModifyRequests($requestMethod)
    {
        $url = "test";
        $params = ["param" => "value"];

        $request = RequestBuilder::getInstance()
            ->withUrl($url)
            ->withParams($params)
            ->withMethod($requestMethod)
            ->build();

        $this->assertSame(
            $url,
            $request->getUrl()
        );

        $urlFormatter = new UrlFormatterMiddleware();
        $urlFormatter->onRequest($request);

        $this->assertSame(
            $url,
            $request->getUrl()
        );
    }

    public function getRequestMethodsThatModifyTheUrl()
    {
        return [
            [HttpRequestMethod::GET],
            [HttpRequestMethod::HEAD]
        ];
    }

    public function getRequestMethodsThatDoNotModifyTheUrl()
    {
        return [
            [HttpRequestMethod::POST],
            [HttpRequestMethod::PUT],
            [HttpRequestMethod::DELETE]
        ];
    }
}
