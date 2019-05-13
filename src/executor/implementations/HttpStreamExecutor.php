<?php

namespace Comertis\Http\Internal;

use Comertis\Http\HttpResult;
use Comertis\Http\HttpRequest;
use Comertis\Http\HttpResponse;
use Comertis\Http\HttpRequestMethod;
use Comertis\Http\HttpRequestBodyType;
use Comertis\Http\Internal\IHttpExecutor;

class HttpStreamExecutor implements IHttpExecutor
{
    /**
     * Stream context options
     *
     * @access private
     * @var array
     */
    private $_options;

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
        $this->_options = [
            'http' => [
                'method'  => $request->getMethod(),
                'header' => ''
            ]
        ];

        foreach ($request->getHeaders() as $key => $value) {
            $this->_options['http']['header'] .= $key . "=" . $value . ";";
        }

        if (!empty($bodyType = $request->getBodyType())) {
            $this->_options['http']['header'] .= "Content-Type: " . $bodyType . ";";
        }
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
        $params = [];
        if (empty($params = $request->getParams())) {
            return;
        }

        switch ($request->getBodyType()) {
            case HttpRequestBodyType::JSON:
                $params = json_encode($params);
                break;

            case HttpRequestBodyType::X_WWW_FORM_URLENCODED:
            default:
                $params = http_build_query($params);
                break;
        }

        $this->_options['http']['content'] = $params;
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
        $responseInfo = [];
        $responseHeaders = [];
        $responseBody = null;
        $responseStatusCode = 500;

        $context = stream_context_create($this->_options);

        $stream = @fopen($request->getUrl(), 'r', false, $context);

        if ($stream) {
            $responseInfo = stream_get_meta_data($stream);
        } else {
            $responseInfo['wrapper_data'] = $http_response_header;
        }

        // Headers
        $headers = $responseInfo['wrapper_data'];
        for ($i = 1; $i < count($headers); $i++) {
            $currentHeader = explode(":", $headers[$i], 2);
            $responseHeaders[\trim($currentHeader[0])] = \trim($currentHeader[1]);
        }

        // Body
        if ($stream) {
            $responseBody = stream_get_contents($stream);
        }

        // Status Code
        $match = [];
        $status_line = $responseInfo['wrapper_data'][0];

        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);

        $responseStatusCode = (int)$match[1];

        // Cleanup
        if ($stream) {
            fclose($stream);
        }

        $response = new HttpResponse($responseHeaders, $responseStatusCode, $responseBody);

        return new HttpResult($request, $response);
    }
}
