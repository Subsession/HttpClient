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

namespace Comertis\Http\Adapters;

use Comertis\Http\Abstraction\RequestInterface;
use Comertis\Http\Adapters\BaseAdapter;
use Comertis\Http\Builders\ResponseBuilder;

/**
 * AdapterInterface implementation using the CURL
 * PHP extension
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
class CurlAdapter extends BaseAdapter
{
    /**
     * CURL instance
     *
     * @access private
     * @var    resource
     */
    private $ch;

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
     * Constructor
     */
    public function __construct()
    {
        try {
            $this->ch = curl_init();
        } catch (\Throwable $exception) {
            // Ignored for now
        }
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        if (is_resource($this->ch)) {
            curl_close($this->ch);
        }
    }

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

        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($this->ch, CURLOPT_URL, $request->getUrl());
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $request->getHeaders());
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $request->getMethod());
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $request->getParams());

        curl_setopt(
            $this->ch,
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
        $body = curl_exec($this->ch);

        if (curl_errno($this->ch)) {
            $curlError = curl_error($this->ch);
        }

        /** @var array $curlInfo */
        $curlInfo = curl_getinfo($this->ch);

        /** @var int $statusCode */
        $statusCode = $curlInfo['http_code'];

        /** @var ResponseInterface $response */
        $response = ResponseBuilder::build();
        $response->setHeaders($headers)
            ->setStatusCode($statusCode)
            ->setBody($body)
            ->setError($curlError);

        return $response;
    }
}
