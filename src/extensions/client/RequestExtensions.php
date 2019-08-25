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

namespace Comertis\Http\Extensions\Client;

use Comertis\Http\Abstraction\RequestInterface;
use Comertis\Http\Abstraction\ResponseInterface;
use Comertis\Http\Builders\RequestBuilder;
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
trait RequestExtensions
{
    use \Comertis\Http\Extensions\Client\RequestJsonExtensions;

    /**
     * Base URL for all requests
     *
     * @access private
     * @var    string|null
     */
    private $baseUrl = null;

    /**
     * Holds the request information
     *
     * @access private
     * @see    Request
     * @var    RequestInterface
     */
    private $request;

    /**
     * Get the request URL
     *
     * @access public
     * @see    Request::getUrl()
     * @return string
     */
    public function getUrl()
    {
        return $this->getRequest()->getUrl();
    }

    /**
     * Set the request URL.
     *
     * Absolute URL if base url is null,
     * Relative URL if base url is set
     *
     * @param string $url Request URL
     *
     * @access public
     * @see    HttpClient::setBaseUrl()
     * @see    Request::setUrl()
     * @return self
     */
    public function setUrl($url)
    {
        if (null !== $this->getBaseUrl()) {
            $url = $this->getBaseUrl() . $url;
        }

        $this->getRequest()->setUrl($url);

        return $this;
    }

    /**
     * Get the request headers
     *
     * @access public
     * @see    Request::getHeaders()
     * @return array
     */
    public function getHeaders()
    {
        return $this->getRequest()->getHeaders();
    }

    /**
     * Set the request headers
     *
     * @param array $headers Array of (Key => Value) pairs
     *
     * @access public
     * @see    Request::setHeaders()
     * @return self
     */
    public function setHeaders(array $headers)
    {
        $this->getRequest()->setHeaders($headers);

        return $this;
    }

    /**
     * Add headers to the request
     *
     * @param array $headers Array of (Key => Value) pairs
     *
     * @access public
     * @see    Request::addHeaders()
     * @return self
     */
    public function addHeaders(array $headers)
    {
        $this->getRequest()->addHeaders($headers);

        return $this;
    }

    /**
     * Clear all headers from the request
     *
     * @access public
     * @see    Request::setHeaders()
     * @return self
     */
    public function clearHeaders()
    {
        $this->getRequest()->setHeaders([]);

        return $this;
    }

    /**
     * Get the configured base URL for all requests
     *
     * @access public
     * @return string|null
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Set the base URL for all requests
     *
     * @param string|null $url Base URL | Null to remove
     *
     * @access public
     * @return self
     */
    public function setBaseUrl($url)
    {
        $this->baseUrl = $url;
        $this->getRequest()->setUrl($this->getBaseUrl());

        return $this;
    }

    /**
     * Get the RequestInterface instance
     *
     * @access public
     * @return RequestInterface
     */
    public function getRequest()
    {
        if (null === $this->request) {
            $this->setRequest(RequestBuilder::build());
        }

        return $this->request;
    }

    /**
     * Set the RequestInterface instance
     *
     * @param RequestInterface $request RequestInterface instance
     *
     * @access public
     * @return self
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Execute a HEAD request
     *
     * @param array $params Parameters to include in the request.
     *                      These parameters will be added to the URL
     *
     * @access public
     * @return ResponseInterface
     */
    public function head($params = [])
    {
        $this->getRequest()
            ->setMethod(HttpRequestMethod::HEAD)
            ->setParams($params);

        return $this->handle($this->getRequest());
    }

    /**
     * Execute a GET request
     *
     * @param array $params Parameters to include in the request
     *
     * @access public
     * @return ResponseInterface
     */
    public function get($params = [])
    {
        $this->getRequest()
            ->setMethod(HttpRequestMethod::GET)
            ->setParams($params);

        return $this->handle($this->getRequest());
    }

    /**
     * Execute a POST request
     *
     * @param array $params Parameters to include in the request
     *
     * @access public
     * @return ResponseInterface
     */
    public function post($params = [])
    {
        $this->getRequest()
            ->setMethod(HttpRequestMethod::POST)
            ->setParams($params);

        return $this->handle($this->getRequest());
    }

    /**
     * Execute a PUT request
     *
     * @param array|mixed|object $params Parameters to include in the request
     *
     * @access public
     * @return ResponseInterface
     */
    public function put($params = [])
    {
        $this->getRequest()
            ->setMethod(HttpRequestMethod::PUT)
            ->setParams($params);

        return $this->handle($this->getRequest());
    }

    /**
     * Execute a DELETE request
     *
     * @param array $params Parameters to include in the request
     *
     * @access public
     * @return ResponseInterface
     */
    public function delete($params = [])
    {
        $this->getRequest()
            ->setMethod(HttpRequestMethod::DELETE)
            ->setParams($params);

        return $this->handle($this->getRequest());
    }
}
