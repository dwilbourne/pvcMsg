<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvc\msg\catalog;

use Exception;
use pvc\interfaces\msg\DomainCatalogLoaderInterface;

/**
 * Class DomainCatalogFileLoader
 */
abstract class DomainCatalogFileLoader implements DomainCatalogLoaderInterface
{
    /**
     * @var array <string>
     * $basenameParts just temporary storage until we know that the messages are parsed out
     * of the file correctly and the filename is of the correct form so we can determine domain and locale.
     * Once we know those things, then we can hydrate the object's publicly available attributes all at once,
     * insuring that it is not in some invalid state where we have some publicly accessible attributes set
     * and not others.
     */
    protected array $basenameParts;

    /**
     * @var string
     */
    protected string $domainCatalogFilename;

    /**
     * @var string
     */
    protected string $domain;

    /**
     * @var string
     */
    protected string $locale;

    /**
     * @var array<string>
     */
    protected array $messages;

    /**
     * @param string $filename
     */
    public function setDomainCatalogFilename(string $filename): void
    {
        // Basename is everything after the directory in which the file lives.  There should be 3 parts
        // to the basename, separated by dots, e.g. <messageDomain>.<locale>.<filetype>
        $parts = explode('.', pathinfo($filename, PATHINFO_BASENAME));
        if (3 != count($parts)) {
            $msg = 'Bad domain catalog filename.  It should be of the form <messageDomain>.<locale>.<filetype>';
            throw new Exception($msg);
        }

        if (!file_exists($filename)) {
            throw new Exception('Invalid message catalog - file does not exist: ' . $filename);
        }

        $this->basenameParts = $parts;
        $this->domainCatalogFilename = $filename;
    }

    /**
     * @return string|null
     */
    public function getDomainCatalogFilename():? string
    {
        return $this->domainCatalogFilename ?? null;
    }

    /**
     * @return string
     * getting the domain before having loaded the file should produce an error
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return string
     * getting the locale before having loaded the file should produce an error
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @return array<string>
     * getting the messages before having loaded the file should produce an error
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * loadCatalog
     * @throws Exception
     */
    public function loadCatalog() : void
    {
        if (is_null($this->getDomainCatalogFilename())) {
            throw new Exception('Domain catalog filename must be set before calling loadCatalog.');
        }
        // parse the messages out of the file first
        $this->messages = $this->parseDomainCatalogFile();

        // if we got this far then everything is in order and we can hydrate this object
        $this->domain = $this->basenameParts[0];
        $this->locale = $this->basenameParts[1];
    }

    /**
     * parseDomainCatalogFile
     * @return array<string, string>
     */
    abstract public function parseDomainCatalogFile() : array;
}
