# HttpClient documentation

- [HttpClient documentation](#httpclient-documentation)
  - [Builders](#builders)
    - [HttpClientBuilder](#httpclientbuilder)
      - [Usage](#usage)
    - [RequestBuilder](#requestbuilder)
      - [Usage](#usage-1)
    - [ResponseBuilder](#responsebuilder)
      - [Usage](#usage-2)
    - [AdapterBuilder](#adapterbuilder)
      - [Usage](#usage-3)
  - [HttpClient](#httpclient)
    - [Setup](#setup)
      - [Simple request handling](#simple-request-handling)
      - [Advanced request handling](#advanced-request-handling)

## Builders

The builders are used in case you want to use custom implementation of the provided interfaces under the `Subsession\Http\Abstraction` namespace. The library already offers & uses a default implementation of said interfaces.

### HttpClientBuilder

Used to create `HttpClientInterface` instances
If no specific implementation is specified, it uses the default one: `HttpClient`.

#### Usage

Default:

```php
// This builds the default implementation (HttpClient)
/** @var HttpClient $client */
$client = HttpClientBuilder::getInstance()->build();
```

Custom `HttpClientInterface` implementation:

```php
// This sets the HttpClientInterface implementation to
// my custom http client class.
HttpClientBuilder::setImplementation(MyCustomHttpClient::class);

// This is now an instance of 'MyCustomHttpClient'
/** @var MyCustomHttpClient $client */
$client = HttpClientBuilder::getInstance()->build();
```

### RequestBuilder

Used to create `RequestInterface` instances.
If no specific implementation is specified, it uses the default one: `Request`.

#### Usage

Default:

```php
// This builds the default implementation (Request)
/** @var Request $request */
$request = RequestBuilder::getInstance()
    ->withUrl("https://api.github.com/")
    ->withMethod(HttpRequestMethod::GET)
    ->build();
```

Custom `RequestInterface` implementation:

```php
// This sets the RequestInterface implementation to
// my custom request class.
RequestBuilder::setImplementation(MyCustomRequest::class);

// This is now an instance of 'MyCustomRequest'
/** @var MyCustomRequest $request */
$request = RequestBuilder::getInstance()
    ->withUrl("https://api.github.com/")
    ->withMethod(HttpRequestMethod::GET)
    ->build();
```

### ResponseBuilder

> ⚠ IMPORTANT ⚠
>
> This builder should only be used in case you with to create a custom `AdapterInterface`, since that's the only place where responses are created.

#### Usage

Default:

```php
// This builds the default implementation (Response)
/** @var Response $response */
$response = ResponseBuilder::getInstance()->build();
```

Custom `ResponseInterface` implementation:

```php
// This sets the ResponseInterface implementation to
// my custom response class.
ResponseBuilder::setImplementation(MyCustomResponse::class);

// This is now an instance of 'MyCustomResponse'
/** @var MyCustomResponse $response */
$response = ResponseBuilder::getInstance()
    ->withStatusCode(200)
    ->build();
```

### AdapterBuilder

> ⚠ IMPORTANT ⚠
>
> This builder should only be used in case you with to create a custom `AdapterInterface` and want to swap out the default adapter from the `HttpClient`

#### Usage

Default:

```php
// This builds the default implementation (CurlAdapter)
/** @var CurlAdapter $adapter */
$adapter = AdapterBuilder::getInstance()->build();
```

Custom `AdapterInterface` implementation:

```php
AdapterBuilder::setImplementation(MyCustomAdapter::class);

// This is now an instance of 'MyCustomAdapter'
/** @var MyCustomAdapter $adapter */
$adapter = AdapterBuilder::getInstance()->build();

// Swap out the client's default adapter for a custom one
/** @var HttpClient $client */
$client->setAdapter($adapter);
```

## HttpClient

### Setup

The `HttpClientInterface` interface only has one method, `handle(RequestInterface $request)`, which the `HttpClient` class implements.

There are several extensions available & added to the `HttpClient` class that make it much easier to handle requests than having to manually build a request each time and pass it to the client.

Under `src/extensions/client` there are a few `trait`s that handle everything from the `AdapterInterface`, to the request, response and middlewares for the `HttpClient` class.

#### Simple request handling

Example request without any extensions added to the `HttpClient` class:

```php
/** @var HttpClient $client */
$client = HttpClientBuilder::build();

// GET Request
/** @var RequestInterface $request */
$request = RequestBuilder::getInstance()->build();
$request->setUrl("https://api.mywebservice.com/endpoint1");
$request->setParams(["param1" => "value"]);
$request->setMethod(HttpRequestMethod::GET);

/** @var ResponseInterface $response */
$response = $client->handle($request);
```

```php
/** @var HttpClient $client */
$client = HttpClientBuilder::build();

// POST Request with JSON encoded params
/** @var RequestInterface $request */
$request = RequestBuilder::getInstance()->build();
$request->setUrl("https://api.mywebservice.com/endpoint1");
$request->setParams(["param1" => "value"]);
$request->setMethod(HttpRequestMethod::POST);
$request->setBodyType(HttpRequestType::JSON);

/** @var ResponseInterface $response */
$response = $client->handle($request);
```

#### Advanced request handling

Example request with extensions added to the `HttpClient` class:

```php
/** @var HttpClient $client */
$client = HttpClientBuilder::build();

// Base url will be available for the $client's scope
$client->setBaseUrl("https://api.mywebservice.com/");

// GET Request
/** @var ResponseInterface $response */
$response = $client
    ->setUrl("endpoint1") // NOTE: relative to the base url set above
    ->get(["param1" => "value"]);

// POST Request with JSON encoded params
/** @var ResponseInterface $response */
$response = $client
    ->setUrl("endpoint1")
    ->postJson(["param1" => "value"]);
```
