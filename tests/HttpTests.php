<?php

namespace Comertis\Http\Tests;

use Comertis\Http\HttpClient;

class HttpTests
{
    /**
     * @var HttpClient
     */
    protected $_httpClient;

    const RETRY_COUNT = 3;
    const BASE_URL = "http://jsonplaceholder.typicode.com/";

    public function __construct()
    {
        $this->_httpClient = new HttpClient();
        $this->_httpClient
            ->setRetryCount(self::RETRY_COUNT);
    }

    protected function output($response = null)
    {
        echo "<h2>Request:</h2>";
        var_dump($this->_httpClient->getRequest());

        if (!is_null($response)) {
            echo "<h2>Response:</h2>";
            var_dump($response);
        }
    }
}
