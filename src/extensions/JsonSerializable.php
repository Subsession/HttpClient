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
trait JsonSerializable
{
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
