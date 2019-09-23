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

use Subsession\Http\Abstraction\AdapterInterface;
use Subsession\Http\Abstraction\RequestInterface;
use Subsession\Http\Abstraction\ResponseInterface;

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
abstract class BaseAdapter implements AdapterInterface
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
     * @return boolean
     */
    public static function isAvailable()
    {
        foreach (static::EXPECTED_EXTENSIONS as $key => $extension) {
            if (!extension_loaded($extension)) {
                return false;
            }
        }

        foreach (static::EXPECTED_FUNCTIONS as $key => $function) {
            if (!function_exists($function)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     *
     * @param RequestInterface $request
     *
     * @access public
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        //
    }
}
