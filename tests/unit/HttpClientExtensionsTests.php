<?php

namespace Subsession\Http\Tests\Unit;

use Subsession\Http\Abstraction\AdapterInterface;
use Subsession\Http\Abstraction\RequestInterface;
use Subsession\Http\Abstraction\ResponseInterface;
use Subsession\Http\Adapters\CurlAdapter;
use Subsession\Http\Builders\AdapterBuilder;
use Subsession\Http\Builders\HttpClientBuilder;
use Subsession\Http\Builders\RequestBuilder;
use Subsession\Http\Builders\ResponseBuilder;
use Subsession\Http\HttpClient;
use Subsession\Http\HttpStatusCode;
use Subsession\Http\Tests\Mocks\Post;
use PHPUnit\Framework\TestCase;

final class HttpClientExtensionsTests extends TestCase
{
    /**
     * @var HttpClient
     */
    private $client;

    const BASE_URL = "http://jsonplaceholder.typicode.com/";

    protected function setUp()
    {
        $this->client = HttpClientBuilder::getInstance()->build();
        $this->client
            ->setBaseUrl(self::BASE_URL)
            ->setAdapter(CurlAdapter::class);
    }

    protected function tearDown()
    {
        //
    }

    public function testExpectClientToHaveBaseUrlExtensions()
    {
        $this->client->setBaseUrl(self::BASE_URL);

        $clientUrl = $this->client->getUrl();

        $this->assertSame(
            self::BASE_URL,
            $clientUrl
        );

        $this->client->setBaseUrl(null);

        $this->assertNull(
            $this->client->getBaseUrl()
        );
    }

    public function testExpectClientToHaveUrlExtensions()
    {
        // Remove base url to allow absolute URL for setUrl() function
        $this->client->setBaseUrl(null);

        $testUrl = "test";

        $this->client->setUrl($testUrl);
        $clientUrl = $this->client->getUrl();

        $this->assertSame(
            $testUrl,
            $clientUrl
        );
    }

    public function testExpectClientToHavePostJsonExtension()
    {
        /** @var ResponseInterface $response */
        $response = $this->client
            ->setUrl("posts")
            ->postJson((new Post()));

        $this->assertSame(
            HttpStatusCode::CREATED,
            $response->getStatusCode()
        );
    }

    public function testExpectClientToHavePutJsonExtension()
    {
        /** @var ResponseInterface $response */
        $response = $this->client
            ->setUrl("posts/1")
            ->putJson((new Post()));

        $this->assertSame(
            HttpStatusCode::OK,
            $response->getStatusCode()
        );
    }

    public function testExpectClientToHaveDeleteJsonExtension()
    {
        /** @var ResponseInterface $response */
        $response = $this->client
            ->setUrl("posts/1")
            ->deleteJson();

        $this->assertSame(
            HttpStatusCode::OK,
            $response->getStatusCode()
        );
    }

    public function testExpectClientToHaveRequestExtensions()
    {
        /** @var RequestInterface $request */
        $request = RequestBuilder::getInstance()->build();

        $this->assertTrue(
            $request instanceof RequestInterface
        );

        $this->client->setRequest($request);

        /** @var RequestInterface $clientRequest */
        $clientRequest = $this->client->getRequest();

        $this->assertTrue(
            $clientRequest instanceof RequestInterface
        );

        $this->assertSame(
            $request,
            $clientRequest
        );
    }

    public function testExpectClientToHaveHeadersExtensions()
    {
        // # SET_HEADERS region
        $headers = ["test" => "test"];

        $this->client->setHeaders($headers);

        // # GET_HEADERS region
        $clientHeaders = $this->client->getHeaders();

        $this->assertSame(
            $headers,
            $clientHeaders
        );

        // # ADD_HEADERS region
        $addedHeaders = ["test2" => "test2"];

        $this->client->addHeaders($addedHeaders);

        $headers = array_merge($headers, $addedHeaders);

        $clientHeaders = $this->client->getHeaders();

        $this->assertSame(
            $headers,
            $clientHeaders
        );

        // # CLEAR_HEADERS region
        $this->client->clearHeaders();

        $clientHeaders = $this->client->getHeaders();

        $this->assertSame(
            [],
            $clientHeaders
        );
    }

    public function testExpectClientToHaveGetExtension()
    {
        /** @var ResponseInterface $response */
        $response = $this->client
            ->setUrl("posts/1")
            ->get();

        $this->assertTrue(
            $response instanceof ResponseInterface
        );
    }

    public function testExpectClientToHavePostExtension()
    {
        /** @var ResponseInterface $response */
        $response = $this->client
            ->setUrl("posts/1")
            ->post();

        $this->assertTrue(
            $response instanceof ResponseInterface
        );
    }

    public function testExpectClientToHavePutExtension()
    {
        /** @var ResponseInterface $response */
        $response = $this->client
            ->setUrl("posts/1")
            ->put();

        $this->assertTrue(
            $response instanceof ResponseInterface
        );
    }

    public function testExpectClientToHaveDeleteExtension()
    {
        /** @var ResponseInterface $response */
        $response = $this->client
            ->setUrl("posts/1")
            ->delete();

        $this->assertTrue(
            $response instanceof ResponseInterface
        );
    }

    public function testExpectClientToHaveResponseExtensions()
    {
        /** @var ResponseInterface $response */
        $response = ResponseBuilder::getInstance()->build();

        $this->assertTrue(
            $response instanceof ResponseInterface
        );

        $this->client->setResponse($response);

        /** @var ResponseInterface $clientResponse */
        $clientResponse = $this->client->getResponse();

        $this->assertTrue(
            $clientResponse instanceof ResponseInterface
        );

        $this->assertSame(
            $response,
            $clientResponse
        );
    }

    public function testExpectClientToHaveAdapterExtensions()
    {
        /** @var AdapterInterface $adapter */
        $adapter = AdapterBuilder::getInstance()->build();

        $this->assertTrue(
            $adapter instanceof AdapterInterface
        );

        $this->client->setAdapter($adapter);

        /** @var AdapterInterface $clientAdapter */
        $clientAdapter = $this->client->getAdapter();

        $this->assertTrue(
            $clientAdapter instanceof AdapterInterface
        );

        $this->assertSame(
            $adapter,
            $clientAdapter
        );
    }

    public function testExpectClientToHaveMiddlewareExtensions()
    {
        /** @var array|MiddlewareInterface[] $clientMiddlewares */
        $clientMiddlewares = $this->client->getMiddlewares();

        $this->assertTrue(
            is_array($clientMiddlewares)
        );

        $defaultMiddlewares = $clientMiddlewares;

        $this->client->setMiddlewares([]);

        $this->assertNotEmpty(
            $defaultMiddlewares
        );

        /** @var array|MiddlewareInterface[] $clientMiddlewares */
        $clientMiddlewares = $this->client->getMiddlewares();

        $this->assertNotEmpty(
            $clientMiddlewares
        );

        $this->assertSame(
            $defaultMiddlewares,
            $clientMiddlewares
        );
    }
}
