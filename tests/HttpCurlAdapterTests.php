<?php

namespace Comertis\Http\Tests;

use Comertis\Http\Adapters\HttpAdapterBuilder;
use Comertis\Http\Adapters\HttpCurlAdapter;
use Comertis\Http\HttpRequest;
use Comertis\Http\HttpRequestMethod;
use PHPUnit\Framework\TestCase;

final class HttpCurlAdapterTests extends TestCase
{
    /**
     * @var HttpAdapterInterface
     */
    private $adapter;

    public function __construct()
    {
        $this->adapter = HttpAdapterBuilder::build(HttpCurlAdapter::class);

        parent::__construct();
    }

    public function testRequestContentLengthHeaderIsSetWithArrayOfObjects()
    {
        $headerKey = "Content-Length";
        $headerSize = 65;

        $object = new \stdClass();
        $object->prop1 = "Test";
        $object->prop2 = "test";

        $params = [$object];

        $request = new HttpRequest();
        $request->setMethod(HttpRequestMethod::POST);
        $request->setParams($params);

        $this->_httpCurlExecutor->prepareHeaders($request);

        $requestHeaders = $request->getHeaders();

        $this->assertArrayHasKey(
            $headerKey,
            $requestHeaders
        );

        $this->assertTrue(
            $requestHeaders[$headerKey] > 0
        );

        $this->assertTrue(
            $requestHeaders[$headerKey] === $headerSize
        );
    }
}
