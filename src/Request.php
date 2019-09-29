<?php

/**
 * PHP Version 7
 *
 * LICENSE:
 * See the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Subsession
 *
 * @category Http
 * @package  Subsession\Http
 * @author   Cristian Moraru <cristian.moraru@live.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  GIT: &Id&
 * @link     https://github.com/Subsession/HttpClient
 */

namespace Subsession\Http;

use JsonSerializable;
use Subsession\Http\Abstraction\RequestInterface;
use Subsession\Http\HttpRequestMethod;
use Subsession\Http\Extensions as Extensions;

/**
 * Undocumented class
 *
 * @category Http
 * @package  Subsession\Http
 * @author   Cristian Moraru <cristian.moraru@live.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Subsession/HttpClient
 */
class Request implements RequestInterface, JsonSerializable
{
    use Extensions\Headers;
    use Extensions\ContentType;
    use Extensions\JsonSerializable;

    /**
     * Base url
     *
     * @access private
     * @var    string|null
     */
    private $url;

    /**
     * HTTP request method
     *
     * @access private
     * @var    string
     */
    private $method;

    /**
     * Http request type
     *
     * @access private
     * @var    string
     */
    private $bodyType;

    /**
     * Request parameters
     *
     * @access private
     * @var    array
     */
    private $params;

    /**
     * Constructor
     *
     * @param string $url     Request URL
     * @param array  $headers Request headers
     * @param string $method  Request method
     * @param array  $params  Request parameters
     */
    public function __construct($url = null, $headers = [], $method = null, $params = [])
    {
        if (null === $method) {
            $method = HttpRequestMethod::GET;
        }

        $this->url = $url;
        $this->headers = $headers;
        $this->method = $method;
        $this->params = $params;
    }

    /**
     * Get the Request method
     *
     * @access public
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the request method
     *
     * @param string $requestMethod Request method: GET|POST|PUT|DELETE
     *
     * @access public
     * @see    HttpRequestMethod
     * @return static
     */
    public function setMethod($requestMethod)
    {
        $this->method = $requestMethod;

        return $this;
    }

    /**
     * Get the request URL
     *
     * @access public
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the request URL
     *
     * @param string $url URL
     *
     * @access public
     * @return static
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the Request parameters
     *
     * @access public
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set the Request parameters
     *
     * @param array|object $params Request parameters
     *
     * @access public
     * @return static
     */
    public function setParams($params)
    {
        if (is_array($params)) {
            $this->params = $params;
        } else {
            $this->params = [$params];
        }

        return $this;
    }

    /**
     * Get the request body type
     *
     * @access public
     * @return string
     */
    public function getBodyType()
    {
        return $this->bodyType;
    }

    /**
     * Set the request body type
     *
     * @param string $bodyType Request body type
     *
     * @access public
     * @see    HttpRequestType
     * @return static
     */
    public function setBodyType($bodyType)
    {
        $this->bodyType = $bodyType;

        return $this;
    }

    /**
     * Override __toString()
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        $string = "";

        $string .= $this->getMethod() . " " . $this->getUrl() . PHP_EOL;
        $string .= PHP_EOL;

        foreach ($this->getHeaders() as $key => $value) {
            $string .= $key . ":" . $value . PHP_EOL;
        }
        $string .= PHP_EOL;

        foreach ($this->getParams() as $key => $value) {
            $string .= $key . " => " . $value . PHP_EOL;
        }
        $string .= PHP_EOL;

        return $string;
    }
}
