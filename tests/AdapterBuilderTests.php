<?php

namespace Comertis\Http\Tests;

use Comertis\Http\Adapters\CurlAdapter;
use Comertis\Http\Adapters\StreamAdapter;
use Comertis\Http\Builders\AdapterBuilder;
use PHPUnit\Framework\TestCase;

class AdapterBuilderTests extends TestCase
{
    public function setUp()
    {
        //
    }

    public function tearDown()
    {
        //
    }

    public function testExpectAdapterToBeDefaultInstance()
    {
        $adapter = AdapterBuilder::getInstance()->build();

        // CurlAdapter is the default implementation
        $this->assertInstanceOf(
            CurlAdapter::class,
            $adapter
        );
    }

    public function testExpectAdapterToBeCurlAdapterInstance()
    {
        AdapterBuilder::setImplementation(CurlAdapter::class);

        $adapter = AdapterBuilder::getInstance()->build();

        $this->assertInstanceOf(
            CurlAdapter::class,
            $adapter
        );
    }

    public function testExpectAdapterToBeStreamAdapterInstance()
    {
        AdapterBuilder::setImplementation(StreamAdapter::class);

        $adapter = AdapterBuilder::getInstance()->build();

        $this->assertInstanceOf(
            StreamAdapter::class,
            $adapter
        );
    }
}
