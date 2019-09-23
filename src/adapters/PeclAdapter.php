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

namespace Subsession\Http\Adapters;

use Subsession\Exceptions\NotImplementedException;
use Subsession\Http\Abstraction\RequestInterface;
use Subsession\Http\Abstraction\ResponseInterface;
use Subsession\Http\Adapters\BaseAdapter;

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
