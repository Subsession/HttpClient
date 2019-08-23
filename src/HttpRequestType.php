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

namespace Comertis\Http;

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
class HttpRequestType
{
    const NONE = "NONE";
    const FORM_DATA = "FORM_DATA";
    const X_WWW_FORM_URLENCODED = "application/x-www-form-urlencoded";
    const TEXT = "application/text";
    const TEXT_PLAIN = "text/plain";
    const JSON = "application/json";
    const JAVASCRIPT = "application/javascript";
    const XML = "application/xml";
    const HTML = "application/html";
    const BINARY = "BINARY";
}
