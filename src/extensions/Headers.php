<?php
/**
 * PHP Version 7
 *
 * LICENSE:
 * Proprietary, see the LICENSE file that was provided with the software.
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

namespace Subsession\Http\Extensions;

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
trait Headers
{
    /**
     * Default request headers
     *
     * @access private
     * @var    array
     */
    private static $defaultHeaders = [
        "Cache-Control" => "max-age=0",
        "Connection" => "keep-alive",
        "Keep-Alive" => "300",
        "Accept" => "application/json,text/xml,application/xml,application/xhtml+xml,text/plain,image/png,*/*",
        "Accept-Charset" => "utf-8,ISO-8859-1",
    ];

    /**
     * HTTP headers
     *
     * @access private
     * @var    array
     */
    private $headers = [];

    /**
     * Get the request headers
     *
     * @access public
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set the request headers
     *
     * @param array $headers Request headers
     *
     * @access public
     * @return static
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Add headers to the request.
     * IMPORTANT: Overrides existing headers if
     * duplicate found
     *
     * @param array $headers Request headers
     *
     * @access public
     * @return void
     */
    public function addHeaders($headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    /**
     * Clear all request headers
     *
     * @access public
     * @return static
     */
    public function clearHeaders()
    {
        $this->setHeaders([]);

        return $this;
    }
}
