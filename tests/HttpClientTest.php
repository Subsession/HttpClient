<?php
// Autoload files using Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

use Comertis\Http\HttpClient;
use Comertis\Http\HttpClientException;
use Comertis\Http\HttpStatusCode;

class HttpClientTest
{
    /**
     * @var HttpClient
     */
    private $_httpClient;

    const RETRY_COUNT = 3;
    const BASE_URL = "http://jsonplaceholder.typicode.com/";

    public function __construct()
    {
        $this->_httpClient = new HttpClient();
        $this->_httpClient
            ->setRetryCount(self::RETRY_COUNT);
    }

    public function init()
    {
        $functions = get_class_methods(__CLASS__);

        unset($functions[0]); // __construct()
        unset($functions[1]); // init()
        unset($functions[2]); // output()

        foreach ($functions as $function) {
            echo "<h1>" . $function . "</h1>";
            echo "<h3>Result: " . $this->$function() . "</h3>";
            echo "<hr>";
        }
    }

    private function output($response)
    {
        echo "<h2>Request:</h2>";
        var_dump($this->_httpClient->getRequest());

        echo "<h2>Response:</h2>";
        var_dump($response);
    }

    public function get200()
    {
        try {
            $response = $this->_httpClient
                ->setUrl(self::BASE_URL . "posts/1")
                ->get();

            $this->output($response);

            return $response->getStatusCode() == HttpStatusCode::OK;
        } catch (HttpClientException $e) {
            return $e->getMessage();
        }
    }

    public function get404()
    {
        try {
            $response = $this->_httpClient
                ->setUrl(self::BASE_URL . "posts/2222")
                ->get();

            $this->output($response);

            return $response->getStatusCode() == HttpStatusCode::NOT_FOUND;
        } catch (HttpClientException $e) {
            return $e->getMessage();
        }
    }

    public function getBodyNotEmpty()
    {
        try {
            $response = $this->_httpClient
                ->setUrl(self::BASE_URL . "posts/1")
                ->get();

            $this->output($response);

            return !empty($response->getBody());
        } catch (HttpClientException $e) {
            return $e->getMessage();
        }
    }

    public function getBodyEmpty()
    {
        try {
            $response = $this->_httpClient
                ->setUrl(self::BASE_URL . "posts/2222")
                ->get();

            $this->output($response);

            return $response->getBody() == "{}" || empty($response->getBody());
        } catch (HttpClientException $e) {
            return $e->getMessage();
        }
    }

    public function getHeaderApplicationJson()
    {
        $contentType = "Content-Type";
        $applicationJson = "application/json; charset=utf-8";

        try {
            $response = $this->_httpClient
                ->setUrl(self::BASE_URL . "posts/1")
                ->get();

            $this->output($response);

            $headers = $response->getHeaders();

            if (!array_key_exists($contentType, $headers)) {
                return false;
            }

            return $headers[$contentType] == $applicationJson;
        } catch (HttpClientException $e) {
            return $e->getMessage();
        }
    }

    public function getSinglePost()
    {
        $result = true;
        try {
            $response = $this->_httpClient
                ->setUrl(self::BASE_URL . "posts/1")
                ->get();

            $this->output($response);

            if ($response->getStatusCode() != HttpStatusCode::OK) {
                $result = false;
            }

            if (empty($response->getBody())) {
                $result = false;
            }
        } catch (HttpClientException $e) {
            $result = $e->getMessage();
        }

        return $result;
    }

    public function getArrayOfPosts()
    {
        $result = true;
        try {
            $response = $this->_httpClient
                ->setUrl(self::BASE_URL . "posts")
                ->get();

            $this->output($response);

            if ($response->getStatusCode() != HttpStatusCode::OK) {
                $result = false;
            }

            if (empty($response->getBody())) {
                $result = false;
            }

            $posts = json_decode($response->getBody());

            if (!is_array($posts)) {
                return false;
            }
        } catch (HttpClientException $e) {
            $result = $e->getMessage();
        }

        return $result;
    }

    public function postPost()
    {
        $result = true;
        try {

            $post = new stdClass;
            $post->title = "test title";
            $post->body = "test body";
            $post->userId = 1;

            $response = $this->_httpClient
                ->setUrl(self::BASE_URL . "posts")
                ->postJson($post);

            $this->output($response);

            if ($response->getStatusCode() != HttpStatusCode::CREATED) {
                $result = false;
            }

            if (empty($response->getBody())) {
                $result = false;
            }

            $responseBody = json_decode($response->getBody());

            if (!is_object($responseBody)) {
                return false;
            }
        } catch (HttpClientException $e) {
            $result = $e->getMessage();
        }

        return $result;
    }

    public function putPost()
    {
        $result = true;
        try {

            $post = new stdClass;
            $post->title = "test title";
            $post->body = "test body";
            $post->userId = 1;

            $response = $this->_httpClient
                ->setUrl(self::BASE_URL . "posts/1")
                ->putJson($post);

            $this->output($response);

            if ($response->getStatusCode() != HttpStatusCode::OK) {
                $result = false;
            }

            if (empty($response->getBody())) {
                $result = false;
            }

            $responseBody = json_decode($response->getBody());

            if (!is_object($responseBody)) {
                return false;
            }
        } catch (HttpClientException $e) {
            $result = $e->getMessage();
        }

        return $result;
    }

    public function deletePost()
    {
        $result = true;
        try {

            $response = $this->_httpClient
                ->setUrl(self::BASE_URL . "posts/1")
                ->delete();

            $this->output($response);

            if ($response->getStatusCode() != HttpStatusCode::OK) {
                $result = false;
            }
        } catch (HttpClientException $e) {
            $result = $e->getMessage();
        }

        return $result;
    }
}

$httpClientTest = new HttpClientTest();
$httpClientTest->init();
