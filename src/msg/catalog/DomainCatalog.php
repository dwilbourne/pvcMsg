<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvc\msg\catalog;

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
        $this->load();
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
    public function load() : void
    {
        $this->loader->loadCatalog();
        $this->domain = $this->loader->getDomain();
        $this->locale = $this->loader->getLocale();
        $this->messages = $this->loader->getMessages();
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @return array<string>
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    public function getMessage(string $messageId) : string
    {
        // if the messageId is not in the catalog, just return it.
        return $this->messages[$messageId] ?? $messageId;
    }
}
