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

namespace Comertis\Http\Middlewares;

use Comertis\Exceptions\ArgumentException;
use Comertis\Http\Abstraction\MiddlewareInterface;
use Comertis\Http\Abstraction\RequestInterface;
use Comertis\Http\Abstraction\ResponseInterface;
use Comertis\Http\HttpRequestMethod;
use Comertis\Http\HttpRequestType;

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
class BodyFormatterMiddleware implements MiddlewareInterface
{
    /**
     * @inheritDoc
     *
     * @param RequestInterface $request
     *
     * @throws ArgumentException If it fails to parse the request parameters
     * @access public
     * @return void
     */
    public function onRequest(RequestInterface &$request)
    {
        // No need to process
        if (empty($request->getParams())) {
            return;
        }

        $method = $request->getMethod();

        // No need to process
        if ($method === HttpRequestMethod::GET || $method === HttpRequestMethod::HEAD) {
            return;
        }

        $params = $request->getParams();

        switch ($request->getBodyType()) {
            case HttpRequestType::JSON:
                $params = json_encode($params);
                break;

            case HttpRequestType::X_WWW_FORM_URLENCODED:
            default:
                $params = http_build_query($params);
                break;
        }

        if (empty($params) || null === $params) {
            throw new ArgumentException("Failed to parse request parameters");
        }

        $request->setParams($params);
    }

    /**
     * @inheritDoc
     *
     * @param ResponseInterface $request
     *
     * @throws InvalidOperationException
     * @access public
     * @return void
     */
    public function onResponse(ResponseInterface &$response)
    {
        // Not used
    }
}
