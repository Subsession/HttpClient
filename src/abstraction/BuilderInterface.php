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

namespace Subsession\Http\Abstraction;

/**
 * Defines the minimum necessary for a HttpExecutor
 * implementation regardless of used library or extension
 *
 * @author Cristian Moraru <cristian@subsession.org>
 */
interface BuilderInterface
{
    /**
     * Build an instance of the implementation class
     *
     * @access public
     * @return object
     */
    public function build();
}
