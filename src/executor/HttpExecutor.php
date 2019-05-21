<?php

namespace Comertis\Http\Internal\Executors;

use Comertis\Http\HttpExecutorException;
use Comertis\Http\HttpRequest;
use Comertis\Http\HttpStatusCode;
use Comertis\Http\Internal\Executors\HttpExecutorFactory;

class HttpExecutor
{
    /**
     * Request retry count
     *
     * @access private
     * @var int
     */
    private $_retry;

    public function __construct()
    {
        $this->_retry = 1;
    }

    /**
     * Get the configured retry count for requests
     *
     * @access public
     * @return int
     */
    public function getRetryCount()
    {
        return $this->_retry;
    }

    /**
     * Set the number of times to retry a request
     * in case of failing to get a response
     *
     * @access public
     * @param int $retryCount
     * @return HttpExecutor
     */
    public function setRetryCount($retryCount)
    {
        $this->_retry = $retryCount;

        return $this;
    }

    /**
     * Execute the HttpRequest
     *
     * @param HttpRequest $request
     * @access public
     * @return HttpResult
     */
    public function execute(HttpRequest $request)
    {
        $executor = HttpExecutorFactory::getExecutor();

        $executor->prepareUrl($request);
        $executor->prepareHeaders($request);
        $executor->prepareParams($request);

        for ($i = 0; $i < $this->getRetryCount(); $i++) {
            $result = $executor->execute($request);

            if ($result->getResponse()->getStatusCode() != HttpStatusCode::INTERNAL_SERVER_ERROR) {
                return $result;
            }
        }

        throw new HttpExecutorException("Failed to get response after " . $this->getRetryCount() . " tries.");
    }
}
