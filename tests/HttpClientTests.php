<?php

namespace Comertis\Http\Tests;

use Comertis\Http\Abstraction\ResponseInterface;
use Comertis\Http\Adapters\CurlAdapter;
use Comertis\Http\Builders\HttpClientBuilder;
use Comertis\Http\HttpClient;
use Comertis\Http\HttpStatusCode;
use Comertis\Http\Tests\Mocks\Post;
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
        /** @var ResponseInterface $response */
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
        /** @var ResponseInterface $response */
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
        /** @var ResponseInterface $response */
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
        /** @var ResponseInterface $response */
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

        /** @var ResponseInterface $response */
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
        /** @var ResponseInterface $response */
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
        /** @var ResponseInterface $response */
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
        /** @var ResponseInterface $response */
        $response = $this->client
            ->setUrl("posts/1")
            ->deleteJson();

        $this->assertEquals(
            HttpStatusCode::OK,
            $response->getStatusCode()
        );
    }
}
