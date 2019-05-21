<?php

namespace Comertis\Http\Internal\Executors;

use Comertis\Http\HttpRequest;
use Comertis\Http\HttpRequestMethod;
use Comertis\Http\HttpRequestType;
use Comertis\Http\HttpResponse;
use Comertis\Http\HttpResult;
use Comertis\Http\Internal\Executors\IHttpExecutor;

require_once __DIR__ . '/IHttpExecutor.php';

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
                'method' => $request->getMethod(),
                'header' => '',
            ],
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
            case HttpRequestType::JSON:
                $params = json_encode($params);
                break;

            case HttpRequestType::X_WWW_FORM_URLENCODED:
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
        /**
         * @var array
         */
        $responseHeaders = [];

        /**
         * @var string|bool
         */
        $responseBody = false;

        /**
         * @var array
         */
        $responseInfo = [];

        /**
         * @var int
         */
        $responseStatusCode = 0;

        /**
         * @var string|null
         */
        $responseError = null;

        $context = stream_context_create($this->_options);

        $stream = @fopen($request->getUrl(), 'r', false, $context);

        if ($stream) {
            $responseInfo = stream_get_meta_data($stream);
            $responseBody = stream_get_contents($stream);
            fclose($stream);
        } else if (isset($http_response_header)) {
            $responseInfo['wrapper_data'] = $http_response_header;
        }

        if (isset($responseInfo['wrapper_data'])) {
            $headers = $responseInfo['wrapper_data'];

            for ($i = 1; $i < count($headers); $i++) {
                $currentHeader = explode(":", $headers[$i], 2);
                $responseHeaders[trim($currentHeader[0])] = trim($currentHeader[1]);
            }

            $match = [];
            $status_line = $responseInfo['wrapper_data'][0];

            preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);

            if (isset($match[1])) {
                $responseStatusCode = (int) $match[1];
            }
        }

        $response = new HttpResponse();
        $response->setBody($responseBody)
            ->setHeaders($responseHeaders)
            ->setStatusCode($responseStatusCode)
            ->setError($responseError);

        return new HttpResult($request, $response);
    }
}
