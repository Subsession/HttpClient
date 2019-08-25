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
use Comertis\Http\Abstraction\RequestInterface;
use Comertis\Http\Adapters\BaseAdapter;

/**
 * Undocumented class
 *
 * @uses Comertis\Http\Exceptions\NotImplementedException
 * @uses Comertis\Http\Request
 * @uses Comertis\Http\Adapters\AdapterInterface
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
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
     * @throws     NotImplementedException
     */
    public function prepareUrl(RequestInterface &$request)
    {
        throw new NotImplementedException("This function is not yet implemented");
    }

    /**
     * @inheritDoc
     * @throws     NotImplementedException
     */
    public function prepareHeaders(RequestInterface &$request)
    {
        throw new NotImplementedException();
    }

    /**
     * @inheritDoc
     * @throws     NotImplementedException
     */
    public function prepareParams(RequestInterface &$request)
    {
        throw new NotImplementedException();
    }

    /**
     * @inheritDoc
     * @throws     NotImplementedException
     */
    public function execute(RequestInterface $request)
    {
        throw new NotImplementedException();
    }
}
