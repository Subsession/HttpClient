<?php
/**
 * PHP Version 7
 *
 * LICENSE:
 * Proprietary, see the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Comertis <info@comertis.com>
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
 * @version  GIT: &Id&
 * @link     https://github.com/Comertis/HttpClient
 */

namespace Comertis\Http;

use Comertis\Exceptions\ArgumentNullException;
use Comertis\Http\Abstraction\RequestInterface;
use Comertis\Http\HttpRequestMethod;

/**
 * Undocumented class
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
class Request implements RequestInterface
{
    use \Comertis\Http\Extensions\Headers;

    /**
     * Base url
     *
     * @access private
     * @var    string
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
        if (is_null($method)) {
            $method = HttpRequestMethod::GET;
        }

        $this->url = $url;
        $this->headers = $headers;
        $this->method = $method;
        $this->params = $params;

        $this->addHeaders(
            [
                "Cache-Control" => "max-age=0",
                "Connection" => "keep-alive",
                "Keep-Alive" => "300",
                "Accept" => "application/json,text/xml,application/xml,application/xhtml+xml,text/plain,image/png,*/*",
                "Accept-Charset" => "utf-8,ISO-8859-1",
            ]
        );
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
     * @return self
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
     * @return string
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
     * @throws ArgumentNullException If the URL is null or empty
     * @return self
     */
    public function setUrl($url)
    {
        if (is_null($url)) {
            throw new ArgumentNullException("URL cannot be null");
        }

        if (empty($url)) {
            throw new ArgumentNullException("URL cannot be empty");
        }

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
     * @param array $params Request parameters
     *
     * @access public
     * @return self
     */
    public function setParams($params)
    {
        $this->params = $params;

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
     * @return self
     */
    public function setBodyType($bodyType)
    {
        $this->bodyType = $bodyType;

        return $this;
    }
}
