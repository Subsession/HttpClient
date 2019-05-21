<?php

namespace Comertis\Http\Tests;

require_once __DIR__ . '/HttpTests.php';

use Comertis\Http\Exceptions\HttpClientException;
use Comertis\Http\HttpStatusCode;
use Comertis\Http\Tests\HttpTests;

class HttpClientDeleteTests extends HttpTests
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
