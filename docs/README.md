# Comertis/HttpClient documentation

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
$request = RequestBuilder::build();
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
$request = RequestBuilder::build();
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
