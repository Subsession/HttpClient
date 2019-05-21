<?php

namespace Comertis\Http\Tests;

require_once __DIR__ . '/HttpTests.php';

use Comertis\Http\HttpClientException;
use Comertis\Http\HttpStatusCode;
use Comertis\Http\Tests\HttpTests;

class HttpClientGetTests extends HttpTests
{
    public function init()
    {
        $functions = get_class_methods(__CLASS__);

        foreach ($functions as $key => &$function) {
            if ($function == "init" || $function == "__construct" || $function == "output") {
                unset($functions[$key]);
                continue;
            }

            echo "<h1>" . $function . "</h1>";
            echo "<h3>Result: " . $this->$function() . "</h3>";
            echo "<hr>";
        }
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

    public function getErrorResposne()
    {
        $result = true;
        try {

            $response = $this->_httpClient
                ->setUrl('http://404.php.net/')
                ->get();

            $this->output($response);

            if ($response->getStatusCode() != HttpStatusCode::OK) {
                $result = false;
            }
        } catch (HttpClientException $e) {
            $this->output();
            $result = $e->getMessage();
        }

        return $result;
    }
}
