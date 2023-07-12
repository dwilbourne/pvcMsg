<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg;

use pvc\msg\err\InvalidDomainCatalogFileException;

/**
 * Class CatalogFileLoader
 */
class DomainCatalogFileLoaderPHP extends DomainCatalogFileLoader
{
    /**
     * getFileType
     * @return string
     */
    public function getFileType(): string
    {
        return 'php';
    }

    public function parseDomainCatalogFile(string $filepath): array
    {
        /**
         * if file is not parsable, engine will throw a parse error, which we are not going to try to catch.
         */
        $messages = include($filepath);

        if (!is_array($messages)) {
            throw new InvalidDomainCatalogFileException();
        }

        foreach ($messages as $key => $message) {
            if (!is_string($key)) {
                throw new InvalidDomainCatalogFileException();
            }
            if (!is_string($message)) {
                throw new InvalidDomainCatalogFileException();
            }
        }

        return $messages;
    }
}
