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
trait Body
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
     * @return static
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }
}
