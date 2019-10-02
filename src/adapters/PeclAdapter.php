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

namespace Subsession\Http\Adapters;

use Subsession\Exceptions\NotImplementedException;

use Subsession\Http\{
    Abstraction\RequestInterface,
    Abstraction\ResponseInterface,
    Adapters\BaseAdapter
};

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian.moraru@live.com>
 */
class PeclAdapter extends BaseAdapter
{
    /**
     * Expected extensions for this AdapterInterface implementation
     * to work properly
     *
     * @access public
     * @var    array
     */
    const EXPECTED_EXTENSIONS = [];

    /**
     * Expected functions for this AdapterInterface implementation
     * to work properly
     *
     * @access public
     * @var    array
     */
    const EXPECTED_FUNCTIONS = [];

    /**
     * @inheritDoc
     *
     * @access public
     * @throws NotImplementedException
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        throw new NotImplementedException();
    }
}
