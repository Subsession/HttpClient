<?php

namespace Comertis\Http\Tests;

use Comertis\Http\Abstraction\RequestInterface;
use Comertis\Http\Abstraction\ResponseInterface;
use Comertis\Http\Adapters\CurlAdapter;
use Comertis\Http\Builders\HttpClientBuilder;
use Comertis\Http\HttpStatusCode;
use Comertis\Http\Tests\Mocks\Post;
use PHPUnit\Framework\TestCase;

final class HttpClientTests extends TestCase
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    const BASE_URL = "http://jsonplaceholder.typicode.com/";

    public function __construct()
    {
        $this->client = HttpClientBuilder::build();
        $this->client
            ->setBaseUrl(self::BASE_URL)
            ->setAdapter(CurlAdapter::class)
            ->beforeRequest(function (RequestInterface &$request) {
                print_r("Request interceptor called" . PHP_EOL);
            })
            ->beforeResponse(function (ResponseInterface &$response) {
                print_r("Response interceptor called" . PHP_EOL);
            });

        parent::__construct();
    }

    public function testExpect200ResponseStatusCode()
    {
        $response = $this->client
            ->setUrl("posts/1")
            ->get();

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
        $response = $this->client
            ->setUrl("post/222222")
            ->get();

        $this->assertEquals(
            HttpStatusCode::NOT_FOUND,
            $response->getStatusCode()
        );
    }

    public function testExpectResponseBodyToHaveContent()
    {
        $response = $this->client
            ->setUrl("posts/1")
            ->get();

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
        $response = $this->client
            ->setUrl("posts/2222")
            ->get();

        $this->assertEquals(
            HttpStatusCode::NOT_FOUND,
            $response->getStatusCode()
        );
    }

    public function testExpectResponseHeadersToContainContentTypeApplicationJson()
    {
        $contentType = "Content-Type";
        $applicationJson = "application/json; charset=utf-8";

        $response = $this->client
            ->setUrl("posts/1")
            ->get();

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

    public function testExpectHttpClientToHavePostJsonExtensionMethod()
    {
        $response = $this->client
            ->setUrl("posts")
            ->postJson([(new Post())]);

        $this->assertEquals(
            HttpStatusCode::CREATED,
            $response->getStatusCode()
        );
    }

    public function testExpectHttpClientToHavePutJsonExtensionMethod()
    {
        $response = $this->client
            ->setUrl("posts/1")
            ->putJson([(new Post())]);

        $this->assertEquals(
            HttpStatusCode::OK,
            $response->getStatusCode()
        );
    }

    public function testExpectHttpClientToHaveDeleteJsonExtensionMethod()
    {
        $response = $this->client
            ->setUrl("posts/1")
            ->deleteJson();

        $this->assertEquals(
            HttpStatusCode::OK,
            $response->getStatusCode()
        );
    }
}
