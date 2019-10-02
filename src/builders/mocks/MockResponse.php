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

namespace Subsession\Http\Builders\Mocks;

use Subsession\Http\HttpStatusCode;

/**
 * IMPORTANT: Do not use
 *
 * This class is intended for internal use only
 *
 * @internal
 * @author Cristian Moraru <cristian.moraru@live.com>
 */
class MockResponse
{
    public $statusCode = HttpStatusCode::OK;
    public $headers = [];
    public $body = null;
    public $error = null;
}
