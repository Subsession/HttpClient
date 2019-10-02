<?php

/**
 * PHP Version 7
 *
 * LICENSE:
 * See the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Subsession
 *
 * @author Cristian Moraru <cristian@subsession.org>
 */

namespace Subsession\Http\Adapters;

use Subsession\Http\{
    Abstraction\RequestInterface,
    Adapters\BaseAdapter,
    Builders\ResponseBuilder
};

/**
 * AdapterInterface implementation using the CURL
 * PHP extension
 *
 * @author Cristian Moraru <cristian@subsession.org>
 */
class CurlAdapter extends BaseAdapter
{
    /**
     * Expected extensions for this AdapterInterface implementation
     * to work properly
     *
     * @access public
     * @var    array
     */
    const EXPECTED_EXTENSIONS = [
        "curl",
    ];

    /**
     * Expected functions for this AdapterInterface implementation
     * to work properly
     *
     * @access public
     * @var    array
     */
    const EXPECTED_FUNCTIONS = [
        "curl_init",
        "curl_close",
        "curl_setopt",
        "curl_exec",
        "curl_errno",
        "curl_getinfo",
    ];

    /**
     * @inheritDoc
     */
    public function handle(RequestInterface $request)
    {
        /** @var array $headers */
        $headers = [];

        /** @var string|null $body */
        $body = null;

        /** @var array $curlInfo */
        $curlInfo = [];

        /** @var int $statusCode */
        $statusCode = 500;

        /** @var string|null $curlError */
        $curlError = null;

        /** @var resource $ch */
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_URL, $request->getUrl());
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request->getHeaders());
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request->getMethod());

        if (!empty($request->getParams())) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request->getParams());
        }

        curl_setopt(
            $ch,
            CURLOPT_HEADERFUNCTION,
            function ($curl, $header) use (&$headers) {
                $headerLength = strlen($header);
                $header = explode(':', $header, 2);

                if (count($header) < 2) {
                    return $headerLength;
                }

                $headers[trim($header[0])] = trim($header[1]);

                return $headerLength;
            }
        );

        /** @var string|bool $body */
        $body = curl_exec($ch);

        if (curl_errno($ch)) {
            /** @var string $curlError */
            $curlError = curl_error($ch);
        }

        /** @var array $curlInfo */
        $curlInfo = curl_getinfo($ch);

        /** @var int $statusCode */
        $statusCode = $curlInfo['http_code'];

        if (is_resource($ch)) {
            curl_close($ch);
        }

        /** @var ResponseInterface $response */
        $response = ResponseBuilder::getInstance()->build();
        $response->setHeaders($headers)
            ->setStatusCode($statusCode)
            ->setBody($body)
            ->setError($curlError);

        return $response;
    }
}
