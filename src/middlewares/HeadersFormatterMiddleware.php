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

use Comertis\Exceptions\InvalidOperationException;
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
class HeadersFormatterMiddleware implements MiddlewareInterface
{
    /**
     * @inheritDoc
     *
     * @param RequestInterface $request
     *
     * @throws InvalidOperationException
     * @access public
     * @return void
     */
    public function onRequest(RequestInterface &$request)
    {
        $method = $request->getMethod();

        // No added headers for GET & HEAD requests
        if ($method === HttpRequestMethod::GET || $method === HttpRequestMethod::HEAD) {
            return;
        }

        $params = $request->getParams();
        $contentLength = 0;

        if (is_array($params)) {
            foreach ($params as $key => $value) {
                if (is_object($value)) {
                    $contentLength += strlen(serialize($value));
                } else {
                    $contentLength += strlen($value);
                }
            }
        } elseif (is_object($params)) {
            $contentLength = strlen(serialize($params));
        } else {
            $contentLength = strlen($params);
        }

        $request->addHeaders(["Content-Length" => $contentLength]);

        switch ($request->getBodyType()) {
            case HttpRequestType::JSON:
                $request->addHeaders(["Content-Type" => HttpRequestType::JSON]);
                break;

            default:
                break;
        }
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