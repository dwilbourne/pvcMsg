<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg;

use Locale;
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
        return $this->domainCatalogDirectory;
    }

    /**
     * getPossibleFilenamePartsFromLocale
     * @param string $locale
     * @return array<string>
     */
    protected function getPossibleFilenamePartsFromLocale(string $locale): array
    {
        /**
         * the order of this is important.  We want the more specific filename parts at the beginning and the most
         * generalized (e.g. just a language) at the end.
         *
         * Symfony uses the concept of a 'parent locale', which is a more sophisticated approach.  It requires the
         * construction of a set parent locales and their "children".  For example, Argentinian spanish would degrade
         * to south american spanish.
         *
         * If there is no catalog that works for the locale specified, try english as the default.
         */

        /** array_filter removes any empty strings */
        $localeArray = array_filter([
                                        Locale::getPrimaryLanguage($locale),
                                        Locale::getScript($locale),
                                        Locale::getRegion($locale)
                                    ]);
        /** @var array<string> $result */
        $result = [];
        while (count($localeArray) > 0) {
            $result[] = implode('_', $localeArray);
            array_pop($localeArray);
        }
        if (!in_array('en', $result)) {
            $result[] = 'en';
        }
        return $result;
    }

    /**
     * getCatalogFilePathFromDomainLocale
     * @param string $domain
     * @param string $locale
     * @return string
     */
    public function getCatalogFilePathFromDomainLocale(string $domain, string $locale = ''): string
    {
        /**
         * construct catalog filename in the canonical form <domain>.<locale>.<filetype> where locale is either the
         * language_script_region or language_region or language.
         */

        $possibleFilenameParts = $this->getPossibleFilenamePartsFromLocale($locale);

        /**
         * return the first (e.g. most specific) domain catalog file that exists
         */
        foreach ($possibleFilenameParts as $filenamePart) {
            $filename = $domain . '.' . $filenamePart . '.' . $this->getFileType();
            $filepath = $this->getDomainCatalogDirectory() . DIRECTORY_SEPARATOR . $filename;
            if (file_exists($filepath)) {
                return $filepath;
            }
        }
        throw new NonExistentDomainCatalogFileException($domain, $locale);
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
        $catalogFilePath = $this->getCatalogFilePathFromDomainLocale($domain, $locale);
        return $this->parseDomainCatalogFile($catalogFilePath);
    }

    /**
     * getFileType
     * @return string
     * returns the file extension (type) that this loaderFactory can parse and load
     */
    abstract public function getFileType(): string;

    /**
     * parseDomainCatalogFile
     * @return array<string, string>
     */
    abstract public function parseDomainCatalogFile(string $filepath): array;
}
