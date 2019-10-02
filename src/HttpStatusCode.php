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

namespace Subsession\Http;

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian.moraru@live.com>
 */
class HttpStatusCode
{
    const HTTP_CONTINUE = 100;
    const SWITCHING_PROTOCOLS = 101;
    const PROCESSING = 102;
    const EARLY_HINTS = 103;

    const OK = 200;
    const CREATED = 201;
    const ACCEPTED = 202;
    const NON_AUTHORITATIVE_INFORMATION = 203;
    const NO_CONTENT = 204;
    const RESET_CONTENT = 205;
    const PARTIAL_CONTENT = 206;
    const MULTI_STATUS = 207;
    const ALREADY_REPORTED = 208;
    const IM_USED = 226;

    const MULTIPLE_CHOICES = 300;
    const MOVED_PERMANENTLY = 301;
    const FOUND = 302;
    const SEE_OTHER = 303;
    const NOT_MODIFIED = 304;
    const USE_PROXY = 305;
    const RESERVED = 306;
    const TEMPORARY_REDIRECT = 307;
    const PERMANENTLY_REDIRECT = 308;

    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const PAYMENT_REQUIRED = 402;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const NOT_ACCEPTABLE = 406;
    const PROXY_AUTHENTICATION_REQUIRED = 407;
    const REQUEST_TIMEOUT = 408;
    const CONFLICT = 409;
    const GONE = 410;
    const LENGTH_REQUIRED = 411;
    const PRECONDITION_FAILED = 412;
    const REQUEST_ENTITY_TOO_LARGE = 413;
    const REQUEST_URI_TOO_LONG = 414;
    const UNSUPPORTED_MEDIA_TYPE = 415;
    const REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const EXPECTATION_FAILED = 417;
    const I_AM_A_TEAPOT = 418;
    const MISDIRECTED_REQUEST = 421;
    const UNPROCESSABLE_ENTITY = 422;
    const LOCKED = 423;
    const FAILED_DEPENDENCY = 424;
    const RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;
    const TOO_EARLY = 425;
    const UPGRADE_REQUIRED = 426;
    const PRECONDITION_REQUIRED = 428;
    const TOO_MANY_REQUESTS = 429;
    const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
    const UNAVAILABLE_FOR_LEGAL_REASONS = 451;

    const INTERNAL_SERVER_ERROR = 500;
    const NOT_IMPLEMENTED = 501;
    const BAD_GATEWAY = 502;
    const SERVICE_UNAVAILABLE = 503;
    const GATEWAY_TIMEOUT = 504;
    const VERSION_NOT_SUPPORTED = 505;
    const VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;
    const INSUFFICIENT_STORAGE = 507;
    const LOOP_DETECTED = 508;
    const NOT_EXTENDED = 510;
    const NETWORK_AUTHENTICATION_REQUIRED = 511;

    /**
     * 1xx range
     *
     * @var array
     */
    const INFORMATIONAL = [
        self::HTTP_CONTINUE => self::HTTP_CONTINUE,
        self::SWITCHING_PROTOCOLS => self::SWITCHING_PROTOCOLS,
        self::PROCESSING => self::PROCESSING,
        self::EARLY_HINTS => self::EARLY_HINTS,
    ];

    /**
     * 2xx range
     *
     * @var array
     */
    const SUCCESS = [
        self::OK => self::OK,
        self::CREATED => self::CREATED,
        self::ACCEPTED => self::ACCEPTED,
        self::NON_AUTHORITATIVE_INFORMATION => self::NON_AUTHORITATIVE_INFORMATION,
        self::NO_CONTENT => self::NO_CONTENT,
        self::RESET_CONTENT => self::RESET_CONTENT,
        self::PARTIAL_CONTENT => self::PARTIAL_CONTENT,
        self::MULTI_STATUS => self::MULTI_STATUS,
        self::ALREADY_REPORTED => self::ALREADY_REPORTED,
        self::IM_USED => self::IM_USED,
    ];

    /**
     * 3xx range
     *
     * @var array
     */
    const REDIRECTION = [
        self::MULTIPLE_CHOICES => self::MULTIPLE_CHOICES,
        self::MOVED_PERMANENTLY => self::MOVED_PERMANENTLY,
        self::FOUND => self::FOUND,
        self::SEE_OTHER => self::SEE_OTHER,
        self::NOT_MODIFIED => self::NOT_MODIFIED,
        self::USE_PROXY => self::USE_PROXY,
        self::RESERVED => self::RESERVED,
        self::TEMPORARY_REDIRECT => self::TEMPORARY_REDIRECT,
        self::PERMANENTLY_REDIRECT => self::PERMANENTLY_REDIRECT,
    ];

    /**
     * 4xx range
     *
     * @var array
     */
    const CLIENT_ERRORS = [
        self::BAD_REQUEST => self::BAD_REQUEST,
        self::UNAUTHORIZED => self::UNAUTHORIZED,
        self::PAYMENT_REQUIRED => self::PAYMENT_REQUIRED,
        self::FORBIDDEN => self::FORBIDDEN,
        self::NOT_FOUND => self::NOT_FOUND,
        self::METHOD_NOT_ALLOWED => self::METHOD_NOT_ALLOWED,
        self::NOT_ACCEPTABLE => self::NOT_ACCEPTABLE,
        self::PROXY_AUTHENTICATION_REQUIRED => self::PROXY_AUTHENTICATION_REQUIRED,
        self::REQUEST_TIMEOUT => self::REQUEST_TIMEOUT,
        self::CONFLICT => self::CONFLICT,
        self::GONE => self::GONE,
        self::LENGTH_REQUIRED => self::LENGTH_REQUIRED,
        self::PRECONDITION_FAILED => self::PRECONDITION_FAILED,
        self::REQUEST_ENTITY_TOO_LARGE => self::REQUEST_ENTITY_TOO_LARGE,
        self::REQUEST_URI_TOO_LONG => self::REQUEST_URI_TOO_LONG,
        self::UNSUPPORTED_MEDIA_TYPE => self::UNSUPPORTED_MEDIA_TYPE,
        self::REQUESTED_RANGE_NOT_SATISFIABLE => self::REQUESTED_RANGE_NOT_SATISFIABLE,
        self::EXPECTATION_FAILED => self::EXPECTATION_FAILED,
        self::I_AM_A_TEAPOT => self::I_AM_A_TEAPOT,
        self::MISDIRECTED_REQUEST => self::MISDIRECTED_REQUEST,
        self::UNPROCESSABLE_ENTITY => self::UNPROCESSABLE_ENTITY,
        self::LOCKED => self::LOCKED,
        self::FAILED_DEPENDENCY => self::FAILED_DEPENDENCY,
        self::RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL => self::RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL,
        self::TOO_EARLY => self::TOO_EARLY,
        self::UPGRADE_REQUIRED => self::UPGRADE_REQUIRED,
        self::PRECONDITION_REQUIRED => self::PRECONDITION_REQUIRED,
        self::TOO_MANY_REQUESTS => self::TOO_MANY_REQUESTS,
        self::REQUEST_HEADER_FIELDS_TOO_LARGE => self::REQUEST_HEADER_FIELDS_TOO_LARGE,
        self::UNAVAILABLE_FOR_LEGAL_REASONS => self::UNAVAILABLE_FOR_LEGAL_REASONS,
    ];

    /**
     * 5xx range
     *
     * @var array
     */
    const SERVER_ERRORS = [
        self::INTERNAL_SERVER_ERROR => self::INTERNAL_SERVER_ERROR,
        self::NOT_IMPLEMENTED => self::NOT_IMPLEMENTED,
        self::BAD_GATEWAY => self::BAD_GATEWAY,
        self::SERVICE_UNAVAILABLE => self::SERVICE_UNAVAILABLE,
        self::GATEWAY_TIMEOUT => self::GATEWAY_TIMEOUT,
        self::VERSION_NOT_SUPPORTED => self::VERSION_NOT_SUPPORTED,
        self::VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL => self::VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL,
        self::INSUFFICIENT_STORAGE => self::INSUFFICIENT_STORAGE,
        self::LOOP_DETECTED => self::LOOP_DETECTED,
        self::NOT_EXTENDED => self::NOT_EXTENDED,
        self::NETWORK_AUTHENTICATION_REQUIRED => self::NETWORK_AUTHENTICATION_REQUIRED,
    ];
}
