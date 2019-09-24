<?php

namespace Subsession\Http\Tests;

use PHPUnit\Framework\TestCase;
use Subsession\Http\HttpClient;
use Subsession\Http\HttpStatusCode;
use Subsession\Http\Tests\Mocks\Post;
use Subsession\Http\HttpRequestMethod;
use Subsession\Http\Builders\RequestBuilder;
use Subsession\Http\Abstraction\ResponseInterface;
use Subsession\Http\Abstraction\RequestInterface;

final class HttpClientTests extends TestCase
{
    /**
     * @var HttpClient
     */
    private $client;

    const BASE_URL = "http://jsonplaceholder.typicode.com/";

    protected function setUp()
    {
        $this->client = new HttpClient();
        $this->client->setBaseUrl(self::BASE_URL);
    }

    protected function tearDown()
    {
        //
    }

    /**
     * @covers RequestBuilder::getInstance
     * @covers RequestBuilder::build
     *
     * @covers Request::setUrl
     * @covers Request::setMethod
     *
     * @covers HttpClient::handle
     *
     * @covers Response::getStatusCode
     * @covers Response::getBody
     *
     * @return void
     */
    public function testExpect200ResponseStatusCode()
    {
        /** @var RequestInterface $request */
        $request = RequestBuilder::getInstance()->build();
        $request->setUrl(self::BASE_URL . "posts/1")
            ->setMethod(HttpRequestMethod::GET);

        /** @var ResponseInterface $response */
        $response = $this->client->handle($request);

        $this->assertEquals(
            HttpStatusCode::OK,
            $response->getStatusCode()
        );

        $this->assertNotEmpty(
            $response->getBody()
        );
    }

    /**
     * @covers RequestBuilder::getInstance
     * @covers RequestBuilder::build
     *
     * @covers Request::setUrl
     * @covers Request::setMethod
     *
     * @covers HttpClient::handle
     *
     * @covers Response::getStatusCode
     *
     * @return void
     */
    public function testExpect404ResponseStatusCode()
    {
        /** @var RequestInterface $request */
        $request = RequestBuilder::getInstance()->build();
        $request->setUrl(self::BASE_URL . "post/222222")
            ->setMethod(HttpRequestMethod::GET);

        /** @var ResponseInterface $response */
        $response = $this->client->handle($request);

        $this->assertEquals(
            HttpStatusCode::NOT_FOUND,
            $response->getStatusCode()
        );
    }

    /**
     * @covers RequestBuilder::getInstance
     * @covers RequestBuilder::build
     *
     * @covers Request::setUrl
     * @covers Request::setMethod
     *
     * @covers HttpClient::handle
     *
     * @covers Response::getStatusCode
     * @covers Response::getBody
     *
     * @return void
     */
    public function testExpectResponseBodyToHaveContent()
    {
        /** @var RequestInterface $request */
        $request = RequestBuilder::getInstance()->build();
        $request->setUrl(self::BASE_URL . "posts/1")
            ->setMethod(HttpRequestMethod::GET);

        /** @var ResponseInterface $response */
        $response = $this->client->handle($request);

        $this->assertEquals(
            HttpStatusCode::OK,
            $response->getStatusCode()
        );

        $this->assertNotEmpty(
            $response->getBody()
        );
    }

    /**
     * @covers RequestBuilder::getInstance
     * @covers RequestBuilder::build
     *
     * @covers Request::setUrl
     * @covers Request::setMethod
     *
     * @covers HttpClient::handle
     *
     * @covers Response::getStatusCode
     *
     * @return void
     */
    public function testExpectResponseBodyToBeEmpty()
    {
        /** @var RequestInterface $request */
        $request = RequestBuilder::getInstance()->build();
        $request->setUrl(self::BASE_URL . "posts/2222")
            ->setMethod(HttpRequestMethod::GET);

        /** @var ResponseInterface $response */
        $response = $this->client->handle($request);

        $this->assertEquals(
            HttpStatusCode::NOT_FOUND,
            $response->getStatusCode()
        );
    }

    /**
     * @covers RequestBuilder::getInstance
     * @covers RequestBuilder::build
     *
     * @covers Request::setUrl
     * @covers Request::setMethod
     *
     * @covers HttpClient::handle
     *
     * @covers Response::getStatusCode
     * @covers Response::getHeaders
     *
     * @return void
     */
    public function testExpectResponseHeadersToContainContentTypeApplicationJson()
    {
        $contentType = "Content-Type";
        $applicationJson = "application/json; charset=utf-8";

        /** @var RequestInterface $request */
        $request = RequestBuilder::getInstance()->build();
        $request->setUrl(self::BASE_URL . "posts/1")
            ->setMethod(HttpRequestMethod::GET);

        /** @var ResponseInterface $response */
        $response = $this->client->handle($request);

        $this->assertEquals(
            HttpStatusCode::OK,
            $response->getStatusCode()
        );

        $responseHeaders = $response->getHeaders();

        $this->assertArrayHasKey(
            $contentType,
            $responseHeaders
        );

        $this->assertEquals(
            $responseHeaders[$contentType],
            $applicationJson
        );
    }
}
