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

namespace Comertis\Http\Extensions\Client;

use Comertis\Http\Builders\HttpAdapterBuilder;

/**
 * Undocumented class
 *
 * @category Http
 * @package  Comertis\Http
 * @author   Cristian Moraru <cristian@comertis.com>
 * @license  Proprietary
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
