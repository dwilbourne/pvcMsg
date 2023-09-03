<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg;

use pvc\interfaces\msg\DomainCatalogLoaderInterface;
use pvc\msg\err\NonExistentDomainCatalogDirectoryException;
use pvc\msg\err\NonExistentDomainCatalogFileException;

/**
 * Class DomainCatalogFileLoader
 */
abstract class DomainCatalogFileLoader implements DomainCatalogLoaderInterface
{
    /**
     * @var string
     */
    protected string $domainCatalogDirectory;

    /**
     * @param string $dirname
     * @throws NonExistentDomainCatalogDirectoryException
     */
    public function __construct(string $dirname)
    {
        $this->setDomainCatalogDirectory($dirname);
    }

    /**
     * setDomainCatalogDirectory
     * @param string $dirname
     * @throws NonExistentDomainCatalogDirectoryException
     */
    public function setDomainCatalogDirectory(string $dirname): void
    {
        if (!is_dir($dirname)) {
            throw new NonExistentDomainCatalogDirectoryException($dirname);
        }
        $this->domainCatalogDirectory = $dirname;
    }

    /**
     * @return string
     */
    public function getDomainCatalogDirectory(): string
    {
        return $this->domainCatalogDirectory ?? '';
    }

    /**
     * createCatalogFilenameFromDomainLocale
     * @param string $domain
     * @param string $locale
     * @return string
     */
    public function createCatalogFilenameFromDomainLocale(string $domain, string $locale): string
    {
        /**
         * construct catalog filename in the canonical form <domain>.<locale>.<filetype>
         */
        return ($domain . '.' . $locale . '.' . $this->getFileType());
    }

    /**
     * loadCatalog
     * @param string $domain
     * @param string $locale
     * @return string[]
     * @throws NonExistentDomainCatalogFileException
     */
    public function loadCatalog(string $domain, string $locale): array
    {
        $filepath = '';
        $filepath .= $this->getDomainCatalogDirectory() . DIRECTORY_SEPARATOR;
        $filepath .= $this->createCatalogFilenameFromDomainLocale($domain, $locale);

        if (!file_exists($filepath)) {
            throw new NonExistentDomainCatalogFileException($filepath);
        }
        return $this->parseDomainCatalogFile($filepath);
    }

    /**
     * getFileType
     * @return string
     * returns the file extension (type) that this loader can parse and load
     */
    abstract public function getFileType(): string;

    /**
     * parseDomainCatalogFile
     * @return array<string, string>
     */
    abstract public function parseDomainCatalogFile(string $filepath): array;
}
