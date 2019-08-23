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
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  GIT: &Id&
 * @link     https://github.com/Comertis/HttpClient
 */

namespace Comertis\Http\Adapters;

use Comertis\Http\Abstraction\HttpRequestInterface;
use Comertis\Http\Adapters\HttpBaseAdapter;
use Comertis\Http\Exceptions\HttpNotImplementedException;

/**
 * Undocumented class
 *
 * @uses Comertis\Http\Exceptions\HttpNotImplementedException
 * @uses Comertis\Http\HttpRequest
 * @uses Comertis\Http\Adapters\HttpAdapterInterface
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
class HttpPeclAdapter extends HttpBaseAdapter
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
     * @throws     HttpNotImplementedException
     */
    public function prepareUrl(HttpRequestInterface &$request)
    {
        throw new HttpNotImplementedException("This function is not yet implemented");
    }

    /**
     * @inheritDoc
     * @throws     HttpNotImplementedException
     */
    public function prepareHeaders(HttpRequestInterface &$request)
    {
        throw new HttpNotImplementedException();
    }

    /**
     * @inheritDoc
     * @throws     HttpNotImplementedException
     */
    public function prepareParams(HttpRequestInterface &$request)
    {
        throw new HttpNotImplementedException();
    }

    /**
     * @inheritDoc
     * @throws     HttpNotImplementedException
     */
    public function execute(HttpRequestInterface $request)
    {
        throw new HttpNotImplementedException();
    }
}
