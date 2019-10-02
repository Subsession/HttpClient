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

namespace Subsession\Http\Extensions;

/**
 * Undocumented class
 *
 * @author Cristian Moraru <cristian@subsession.org>
 */
trait ContentType
{
    /**
     * Content type
     *
     * @access private
     * @var    string
     */
    private $contentType;

    /**
     * Get content type
     *
     * @access public
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set content type
     *
     * @param string $contentType Content type
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Type
     * @see https://www.iana.org/assignments/media-types/media-types.xhtml
     *
     * @access public
     * @return static
     */
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }
}
