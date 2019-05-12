<?php

namespace Comertis\Http\Internal;

class HttpContextExecutor implements IHttpExecutor
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
        $params = null;
        if (empty($params = $request->getParams())) {
            return;
        }

        if ($request->getMethod() == HttpRequestMethod::GET) {

            $url = $request->getUrl();
            $url .= "?";

            foreach ($params as $key => $value) {
                $url .= $key . "=" . $value . "&";
            }

            $url = trim($url, "&");

            $request->setUrl($url);
        }
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
        
    }
}
