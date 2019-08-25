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

namespace Comertis\Http\Extensions\Client;

use Comertis\Http\Abstraction\ResponseInterface;
use Comertis\Http\Builders\ResponseBuilder;

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
trait ResponseExtensions
{
    /**
     * Holds the response information once a request has been executed
     *
     * @access private
     * @see    Response
     * @var    ResponseInterface
     */
    private $response;

    /**
     * Get the Response instance after executing
     * a RequestInterface
     *
     * This returns null if called before executing
     * the RequestInterface.
     *
     * @access public
     * @return ResponseInterface
     */
    public function getResponse()
    {
        if (null === $this->response) {
            $this->setResponse(ResponseBuilder::build());
        }

        return $this->response;
    }

    /**
     * Set the ResponseInterface instance
     *
     * This should never be used explicitly in
     * normal use-cases, this method exists for
     * consistency reasons.
     *
     * @param ResponseInterface $response ResponseInterface instance
     *
     * @access public
     * @return self
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;

        return $this;
    }
}
