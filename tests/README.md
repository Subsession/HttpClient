# HttpClient tests

This library uses PHPUnit ^7 for it's unit testing.

> https://phpunit.de/getting-started/phpunit-7.html

All unit tests are located in this folder and can be executed using one of the following commands:

### VSCode

If you're using Visual Studio Code just run the default `test` task.

### PHP Archive (PHAR)

```
./phpunit --bootstrap src/autoload.php --configuration phpunit.xml --testsuite Unit,Integration,Builders,Extensions,Middlewares
```

The above assumes that you have downloaded phpunit.phar and put it into your \$PATH as phpunit and that src/autoload.php is a script that sets up autoloading for the classes that are to be tested. Such a script is commonly generated using a tool such as phpab.

### Composer

```
./vendor/bin/phpunit --bootstrap vendor/autoload.php --configuration phpunit.xml --testsuite Unit,Integration,Builders,Extensions,Middlewares
```

The example shown above assumes that composer is on your \$PATH.

### TestDox

Below you see an alternative output which is based on the idea that the name of a test can be used to document the behavior that is verified by the test:

```
./vendor/bin/phpunit --bootstrap vendor/autoload.php --testdox --configuration phpunit.xml --testsuite Unit,Integration,Builders,Extensions,Middlewares
```
