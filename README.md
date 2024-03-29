# HttpClient

| Latest stable version                                                                                                                     | Latest unstable version                                                                                                                       | Daily Downloads                                                                                                                    | Monthly downloads                                                                                                                      | Total downloads                                                                                                                      | Composer.lock available                                                                                                               | License                                                                                                                    |
| ----------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------- |
| [![Latest Stable Version](https://poser.pugx.org/subsession/http-client/v/stable)](https://packagist.org/packages/subsession/http-client) | [![Latest Unstable Version](https://poser.pugx.org/subsession/http-client/v/unstable)](https://packagist.org/packages/subsession/http-client) | [![Daily Downloads](https://poser.pugx.org/subsession/http-client/d/daily)](https://packagist.org/packages/subsession/http-client) | [![Monthly Downloads](https://poser.pugx.org/subsession/http-client/d/monthly)](https://packagist.org/packages/subsession/http-client) | [![Total Downloads](https://poser.pugx.org/subsession/http-client/downloads)](https://packagist.org/packages/subsession/http-client) | [![composer.lock](https://poser.pugx.org/subsession/http-client/composerlock)](https://packagist.org/packages/subsession/http-client) | [![License](https://poser.pugx.org/subsession/http-client/license)](https://packagist.org/packages/subsession/http-client) |

An object-oriented Http wrapper library for PHP.

## Requirements

PHP version 7+ is required in order to use this library.

It is also recommended (but not strictly required) to have the `curl` extension enabled.

## Installation

This library is available as a composer package:

```ps
> composer require subsession/http-client
```

## Features

- Swappable implementations thanks to interfaces & builder patterns
- Dynamic request adapter based on available extensions
- Middleware pipeline for requests & responses
- Extensible HttpClient class using traits

## Documentation

Documentation is available in the [docs](./docs/README.md) folder of this repository.

## License

This library is distributed under the MIT license.

The complete license can be found in the [LICENSE](./LICENSE) file in this repository.
