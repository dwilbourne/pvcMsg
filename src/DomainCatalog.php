<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg;

use pvc\interfaces\msg\DomainCatalogInterface;
use pvc\interfaces\msg\DomainCatalogLoaderInterface;

/**
 * Class DomainCatalog
 */
class DomainCatalog implements DomainCatalogInterface
{
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
     * @var DomainCatalogLoaderInterface
     */
    protected DomainCatalogLoaderInterface $loader;

    /**
     * @param DomainCatalogLoaderInterface $loader
     */
    public function __construct(DomainCatalogLoaderInterface $loader)
    {
        $this->setLoader($loader);
    }

    /**
     * @return DomainCatalogLoaderInterface
     */
    public function getLoader(): DomainCatalogLoaderInterface
    {
        return $this->loader;
    }

    /**
     * @param DomainCatalogLoaderInterface $loader
     */
    public function setLoader(DomainCatalogLoaderInterface $loader): void
    {
        $this->loader = $loader;
    }

    /**
     * load
     */
    public function load(string $domain, string $locale): void
    {
        /**
         * no need to repeat loading a catalog....
         */
        if ($this->isLoaded($domain, $locale)) {
            return;
        }

        $this->messages = $this->loader->loadCatalog($domain, $locale);
        $this->domain = $domain;
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain ?? '';
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale ?? '';
    }

    /**
     * @return array<string>
     */
    public function getMessages(): array
    {
        return $this->messages ?? [];
    }

    /**
     * getMessage
     * @param string $messageId
     * @return string|null
     */
    public function getMessage(string $messageId): ?string
    {
        /**
         * if the messageId is not in the catalog, just return it.
         */
        return $this->messages[$messageId] ?? null;
    }

    public function isLoaded(string $domain = '', string $locale = ''): bool
    {
        /**
         * if both arguments are empty, then indicate whether the catalog is populated with anything at all
         */
        if ($domain == '' && $locale == '') {
            return ($this->getDomain() && $this->getLocale());
        }
        /**
         * if either are set, then check to see if the catalog is loaded with the arguments specified
         */
        return ($domain == $this->getDomain() && $locale == $this->getLocale());
    }
}
