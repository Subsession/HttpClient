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

namespace Subsession\Http\Extensions;

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian.moraru@live.com>
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
