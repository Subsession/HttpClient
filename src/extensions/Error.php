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
