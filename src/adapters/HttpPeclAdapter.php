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

use Comertis\Exceptions\NotImplementedException;
use Comertis\Http\Abstraction\HttpRequestInterface;
use Comertis\Http\Adapters\HttpBaseAdapter;

/**
 * Undocumented class
 *
 * @uses Comertis\Http\Exceptions\NotImplementedException
 * @uses Comertis\Http\HttpRequest
 * @uses Comertis\Http\Adapters\HttpAdapterInterface
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
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
     * @throws     NotImplementedException
     */
    public function prepareUrl(HttpRequestInterface &$request)
    {
        throw new NotImplementedException("This function is not yet implemented");
    }

    /**
     * @inheritDoc
     * @throws     NotImplementedException
     */
    public function prepareHeaders(HttpRequestInterface &$request)
    {
        throw new NotImplementedException();
    }

    /**
     * @inheritDoc
     * @throws     NotImplementedException
     */
    public function prepareParams(HttpRequestInterface &$request)
    {
        throw new NotImplementedException();
    }

    /**
     * @inheritDoc
     * @throws     NotImplementedException
     */
    public function execute(HttpRequestInterface $request)
    {
        throw new NotImplementedException();
    }
}
