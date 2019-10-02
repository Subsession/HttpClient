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

namespace Subsession\Http\Adapters;

use Subsession\Http\{
    Abstraction\RequestInterface,
    Adapters\BaseAdapter,
    Builders\ResponseBuilder
};

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian.moraru@live.com>
 */
class StreamAdapter extends BaseAdapter
{
    /**
     * Expected extensions for this AdapterInterface implementation
     * to work properly
     *
     * @access public
     * @var    array
     */
    const EXPECTED_EXTENSIONS = [];

    /**
     * Expected functions for this AdapterInterface implementation
     * to work properly
     *
     * @access public
     * @var    array
     */
    const EXPECTED_FUNCTIONS = [
        "stream_context_create",
        "fopen",
        "fclose",
        "stream_get_meta_data",
        "stream_get_contents",
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
        $streamInfo = [];

        /** @var int $statusCode */
        $statusCode = 500;

        /** @var string|null $curlError */
        $streamError = null;

        /** @var array $options */
        $options = [
            "http" => [
                "method" => strtoupper($request->getMethod()),
                "header" => "",
                "follow_location" => 1,
                "ignore_errors" => true,
            ],
        ];

        /**
         * @var string $key   Header key
         * @var string $value Header value
         */
        foreach ($request->getHeaders() as $key => $value) {
            $options["http"]["header"] .= $key . ":" . $value . ";";
        }

        /** @var string|null $bodyType */
        if (!empty($bodyType = $request->getBodyType())) {
            $options["http"]["header"] .= "Content-Type:" . $bodyType . ";";
        }

        $options["http"]["content"] = $request->getParams();

        /** @var resource $context */
        $context = stream_context_create($options);

        /** @var resource|bool $stream */
        $stream = @fopen($request->getUrl(), "r", false, $context);

        if ($stream) {
            $streamInfo = stream_get_meta_data($stream);
            $body = stream_get_contents($stream);
            @fclose($stream);
        } elseif (isset($http_response_header)) {
            $streamInfo["wrapper_data"] = $http_response_header;
        }

        if (isset($streamInfo["wrapper_data"])) {
            $headers = $streamInfo["wrapper_data"];

            // Set headers
            $headersCount = count($headers);
            for ($i = 1; $i < $headersCount; $i++) {
                $currentHeader = explode(":", $headers[$i], 2);
                $headers[trim($currentHeader[0])] = trim($currentHeader[1]);
            }

            // Set status code
            $match = [];
            $status_line = $streamInfo["wrapper_data"][0];

            preg_match("{HTTP\/\S*\s(\d{3})}", $status_line, $match);

            if (isset($match[1])) {
                $statusCode = (int) $match[1];
            }
        }

        /** @var ResponseInterface $response */
        $response = ResponseBuilder::getInstance()->build();
        $response->setHeaders($headers)
            ->setStatusCode($statusCode)
            ->setBody($body)
            ->setError($streamError);

        return $response;
    }
}
