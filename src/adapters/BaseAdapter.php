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

namespace Subsession\Http\Adapters;

use Subsession\Http\Abstraction\{
    AdapterInterface,
    RequestInterface,
    ResponseInterface
};

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian@subsession.org>
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
    abstract public function handle(RequestInterface $request);
}
