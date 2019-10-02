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

namespace Subsession\Http\Extensions;

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian@subsession.org>
 */
trait Headers
{
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
