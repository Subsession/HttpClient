<?php

/**
 * PHP Version 7
 *
 * LICENSE:
 * See the LICENSE file that was provided with the software.
 *
 * Copyright (c) 2019 - present Subsession
 *
 * @author Cristian Moraru <cristian@subsession.org>
 */

namespace Subsession\Http\Extensions\Client;

use Subsession\Http\{
    Builders\AdapterBuilder,
    Abstraction\AdapterInterface
};

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian@subsession.org>
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
     * @throws \Subsession\Exceptions\InvalidArgumentException
     * @access public
     * @see    AdapterInterface
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
            $error = "$adapter is not an instance of AdapterInterface";
            throw new \Subsession\Exceptions\InvalidArgumentException($error);
        }

        return $this;
    }
}
