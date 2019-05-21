<?php

namespace Comertis\Http\Tests;

// Autoload files using Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

use Comertis\Http\Tests\HttpClientDeleteTests;
use Comertis\Http\Tests\HttpClientGetTests;
use Comertis\Http\Tests\HttpClientPostTests;
use Comertis\Http\Tests\HttpClientPutTests;

class Index
{
    /**
     * HttpClientGetTests class
     *
     * @var HttpClientGetTests
     */
    private $_getTests;

    /**
     * HttpClientPostTests class
     *
     * @var HttpClientPostTests
     */
    private $_postTests;

    /**
     * HttpClientPutTests class
     *
     * @var HttpClientPutTests
     */
    private $_putTests;

    /**
     * HttpClientDeleteTests class
     *
     * @var HttpClientDeleteTests
     */
    private $_deleteTests;

    public function __construct()
    {
        $this->_getTests = new HttpClientGetTests();
        $this->_postTests = new HttpClientPostTests();
        $this->_putTests = new HttpClientPutTests();
        $this->_deleteTests = new HttpClientDeleteTests();
    }

    public function init()
    {
        $this->_getTests->init();
        $this->_postTests->init();
        $this->_putTests->init();
        $this->_deleteTests->init();
    }
}

$index = new Index();
$index->init();
