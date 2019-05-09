<?php
// Autoload files using Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

use Comertis\Http\HttpClient;
use Comertis\Http\HttpClientException;
use Comertis\Http\HttpStatusCode;

class HttpClientTest
{
    private $_httpClient;

    const RETRY_COUNT = 3;
    const BASE_URL = "http://jsonplaceholder.typicode.com/";

    public function __construct()
    {
        $this->_httpClient = new HttpClient();
        $this->_httpClient
            ->setRetryCount(self::RETRY_COUNT)
            ->setHeaders([
                "Accept" => "application/json",
            ]);
    }

    public function get200()
    {
        try {
            $response = $this->_httpClient
                ->setUrl(self::BASE_URL . "posts/1")
                ->get();

            return $response->getStatusCode() == HttpStatusCode::OK;

        } catch (HttpClientException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function get404()
    {
        try {
            $response = $this->_httpClient
                ->setUrl(self::BASE_URL . "posts/2222")
                ->get();

            return $response->getStatusCode() == HttpStatusCode::NOT_FOUND;

        } catch (HttpClientException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getBodyNotEmpty()
    {
        try {
            $response = $this->_httpClient
                ->setUrl(self::BASE_URL . "posts/1")
                ->get();

            return !empty($response->getBody());

        } catch (HttpClientException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getBodyEmpty()
    {
        try {
            $response = $this->_httpClient
                ->setUrl(self::BASE_URL . "posts/2222")
                ->get();

            return $response->getBody() == "{}";

        } catch (HttpClientException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}

$test = new HttpClientTest();
echo "<p>get200 -> " . $test->get200() . "</p>";
echo "<p>get404 -> " . $test->get404() . "</p>";
echo "<p>getBodyNotEmpty -> " . $test->getBodyNotEmpty() . "</p>";
echo "<p>getBodyEmpty -> " . $test->getBodyEmpty() . "</p>";
