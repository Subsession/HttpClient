<?php

namespace Comertis\Http\Tests;

use Comertis\Http\Adapters\CurlAdapter;
use Comertis\Http\Builders\AdapterBuilder;
use Comertis\Http\Request;
use Comertis\Http\HttpRequestMethod;
use PHPUnit\Framework\TestCase;

final class HttpCurlAdapterTests extends TestCase
{
    /**
     * @var AdapterInterface
     */
    private $adapter;

    public function __construct()
    {
        $this->adapter = AdapterBuilder::build(CurlAdapter::class);

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

        $request = new Request();
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
