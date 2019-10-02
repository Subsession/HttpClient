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

use Subsession\Exceptions\InvalidOperationException;

use Subsession\Http\{
    Abstraction\MiddlewareInterface,
    Abstraction\RequestInterface,
    Abstraction\ResponseInterface,
    HttpRequestMethod,
};

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian.moraru@live.com>
 */
class UrlFormatterMiddleware implements MiddlewareInterface
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
        /** @var string $method */
        $method = $request->getMethod();

        if ($method !== HttpRequestMethod::GET && $method !== HttpRequestMethod::HEAD) {
            return;
        }

        /** @var array $params */
        $params = $request->getParams();

        if (empty($params)) {
            return;
        }

        /** @var string $url */
        $url = $request->getUrl();

        /** @var string $separator */
        $separator = "?";

        // If "?" already exists in the url
        if (strpos($url, $separator) !== false) {
            $separator = "&";
        }

        $url .= $separator . http_build_query($params);

        $request->setUrl($url);
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
