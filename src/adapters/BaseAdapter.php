<?php
/**
 * PHP Version 7
 *
 * LICENSE:
 * Proprietary, see the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Comertis <info@comertis.com>
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
 * @version  GIT: &Id&
 * @link     https://github.com/Comertis/HttpClient
 */

namespace Comertis\Http\Adapters;

use Comertis\Http\Abstraction\AdapterInterface;
use Comertis\Http\Abstraction\RequestInterface;
use Comertis\Http\Abstraction\ResponseInterface;

/**
 * Undocumented class
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
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
    const EXPECTED_EXTENSIONS = [

    ];

    /**
     * Expected functions for this AdapterInterface implementation
     * to work properly
     *
     * @access public
     * @var    array
     */
    const EXPECTED_FUNCTIONS = [

    ];

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
        $this->prepareUrl($request);
        $this->prepareHeaders($request);
        $this->prepareParams($request);
    }
}
