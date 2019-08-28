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

use Comertis\Http\Builders\AdapterBuilder;

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
     * Responsible for executing a Request
     *
     * @access private
     * @see    AdapterInterface
     * @var    AdapterInterface
     */
    private $adapter;

    /**
     * Get the explicitly specified AdapterInterface implementation
     * used for requests
     *
     * @access public
     * @return AdapterInterface|null
     */
    public function getAdapter()
    {
        if (null === $this->adapter) {
            $this->setAdapter(AdapterBuilder::build());
        }

        return $this->adapter;
    }

    /**
     * Set the AdapterInterface implementation to use
     *
     * Either pass an implementation of AdapterInterface or
     * the fully qualified class name of an implementation.
     *
     * Ex:
     * ```php
     *    // With class name
     *    $client->setAdapter(CurlAdapter::class);
     *
     *    // With implementation
     *    $adapter = AdapterBuilder::build();
     *    $client->setAdapter($adapter);
     * ```
     *
     * @param string|AdapterInterface $adapter
     *
     * @access public
     * @see    AdapterInterface
     * @return static
     */
    public function setAdapter($adapter)
    {
        if ($adapter instanceof AdapterInterface) {
            $this->adapter = $adapter;
        } else {
            $this->adapter = AdapterBuilder::build($adapter);
        }

        return $this;
    }
}
