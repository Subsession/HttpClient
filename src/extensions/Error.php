<?php

/**
 * PHP Version 7
 *
 * LICENSE:
 * See the LICENSE file that was provided with the software.
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
trait Error
{
    /**
     * Response error message
     *
     * @access private
     * @var    string
     */
    private $error;

    /**
     * Get the response error
     *
     * @access public
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set the response error
     *
     * @param string $error Error message
     *
     * @access public
     * @return static
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }
}
