<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg;

use pvc\interfaces\msg\DomainCatalogInterface;
use pvc\interfaces\msg\DomainCatalogRegistryInterface;
use pvc\interfaces\msg\LoaderFactoryInterface;
use pvc\msg\err\InvalidDomainException;

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

    protected LoaderFactoryInterface $loaderFactory;

    protected DomainCatalogRegistryInterface $registry;

    /**
     * @param LoaderFactoryInterface $loaderFactory
     */
    public function __construct(LoaderFactoryInterface $loaderFactory, DomainCatalogRegistryInterface $registry)
    {
        $this->setLoaderFactory($loaderFactory);
        $this->setRegistry($registry);
    }

    public function getLoaderFactory(): LoaderFactoryInterface
    {
        return $this->loaderFactory;
    }

    public function setLoaderFactory(LoaderFactoryInterface $loaderFactory): void
    {
        $this->loaderFactory = $loaderFactory;
    }

    /**
     * @return DomainCatalogRegistryInterface
     */
    public function getRegistry(): DomainCatalogRegistryInterface
    {
        return $this->registry;
    }

    /**
     * @param DomainCatalogRegistryInterface $registry
     */
    public function setRegistry(DomainCatalogRegistryInterface $registry): void
    {
        $this->registry = $registry;
    }

    /**
     * load
     * @throws InvalidDomainException
     */
    public function load(string $domain, string $locale): void
    {
        /**
         * no need to repeat loading a catalog....
         */
        if ($this->isLoaded($domain, $locale)) {
            return;
        }

        $registryEntry = $this->registry->getDomainCatalogConfig($domain);
        /** @var string $loaderType */
        $loaderType = $registryEntry['loaderType'];
        /** @var array<string, string> $parameters */
        $parameters = $registryEntry['parameters'];
        $loader = $this->loaderFactory->makeLoader($loaderType, $parameters);
        $this->messages = $loader->loadCatalog($domain, $locale);
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
