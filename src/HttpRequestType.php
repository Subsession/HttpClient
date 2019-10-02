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

namespace Subsession\Http;

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian@subsession.org>
 */
class HttpRequestType
{
    const NONE = "NONE";
    const FORM_DATA = "multipart/form-data";
    const X_WWW_FORM_URLENCODED = "application/x-www-form-urlencoded";
    const TEXT = "application/text";
    const TEXT_PLAIN = "text/plain";
    const JSON = "application/json";
    const JAVASCRIPT = "application/javascript";
    const XML = "application/xml";
    const HTML = "application/html";
    const BINARY = "BINARY";
}
