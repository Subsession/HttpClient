<?php

namespace Subsession\Http\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Subsession\Http\HttpClient;
use Subsession\Http\HttpStatusCode;
use Subsession\Http\HttpRequestMethod;
use Subsession\Http\Builders\RequestBuilder;
use Subsession\Http\Abstraction\ResponseInterface;
use Subsession\Http\Abstraction\RequestInterface;
use Subsession\Http\Builders\HttpClientBuilder;
use Subsession\Http\Request;
use Subsession\Http\Tests\Mocks\MockRequest;

class HttpClientTests extends TestCase
{
    /**
     * @var HttpClient
     */
    private $client;

    const BASE_URL = "http://jsonplaceholder.typicode.com/";

    protected function setUp()
    {
        $this->client = HttpClientBuilder::getInstance()->build();
        $this->client->setBaseUrl(self::BASE_URL);
    }

    protected function tearDown()
    {
        //
    }

    public function testExpect200ResponseStatusCode()
    {
        /** @var RequestInterface $request */
        $request = RequestBuilder::getInstance()->build();
        $request->setUrl(self::BASE_URL . "posts/1")
            ->setMethod(HttpRequestMethod::GET);

        /** @var ResponseInterface $response */
        $response = $this->client->handle($request);

        $this->assertSame(
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
        $request = RequestBuilder::getInstance()->build();
        $request->setUrl(self::BASE_URL . "post/222222")
            ->setMethod(HttpRequestMethod::GET);

        /** @var ResponseInterface $response */
        $response = $this->client->handle($request);

        $this->assertSame(
            HttpStatusCode::NOT_FOUND,
            $response->getStatusCode()
        );
    }

    public function testExpectResponseBodyToHaveContent()
    {
        /** @var RequestInterface $request */
        $request = RequestBuilder::getInstance()->build();
        $request->setUrl(self::BASE_URL . "posts/1")
            ->setMethod(HttpRequestMethod::GET);

        /** @var ResponseInterface $response */
        $response = $this->client->handle($request);

        $this->assertSame(
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
        $request = RequestBuilder::getInstance()->build();
        $request->setUrl(self::BASE_URL . "posts/2222")
            ->setMethod(HttpRequestMethod::GET);

        /** @var ResponseInterface $response */
        $response = $this->client->handle($request);

        $this->assertSame(
            HttpStatusCode::NOT_FOUND,
            $response->getStatusCode()
        );
    }

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

        $this->assertSame(
            HttpStatusCode::OK,
            $response->getStatusCode()
        );

        $responseHeaders = $response->getHeaders();

        $this->assertArrayHasKey(
            $contentType,
            $responseHeaders
        );

        $this->assertSame(
            $responseHeaders[$contentType],
            $applicationJson
        );
    }

    public function testExpectHttpClientToJsonEncodeCorrecly()
    {
        $client = HttpClientBuilder::getInstance()->build();

        $baseUrl = "baseUrl/";
        $headers = [
            "key" => "value"
        ];
        $url = "url";

        $client->setBaseUrl($baseUrl)
            ->setHeaders($headers)
            ->setUrl($url);

        $json = json_encode($client, JSON_UNESCAPED_SLASHES);

        $this->assertNotEquals(
            "{}",
            $json
        );
    }

    public function testExpectHttpClientToHaveNullResponse()
    {
        $client = HttpClientBuilder::getInstance()->build();

        $this->assertNull(
            $client->getResponse()
        );
    }

    public function testExpectHttpClientToHaveDefaultRequestInstantiated()
    {
        RequestBuilder::setImplementation(Request::class);
        $client = HttpClientBuilder::getInstance()->build();

        $this->assertNotNull(
            $client->getRequest()
        );

        $this->assertInstanceOf(
            Request::class,
            $client->getRequest()
        );
    }

    public function testExpectHttpClientToHaveCustomRequestInstantiated()
    {
        RequestBuilder::setImplementation(MockRequest::class);
        $client = HttpClientBuilder::getInstance()->build();

        $this->assertNotNull(
            $client->getRequest()
        );

        $this->assertInstanceOf(
            MockRequest::class,
            $client->getRequest()
        );

        $this->assertEquals(
            RequestBuilder::getInstance()->build(),
            $client->getRequest()
        );
    }
}
