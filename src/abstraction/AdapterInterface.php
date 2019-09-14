<?php
/**
 * PHP Version 7
 *
 * LICENSE:
 * Proprietary, see the LICENSE file that was provided with the software.
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

namespace Subsession\Http\Abstraction;

use Subsession\Http\Abstraction\RequestInterface;
use Subsession\Http\Abstraction\ResponseInterface;

/**
 * Defines the minimum necessary for a HttpExecutor
 * implementation regardless of used library or extension
 *
 * @category Http
 * @package  Subsession\Http
 * @author   Cristian Moraru <cristian.moraru@live.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Subsession/HttpClient
 */
interface AdapterInterface
{
    /**
     * Execute the RequestInterface and return a ResponseInterface instance
     *
     * @param RequestInterface $request RequestInterface instance
     *
     * @access public
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request);
}
