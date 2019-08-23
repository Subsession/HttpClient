<?php

namespace Comertis\Http\Tests;

use Comertis\Http\Abstraction\HttpRequestInterface;
use Comertis\Http\Abstraction\HttpResponseInterface;
use Comertis\Http\Adapters\HttpCurlAdapter;
use Comertis\Http\Builders\HttpClientBuilder;
use Comertis\Http\HttpClient;
use Comertis\Http\HttpStatusCode;
use PHPUnit\Framework\TestCase;
use stdClass;

final class HttpClientTests extends TestCase
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * @var stdClass
     */
    private $mockPost;

    const BASE_URL = "http://jsonplaceholder.typicode.com/";

    public function __construct()
    {
        $this->client = HttpClientBuilder::build();
        $this->client
            ->setBaseUrl(self::BASE_URL)
            ->setAdapter(HttpCurlAdapter::class)
            ->beforeRequest(function (HttpRequestInterface &$request) {
                print_r("Request interceptor called" . PHP_EOL);
            })
            ->beforeResponse(function (HttpResponseInterface &$response) {
                print_r("Response interceptor called" . PHP_EOL);
            });

        $this->mockPost = new stdClass();
        $this->mockPost->id = 1;
        $this->mockPost->title = "Test title";
        $this->mockPost->body = "Test body";
        $this->mockPost->userId = 1;

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
            ->postJson([$this->mockPost]);

        $this->assertEquals(
            HttpStatusCode::CREATED,
            $response->getStatusCode()
        );
    }

    public function testExpectHttpClientToHavePutJsonExtensionMethod()
    {
        $response = $this->client
            ->setUrl("posts/1")
            ->putJson([$this->mockPost]);

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
