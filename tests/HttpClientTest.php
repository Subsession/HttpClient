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
        echo "<p>get200 -> " . $this->get200() . "</p>";
        echo "<p>get404 -> " . $this->get404() . "</p>";
        echo "<p>getBodyNotEmpty -> " . $this->getBodyNotEmpty() . "</p>";
        echo "<p>getBodyEmpty -> " . $this->getBodyEmpty() . "</p>";
        echo "<p>getHeaderApplicationJson -> " . $this->getHeaderApplicationJson() . "</p>";
        echo "<p>getSinglePost -> " . $this->getSinglePost() . "</p>";
        echo "<p>getArrayOfPosts -> " . $this->getArrayOfPosts() . "</p>";
        echo "<p>postPost -> " . $this->postPost() . "</p>";
        echo "<p>putPost -> " . $this->putPost() . "</p>";
        echo "<p>deletePost -> " . $this->deletePost() . "</p>";
    }

    public function get200()
    {
        try {
            $response = $this->_httpClient
                ->setUrl(self::BASE_URL . "posts/1")
                ->get();

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

            return $response->getBody() == "{}";
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
