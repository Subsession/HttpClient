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

namespace Subsession\Http\Extensions\Client;

use Subsession\Http\Abstraction\ResponseInterface;
use Subsession\Http\HttpRequestMethod;
use Subsession\Http\HttpRequestType;

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
trait RequestJsonExtensions
{
    /**
     * Execute a POST request with JSON formatted parameters
     *
     * @param array|mixed|object $params Parameters to include in the request
     *
     * @access public
     * @return ResponseInterface
     */
    public function postJson($params = [])
    {
        $this->getRequest()
            ->setMethod(HttpRequestMethod::POST)
            ->setBodyType(HttpRequestType::JSON)
            ->setParams($params);

        return $this->handle($this->getRequest());
    }

    /**
     * Execute a PUT request with JSON formatted parameters
     *
     * @param array|mixed|object $params Parameters to be json encoded
     *
     * @access public
     * @return ResponseInterface
     */
    public function putJson($params = [])
    {
        $this->getRequest()
            ->setMethod(HttpRequestMethod::PUT)
            ->setBodyType(HttpRequestType::JSON)
            ->setParams($params);

        return $this->handle($this->getRequest());
    }

    /**
     * Execute a DELETE request with JSON encoded parameters
     *
     * @param array $params Parameters to be json encoded
     *
     * @access public
     * @return ResponseInterface
     */
    public function deleteJson($params = [])
    {
        $this->getRequest()
            ->setMethod(HttpRequestMethod::DELETE)
            ->setBodyType(HttpRequestType::JSON)
            ->setParams($params);

        return $this->handle($this->getRequest());
    }
}
