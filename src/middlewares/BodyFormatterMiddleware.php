<?php

/**
 * PHP Version 7
 *
 * LICENSE:
 * See the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Subsession
 *
 * @author Cristian Moraru <cristian.moraru@live.com>
 */

namespace Subsession\Http\Middlewares;

use Subsession\Exceptions\ArgumentException;

use Subsession\Http\{
    Abstraction\MiddlewareInterface,
    Abstraction\RequestInterface,
    Abstraction\ResponseInterface,
    HttpRequestMethod,
    HttpRequestType
};

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian.moraru@live.com>
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
