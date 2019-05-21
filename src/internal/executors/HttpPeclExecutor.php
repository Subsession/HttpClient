<?php

namespace Comertis\Http\Internal\Executors;

require_once __DIR__ . '/../IHttpExecutor.php';

use Comertis\Http\Exceptions\HttpNotImplementedException;
use Comertis\Http\HttpRequest;
use Comertis\Http\Internal\IHttpExecutor;

class HttpPeclExecutor implements IHttpExecutor
{
    /**
     * @see IHttpExecutor::prepareUrl()
     *
     * @param HttpRequest $request
     * @access public
     * @return void
     */
    public function prepareUrl(HttpRequest &$request)
    {
        throw new HttpNotImplementedException("This function is not yet implemented");
    }

    /**
     * @see IHttpExecutor::prepareHeaders()
     *
     * @param HttpRequest $request
     * @access public
     * @return void
     */
    public function prepareHeaders(HttpRequest &$request)
    {
        throw new HttpNotImplementedException("This function is not yet implemented");
    }

    /**
     * @see IHttpExecutor::prepareParams()
     *
     * @param HttpRequest $request
     * @access public
     * @return void
     */
    public function prepareParams(HttpRequest &$request)
    {
        throw new HttpNotImplementedException("This function is not yet implemented");
    }

    /**
     * @see IHttpExecutor::execute()
     *
     * @param HttpRequest $request
     * @access public
     * @return HttpResult
     */
    public function execute(HttpRequest $request)
    {
        throw new HttpNotImplementedException("This function is not yet implemented");
    }
}
