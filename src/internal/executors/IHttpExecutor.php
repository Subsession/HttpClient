<?php

namespace Comertis\Http\Internal\Executors;

use Comertis\Http\HttpRequest;

/**
 * Defines the minimum necessary for a HttpExecutor
 * implemtntation regardless of used library or extension
 */
interface IHttpExecutor
{
    /**
     * Make any necessary changes to the HttpRequest URL before executing
     *
     * @param HttpRequest $request
     * @access public
     * @return void
     */
    public function prepareUrl(HttpRequest &$request);

    /**
     * Make any necessary changes to the HttpRequest headers before executing
     *
     * @param HttpRequest $request
     * @access public
     * @return void
     */
    public function prepareHeaders(HttpRequest &$request);

    /**
     * Make any necessary changes to the HttpRequest parameters before executing
     *
     * @param HttpRequest $request
     * @access public
     * @return void
     */
    public function prepareParams(HttpRequest &$request);

    /**
     * Execute the HttpRequest and return a HttpResult
     * which contains the HttpRequest and a HttpResponse
     *
     * @param HttpRequest $request
     * @access public
     * @return HttpResult
     */
    public function execute(HttpRequest $request);
}
