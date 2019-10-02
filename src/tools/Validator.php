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

namespace Subsession\Http\Tools;

/**
 * Builder class for AdapterInterface implementations
 *
 * @author Cristian Moraru <cristian@subsession.org>
 */
class Validator
{
    /**
     * Check if an instance implements a certain class/interface
     *
     * @param object $implementation
     * @param string $expected
     *
     * @static
     * @access public
     * @return bool
     */
    public static function implements($implementation, $expected)
    {
        return in_array($expected, class_implements($implementation));
    }
}
