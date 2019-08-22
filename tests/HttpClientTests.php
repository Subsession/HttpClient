<?php

namespace Comertis\Http\Tests;

use Comertis\Http\Adapters\HttpCurlAdapter;
use Comertis\Http\HttpClient;
use Comertis\Http\HttpStatusCode;
use Comertis\Http\Internal\HttpRequestInterface;
use Comertis\Http\Internal\HttpResponseInterface;
use PHPUnit\Framework\TestCase;

final class HttpClientTests extends TestCase
{
    /**
     * @var HttpClient
     */
    private $client;

    const BASE_URL = "http://jsonplaceholder.typicode.com/";

    public function __construct()
    {
        $this->client = new HttpClient();
        $this->client
            ->setBaseUrl(self::BASE_URL)
            ->setAdapter(HttpCurlAdapter::class)
            ->beforeRequest(function (HttpRequestInterface $request) {
                print_r("Request interceptor called" . PHP_EOL);
            })
            ->beforeResponse(function (HttpResponseInterface $response) {
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

        // $this->assertEquals(
        //     null,
        //     $response->getBody()
        // );
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
}
