<?php

namespace Comertis\Http\Tests;

use Comertis\Http\Abstraction\RequestInterface;
use Comertis\Http\Abstraction\ResponseInterface;
use Comertis\Http\Adapters\CurlAdapter;
use Comertis\Http\Builders\HttpClientBuilder;
use Comertis\Http\Builders\RequestBuilder;
use Comertis\Http\HttpClient;
use Comertis\Http\HttpRequestMethod;
use Comertis\Http\HttpStatusCode;
use PHPUnit\Framework\TestCase;

final class HttpClientTests extends TestCase
{
    /**
     * @var HttpClient
     */
    private $client;

    const BASE_URL = "http://jsonplaceholder.typicode.com/";

    protected function setUp()
    {
        $this->client = HttpClientBuilder::build();
        $this->client
            ->setBaseUrl(self::BASE_URL)
            ->setAdapter(CurlAdapter::class);
    }

    protected function tearDown()
    {
        //
    }

    public function testExpect200ResponseStatusCode()
    {
        /** @var RequestInterface $request */
        $request = RequestBuilder::build();
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

    public function testExpect404ResponseStatusCode()
    {
        /** @var RequestInterface $request */
        $request = RequestBuilder::build();
        $request->setUrl(self::BASE_URL . "post/222222")
            ->setMethod(HttpRequestMethod::GET);

        /** @var ResponseInterface $response */
        $response = $this->client->handle($request);

        $this->assertEquals(
            HttpStatusCode::NOT_FOUND,
            $response->getStatusCode()
        );
    }

    public function testExpectResponseBodyToHaveContent()
    {
        /** @var RequestInterface $request */
        $request = RequestBuilder::build();
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

    public function testExpectResponseBodyToBeEmpty()
    {
        /** @var RequestInterface $request */
        $request = RequestBuilder::build();
        $request->setUrl(self::BASE_URL . "posts/2222")
            ->setMethod(HttpRequestMethod::GET);

        /** @var ResponseInterface $response */
        $response = $this->client->handle($request);

        $this->assertEquals(
            HttpStatusCode::NOT_FOUND,
            $response->getStatusCode()
        );
    }

    public function testExpectResponseHeadersToContainContentTypeApplicationJson()
    {
        $contentType = "Content-Type";
        $applicationJson = "application/json; charset=utf-8";

        /** @var RequestInterface $request */
        $request = RequestBuilder::build();
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
