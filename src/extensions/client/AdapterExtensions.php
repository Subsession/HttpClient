<?php
/**
 * PHP Version 7
 *
 * LICENSE:
 * Permission is hereby granted, free of charge, to any
 * person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the
 * Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall
 * be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  GIT: &Id&
 * @link     https://github.com/Comertis/HttpClient
 */

namespace Comertis\Http\Extensions\Client;

use Comertis\Http\Builders\HttpAdapterBuilder;

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
trait AdapterExtensions
{
    /**
     * Responsible for executing a HttpRequest
     *
     * @access private
     * @see    HttpAdapterInterface
     * @var    HttpAdapterInterface
     */
    private $adapter;

    /**
     * Get the explicitly specified HttpAdapterInterface implementation
     * used for requests
     *
     * @access public
     * @return HttpAdapterInterface|null
     */
    public function getAdapter()
    {
        if (null === $this->adapter) {
            $this->setAdapter(HttpAdapterBuilder::build());
        }

        return $this->adapter;
    }

    /**
     * Set the HttpAdapterInterface implementation to use
     *
     * Either pass an implementation of HttpAdapterInterface or
     * the fully qualified class name of an implementation.
     *
     * Ex:
     * ```php
     *    // With class name
     *    $client->setAdapter(HttpCurlAdapter::class);
     *
     *    // With implementation
     *    $adapter = HttpAdapterBuilder::build();
     *    $client->setAdapter($adapter);
     * ```
     *
     * @param string|HttpAdapterInterface $adapter
     *
     * @access public
     * @see    HttpAdapterInterface
     * @return self
     */
    public function setAdapter($adapter)
    {
        if ($adapter instanceof HttpAdapterInterface) {
            $this->adapter = $adapter;
        } else {
            $this->adapter = HttpAdapterBuilder::build($adapter);
        }

        return $this;
    }
}
