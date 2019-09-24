<?php

namespace Subsession\Http\Tests;

use stdClass;
use JsonException;
use PHPUnit\Framework\TestCase;
use Subsession\Http\HttpRequestType;
use Subsession\Http\HttpRequestMethod;
use Subsession\Http\Builders\RequestBuilder;
use Subsession\Http\Middlewares\BodyFormatterMiddleware;
use Subsession\Http\Middlewares\HeadersFormatterMiddleware;
use Subsession\Http\Middlewares\UrlFormatterMiddleware;

class RequestTests extends TestCase
{
    public function setUp()
    {
        //
    }

    public function tearDown()
    {
        //
    }

    /**
     * Tests json_encode on a Request class
     *
     * @covers HttpClientBuilder::getInstance
     * @covers HttpClientBuilder::build
     * @covers HttpClient::setUrl
     * @covers HttpClient::postJson
     * @covers HttpClient::getRequest
     *
     * @see https://github.com/Subsession/HttpClient/issues/19
     * @return void
     */
    public function testRequestJsonEncodesCorrectly()
    {
        $innerData = new stdClass();
        $innerData->codi_client = "4475";
        $innerData->referencia = "COMERTIS0002";
        $innerData->ean = "";
        $innerData->descripcio_ext = "Desc";
        $innerData->preu = "20.000000";
        $innerData->id_article = "327";
        $innerData->desc_article = "Taladros";
        $innerData->mides = "";
        $innerData->model = "Prova comertis";
        $innerData->preu_compra = "20.000000";
        $innerData->id_prov = "8";
        $innerData->desc_prova = "Altuna";

        $this->assertIsObject(
            $innerData
        );

        $data = [
            $innerData
        ];

        $this->assertIsArray(
            $data
        );

        $this->assertContains(
            $innerData,
            $data
        );

        $request = RequestBuilder::getInstance()
            ->withUrl("preus")
            ->withParams($data)
            ->withBodyType(HttpRequestType::JSON)
            ->withMethod(HttpRequestMethod::POST)
            ->build();

        // Needed in order to prepare the request info
        (new UrlFormatterMiddleware())->onRequest($request);
        (new HeadersFormatterMiddleware())->onRequest($request);
        (new BodyFormatterMiddleware())->onRequest($request);

        try {
            $json = json_encode($request, JSON_THROW_ON_ERROR | JSON_INVALID_UTF8_IGNORE);
            $error = json_last_error();
            $errorMessage = json_last_error_msg();
        } catch (JsonException $e) {
            var_dump($e->getMessage());
        }

        $this->assertNotEquals(
            "{}",
            $json
        );
    }
}
