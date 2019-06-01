# Comertis\Http\Tests

This library uses PHPUnit ^7 for it's unit testing.

> https://phpunit.de/getting-started/phpunit-7.html

All unit tests are located in this folder and can be executed using
one of the following commands:

### PHP Archive (PHAR)

```
./phpunit --bootstrap src/autoload.php tests/HttpClientTests
```

The above assumes that you have downloaded phpunit.phar and put it into your \$PATH as phpunit and that src/autoload.php is a script that sets up autoloading for the classes that are to be tested. Such a script is commonly generated using a tool such as phpab.

### Composer

```
./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/HttpClientTests
```

The example shown above assumes that composer is on your \$PATH.

### TestDox

Below you see an alternative output which is based on the idea that the name of a test can be used to document the behavior that is verified by the test:

```
./vendor/bin/phpunit --bootstrap vendor/autoload.php --testdox tests
```

### Test results

| Iterations | Average execution time in seconds |
| ---------- | --------------------------------- |
| 10         | 1.1462                            |
| 100        | 1.116                             |
