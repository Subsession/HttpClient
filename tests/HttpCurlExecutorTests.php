<?php

namespace Comertis\Http\Tests;

use Comertis\Http\HttpRequest;
use Comertis\Http\Internal\Executors\HttpCurlExecutor;
use PHPUnit\Framework\TestCase;

final class HttpCurlExecutorTests extends TestCase
{
    /**
     * @var HttpCurlExecutor
     */
    private $_httpCurlExecutor;

    public function __construct()
    {
        $this->_httpCurlExecutor = new HttpCurlExecutor();

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
