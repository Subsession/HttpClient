<?php

namespace Subsession\Http\Tests\Extensions;

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
use Subsession\Http\Response;
use Subsession\Http\Tests\Mocks\Post;
use PHPUnit\Framework\TestCase;
use Subsession\Http\Extensions\Client\MiddlewareExtensions;

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

    /**
     * @covers RequestExtensions::setBaseUrl
     * @covers RequestExtensions::getUrl
     * @covers RequestExtensions::getBaseUrl
     *
     * @return void
     */
    public function testExpectClientToHaveBaseUrlExtensions()
    {
        $this->client->setBaseUrl(self::BASE_URL);

        $clientUrl = $this->client->getUrl();

        $this->assertEquals(
            self::BASE_URL,
            $clientUrl
        );

        $this->client->setBaseUrl(null);

        $this->assertNull(
            $this->client->getBaseUrl()
        );
    }

    /**
     * @covers RequestExtensions::setBaseUrl
     * @covers RequestExtensions::setUrl
     * @covers RequestExtensions::getUrl
     *
     * @return void
     */
    public function testExpectClientToHaveUrlExtensions()
    {
        // Remove base url to allow absolute URL for setUrl() function
        $this->client->setBaseUrl(null);

        $testUrl = "test";

        $this->client->setUrl($testUrl);
        $clientUrl = $this->client->getUrl();

        $this->assertEquals(
            $testUrl,
            $clientUrl
        );
    }

    /**
     * @covers RequestExtensions::setUrl
     * @covers RequestJsonExtensions::postJson
     *
     * @return void
     */
    public function testExpectClientToHavePostJsonExtension()
    {
        /** @var ResponseInterface $response */
        $response = $this->client
            ->setUrl("posts")
            ->postJson((new Post()));

        $this->assertEquals(
            HttpStatusCode::CREATED,
            $response->getStatusCode()
        );
    }

    /**
     * @covers RequestExtensions::setUrl
     * @covers RequestJsonExtensions::putJson
     *
     * @return void
     */
    public function testExpectClientToHavePutJsonExtension()
    {
        /** @var ResponseInterface $response */
        $response = $this->client
            ->setUrl("posts/1")
            ->putJson((new Post()));

        $this->assertEquals(
            HttpStatusCode::OK,
            $response->getStatusCode()
        );
    }

    /**
     * @covers RequestExtensions::setUrl
     * @covers RequestJsonExtensions::deleteJson
     *
     * @return void
     */
    public function testExpectClientToHaveDeleteJsonExtension()
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

    /**
     * @covers RequestBuilder::getInstance
     * @covers RequestBuilder::build
     * @covers HttpClient::setRequest
     * @covers HttpClient::getRequest
     *
     * @return void
     */
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

        $this->assertEquals(
            $request,
            $clientRequest
        );
    }

    /**
     * @covers Headers::setHeaders
     * @covers Headers::getHeaders
     * @covers Headers::addHeaders
     * @covers Headers::clearHeaders
     *
     * @return void
     */
    public function testExpectClientToHaveHeadersExtensions()
    {
        // # SET_HEADERS region
        $headers = ["test" => "test"];

        $this->client->setHeaders($headers);

        // # GET_HEADERS region
        $clientHeaders = $this->client->getHeaders();

        $this->assertEquals(
            $headers,
            $clientHeaders
        );

        // # ADD_HEADERS region
        $addedHeaders = ["test2" => "test2"];

        $this->client->addHeaders($addedHeaders);

        $headers = array_merge($headers, $addedHeaders);

        $clientHeaders = $this->client->getHeaders();

        $this->assertEquals(
            $headers,
            $clientHeaders
        );

        // # CLEAR_HEADERS region
        $this->client->clearHeaders();

        $clientHeaders = $this->client->getHeaders();

        $this->assertEquals(
            [],
            $clientHeaders
        );
    }

    /**
     * @covers RequestExtensions::setUrl
     * @covers RequestExtensions::get
     *
     * @return void
     */
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

    /**
     * @covers RequestExtensions::setUrl
     * @covers RequestExtensions::post
     *
     * @return void
     */
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

    /**
     * @covers RequestExtensions::setUrl
     * @covers RequestExtensions::put
     *
     * @return void
     */
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

    /**
     * @covers RequestExtensions::setUrl
     * @covers RequestExtensions::delete
     *
     * @return void
     */
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

    /**
     * @covers ResponseBuilder::getInstance
     * @covers ResponseBuilder::build
     * @covers HttpClient::setResponse
     * @covers HttpClient::getResponse
     *
     * @return void
     */
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

        $this->assertEquals(
            $response,
            $clientResponse
        );
    }

    /**
     * @covers AdapterBuilder::getInstance
     * @covers AdapterBuilder::build
     * @covers AdapterExtensions::setAdapter
     * @covers AdapterExtensions::getAdapter
     *
     * @return void
     */
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

        $this->assertEquals(
            $adapter,
            $clientAdapter
        );
    }

    /**
     * @covers MiddlewareExtensions::getMiddlewares
     * @covers MiddlewareExtensions::addMiddlewares
     * @covers MiddlewareExtensions::setMiddlewares
     *
     * @return void
     */
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

        $this->assertEquals(
            $defaultMiddlewares,
            $clientMiddlewares
        );
    }
}
