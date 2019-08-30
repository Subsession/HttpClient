<?php

/**
 * PHP Version 7
 *
 * LICENSE:
 * See the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Subsession
 *
 * @category Http
 * @package  Subsession\Http
 * @author   Cristian Moraru <cristian.moraru@live.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  GIT: &Id&
 * @link     https://github.com/Subsession/HttpClient
 */

namespace Subsession\Http\Extensions\Client;

use InvalidArgumentException;
use Subsession\Http\Builders\AdapterBuilder;
use Subsession\Http\Abstraction\AdapterInterface;

/**
 * Undocumented class
 *
 * @category Http
 * @package  Subsession\Http
 * @author   Cristian Moraru <cristian.moraru@live.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  Release: 1.0.0
 * @link     https://github.com/Subsession/HttpClient
 */
trait AdapterExtensions
{
    /**
     * Responsible for executing a Request
     *
     * @access private
     * @see    AdapterInterface
     * @var    AdapterInterface|null
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
            $this->setAdapter(AdapterBuilder::getInstance()->build());
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
     *    // With implementation
     *    AdapterBuilder::setImplementation(CurlAdapter::class);
     *    $adapter = AdapterBuilder::getInstance()->build();
     *    $client->setAdapter($adapter);
     *
     *    // With class name
     *    $client->setAdapter(CurlAdapter::class);
     * ```
     *
     * @param AdapterInterface|string $adapter
     *
     * @access public
     * @see    AdapterInterface
     * @throws InvalidArgumentException If the given adapter is not an instance of AdapterInterface
     * @return static
     */
    public function setAdapter($adapter)
    {
        if ($adapter instanceof AdapterInterface) {
            $this->adapter = $adapter;
        } elseif (is_string($adapter)) {
            AdapterBuilder::setImplementation($adapter);
            $this->adapter = AdapterBuilder::getInstance()->build();
        } else {
            throw new InvalidArgumentException("Adapter is not an instance of AdapterInterface");
        }

        return $this;
    }
}
