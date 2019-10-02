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

namespace Subsession\Http\Builders\Mocks;

use Subsession\Http\HttpRequestMethod;

/**
 * IMPORTANT: Do not use
 *
 * This class is intended for internal use only
 *
 * @internal
 * @author Cristian Moraru <cristian@subsession.org>
 */
class MockRequest
{
    public $url = null;
    public $headers = [];
    public $method = HttpRequestMethod::GET;
    public $params = [];
    public $bodyType = null;
}
