<?php

namespace Comertis\Http\Internal\Executors;

use Comertis\Http\Exceptions\HttpExecutorException;
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

    /**
     * Specific IHttpExecutor implementation to use
     *
     * @access private
     * @var string
     */
    private $_explicitExecutor;

    public function __construct()
    {
        $this->_retry = 1;
        $this->_explicitExecutor = null;
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
     * Get the configured explicit IHttpExecutor implementation
     *
     * @access public
     * @return string|null
     */
    public function getExplicitExecutor()
    {
        return $this->_explicitExecutor;
    }

    /**
     * Specify a explicit IHttpExecutor implementation to use
     *
     * @access public
     * @param string|array $executorImplementation
     * @return HttpExecutor
     */
    public function setExplicitExecutor($executorImplementation)
    {
        $this->_explicitExecutor = $executorImplementation;

        return $this;
    }

    /**
     * Execute the HttpRequest
     *
     * @access public
     * @param HttpRequest $request
     * @return HttpResult
     */
    public function execute(HttpRequest $request)
    {
        if (!is_null($this->_explicitExecutor)) {
            $executor = HttpExecutorFactory::getExplicitExecutor($this->_explicitExecutor);
        } else {
            $executor = HttpExecutorFactory::getExecutor();
        }

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
