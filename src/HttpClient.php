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

namespace Comertis\Http;

use Comertis\Http\Abstraction\HttpClientInterface;
use Comertis\Http\Abstraction\HttpRequestInterface;
use Comertis\Http\Abstraction\HttpResponseInterface;

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
class HttpClient implements HttpClientInterface
{
    use \Comertis\Http\Extensions\Client\RequestExtensions;
    use \Comertis\Http\Extensions\Client\ResponseExtensions;
    use \Comertis\Http\Extensions\Client\InterceptorExtensions;
    use \Comertis\Http\Extensions\Client\AdapterExtensions;

    /**
     * Handle the HttpRequestInterface
     *
     * This handles the HttpInterceptor calls and the
     * HttpAdapterInterface::handle() call.
     *
     * @param HttpRequestInterface $request
     *
     * @access public
     * @return HttpResponseInterface
     */
    public function handle(HttpRequestInterface $request)
    {
        $response = $this->getAdapter()->handle($request);
        $this->setResponse($response);

        return $response;
    }
}
