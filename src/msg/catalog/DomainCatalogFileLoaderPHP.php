<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvc\msg\catalog;

use Exception;

/**
 * Class CatalogFileLoader
 */
class DomainCatalogFileLoaderPHP extends DomainCatalogFileLoader
{

    /**
     * parseDomainCatalogFile
     * @return array<string, string>
     * @throws Exception
     */
    public function parseDomainCatalogFile() : array
    {
        $filetype = $this->basenameParts[2];

        if ('php' != $filetype) {
            throw new Exception("Invalid message catalog - must be a php file which returns an array.");
        }

        // if file is not parsable, engine will throw a parse error, which we are not going to try to catch.
        $messages = include($this->domainCatalogFilename);

        if (!is_array($messages)) {
            throw new Exception("Invalid message catalog - must be a php file which returns an array.");
        }

        foreach ($messages as $key => $message) {
            if (!is_string($key)) {
                throw new Exception("Invalid message id found (" . $key . "), must be a string.");
            }
            if (!is_string($message)) {
                throw new Exception("Invalid message found (" . $message . "), must be a string.");
            }
        }

        return $messages;
    }
}
