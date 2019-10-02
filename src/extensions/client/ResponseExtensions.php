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

namespace Subsession\Http\Extensions\Client;

use Subsession\Http\Abstraction\ResponseInterface;

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian@subsession.org>
 */
trait ResponseExtensions
{
    /**
     * Holds the response information once a request has been executed
     *
     * @access private
     * @see    Response
     * @var    ResponseInterface|null
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
     * @return ResponseInterface|null
     */
    public function getResponse()
    {
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
     * @return static
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;

        return $this;
    }
}
