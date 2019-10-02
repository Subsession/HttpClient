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

namespace Subsession\Http\Abstraction;

use Subsession\Http\Abstraction\{
    RequestInterface,
    ResponseInterface
};

/**
 * Defines the minimum necessary for a HttpExecutor
 * implementation regardless of used library or extension
 *
 * @author Cristian Moraru <cristian.moraru@live.com>
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
