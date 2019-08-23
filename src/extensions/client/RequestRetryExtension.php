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
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  GIT: &Id&
 * @link     https://github.com/Comertis/HttpClient
 */

namespace Comertis\Http\Extensions\Client;

use Comertis\Http\Abstraction\HttpRequestInterface;

/**
 * Undocumented class
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Comertis/HttpClient
 */
trait RequestRetryExtension
{
    /**
     * Retry count for requests
     *
     * @access private
     * @var    int
     */
    private $retryCount = 1;

    /**
     * Get the configured retry count for requests
     *
     * @access public
     * @return int
     */
    public function getRetryCount()
    {
        return $this->retryCount;
    }

    /**
     * Set the retry count for requests
     *
     * @param int $retryCount
     *
     * @access public
     * @return self
     */
    public function setRetryCount($retryCount)
    {
        $this->retryCount = $retryCount;

        return $this;
    }

    /**
     * Retry a HttpRequestInterface
     *
     * @param HttpRequestInterface $request
     *
     * @access public
     * @return HttpResponseInterface
     */
    public function retry(callable $failCondition)
    {
        for ($i = 0; $i < $this->getRetryCount(); $i++) {
            /**
             * @var HttpResponseInterface $response
             */
            $response = $this->adapter->handle($this->request);

            $isValid = $failCondition($response);

            if ($isValid) {
                return $response;
            }
        }

        return $response;
    }
}
