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

use Comertis\Http\Abstraction\HttpAdapterInterface;
use Comertis\Http\Abstraction\HttpRequestInterface;
use Comertis\Http\Abstraction\HttpResponseInterface;

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
abstract class HttpBaseAdapter implements HttpAdapterInterface
{
    /**
     * Expected extensions for this HttpAdapterInterface implementation
     * to work properly
     *
     * @access public
     * @var    array
     */
    const EXPECTED_EXTENSIONS = [

    ];

    /**
     * Expected functions for this HttpAdapterInterface implementation
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
     * @param HttpRequestInterface $request
     *
     * @access public
     * @return HttpResponseInterface
     */
    public function handle(HttpRequestInterface $request)
    {
        $this->prepareUrl($request);
        $this->prepareHeaders($request);
        $this->prepareParams($request);
    }
}
