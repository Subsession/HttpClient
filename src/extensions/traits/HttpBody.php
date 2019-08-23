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

namespace Comertis\Http\Extensions\Traits;

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
trait HttpBody
{
    /**
     * Response body
     *
     * @access private
     * @var    mixed
     */
    private $body;

    /**
     * Get the response body
     *
     * @access public
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the response body
     *
     * @param string|mixed $body Response body
     *
     * @access public
     * @return self
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }
}
