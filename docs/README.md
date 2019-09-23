# HttpClient documentation

- [HttpClient documentation](#httpclient-documentation)
  - [Builders](#builders)
    - [Builders\HttpClientBuilder](#buildershttpclientbuilder)
      - [Usage](#usage)
    - [Builders\RequestBuilder](#buildersrequestbuilder)
      - [Usage](#usage-1)
    - [Builders\ResponseBuilder](#buildersresponsebuilder)
      - [Usage](#usage-2)
    - [Builders\AdapterBuilder](#buildersadapterbuilder)
      - [Usage](#usage-3)
  - [HttpClient](#httpclient)
    - [Setup](#setup)
      - [Simple request handling](#simple-request-handling)
      - [Advanced request handling](#advanced-request-handling)

## Builders

The builders are used in case you want to use custom implementation of the provided interfaces under the `Subsession\Http\Abstraction` namespace. The library already offers & uses a default implementation of said interfaces.

### Builders\HttpClientBuilder

Used to create `Abstraction\HttpClientInterface` instances.

If no specific implementation is specified, it uses the default one: `HttpClient`.

#### Usage

Default:

```php
// This builds the default implementation (HttpClient)
/** @var HttpClient $client */
$client = Builders\HttpClientBuilder::getInstance()->build();
```

Custom `Abstraction\HttpClientInterface` implementation:

```php
// This sets the Abstraction\HttpClientInterface implementation to
// my custom http client class.
Builders\HttpClientBuilder::setImplementation(MyCustomHttpClient::class);

// This is now an instance of 'MyCustomHttpClient'
/** @var MyCustomHttpClient $client */
$client = Builders\HttpClientBuilder::getInstance()->build();
```

### Builders\RequestBuilder

Used to create `Abstraction\RequestInterface` instances.

If no specific implementation is specified, it uses the default one: `Request`.

#### Usage

Default:

```php
// This builds the default implementation (Request)
/** @var Request $request */
$request = Builders\RequestBuilder::getInstance()
    ->withUrl("https://api.github.com/")
    ->withMethod(HttpRequestMethod::GET)
    ->build();
```

Custom `Abstraction\RequestInterface` implementation:

```php
// This sets the Abstraction\RequestInterface implementation to
// my custom request class.
Builders\RequestBuilder::setImplementation(MyCustomRequest::class);

// This is now an instance of 'MyCustomRequest'
/** @var MyCustomRequest $request */
$request = Builders\RequestBuilder::getInstance()
    ->withUrl("https://api.github.com/")
    ->withMethod(HttpRequestMethod::GET)
    ->build();
```

### Builders\ResponseBuilder

Used to create `Abstraction\ResponseInterface` instances.

If no specific implementation is specified, it uses the default one: `Response`.

> ⚠ IMPORTANT ⚠
>
> This builder should only be used in case you with to create a custom `AdapterInterface`, since that's the only place where responses are created.

#### Usage

Default:

```php
// This builds the default implementation (Response)
/** @var Response $response */
$response = Builders\ResponseBuilder::getInstance()->build();
```

Custom `Abstraction\ResponseInterface` implementation:

```php
// This sets the Abstraction\ResponseInterface implementation to
// my custom response class.
Builders\ResponseBuilder::setImplementation(MyCustomResponse::class);

// This is now an instance of 'MyCustomResponse'
/** @var MyCustomResponse $response */
$response = Builders\ResponseBuilder::getInstance()
    ->withStatusCode(200)
    ->build();
```

### Builders\AdapterBuilder

Used to create `AdapterInterface` instances.

If no specific implementation is specified, it uses the default one: `Adapters\CurlAdapter`.

> ⚠ IMPORTANT ⚠
>
> This builder should only be used in case you with to create a custom `AdapterInterface` and want to swap out the default adapter from the `HttpClient`

#### Usage

Default:

```php
// This builds the default implementation (Adapters\CurlAdapter)
/** @var Adapters\CurlAdapter $adapter */
$adapter = Builders\AdapterBuilder::getInstance()->build();
```

Custom `AdapterInterface` implementation:

```php
Builders\AdapterBuilder::setImplementation(MyCustomAdapter::class);

// This is now an instance of 'MyCustomAdapter'
/** @var MyCustomAdapter $adapter */
$adapter = Builders\AdapterBuilder::getInstance()->build();

// Swap out the client's default adapter for a custom one
/** @var HttpClient $client */
$client->setAdapter($adapter);
```

## HttpClient

### Setup

The `Abstraction\HttpClientInterface` interface has only one method: `handle(Abstraction\RequestInterface $request)`.

There are several extensions available & added to the `HttpClient` class that make it much easier to handle requests than having to manually build a request each time.

Under `src/extensions/client` there are a few `traits` that handle everything from the adapter to use, the request object creation & configuration, to the response and middlewares for the `HttpClient` class.

#### Simple request handling

Example request without any extensions added to the `HttpClient` class:

```php
/** @var HttpClient $client */
$client = Builders\HttpClientBuilder::getInstance()->build();

// GET Request
/** @var Abstraction\RequestInterface $request */
$request = Builders\RequestBuilder::getInstance()->build();
$request->setUrl("https://api.github.com/endpoint1")
    ->setParams(["param1" => "value"])
    ->setMethod(HttpRequestMethod::GET);

/** @var Abstraction\ResponseInterface $response */
$response = $client->handle($request);

// POST Request with JSON encoded params
/** @var Abstraction\RequestInterface $request */
$request = Builders\RequestBuilder::getInstance()->build();
$request->setUrl("https://api.github.com/endpoint1")
    ->setParams(["param1" => "value"])
    ->setMethod(HttpRequestMethod::POST)
    ->setBodyType(HttpRequestType::JSON);

/** @var Abstraction\ResponseInterface $response */
$response = $client->handle($request);
```

This approach is more verbose, but it is compliant with the `Abstraction\HttpClientInterface`.

#### Advanced request handling

Example request with traits added to the `HttpClient` class:

```php
/** @var HttpClient $client */
$client = Builders\HttpClientBuilder::getInstance()->build();

// Base url for all requests
$client->setBaseUrl("https://api.github.com/");

// GET Request
/** @var Abstraction\ResponseInterface $response */
$response = $client
    ->setUrl("endpoint1") // Relative to the base url
    ->get(["param1" => "value"]);

// POST Request with JSON encoded params
/** @var Abstraction\ResponseInterface $response */
$response = $client
    ->setUrl("endpoint1") // Relative to the base url
    ->postJson(["param1" => "value"]);
```

This approach is much more convenient when dealing with multiple requests in the same scope, and it doesn't break the `Abstraction\HttpClientInterface` contract, but autocomplete might fail to recognize the extension methods.
