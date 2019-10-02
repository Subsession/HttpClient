<?php

namespace Subsession\Http\Tests\Builders;

use Subsession\Http\Adapters\CurlAdapter;
use Subsession\Http\Adapters\StreamAdapter;
use Subsession\Http\Builders\AdapterBuilder;
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

    /**
     * @return void
     */
    public function testExpectAdapterToBeDefaultInstance()
    {
        $adapter = AdapterBuilder::getInstance()->build();

        // CurlAdapter is the default implementation
        $this->assertInstanceOf(
            CurlAdapter::class,
            $adapter
        );
    }

    /**
     * @return void
     */
    public function testExpectAdapterToBeCurlAdapterInstance()
    {
        AdapterBuilder::setImplementation(CurlAdapter::class);

        $adapter = AdapterBuilder::getInstance()->build();

        $this->assertInstanceOf(
            CurlAdapter::class,
            $adapter
        );
    }

    /**
     * @return void
     */
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
