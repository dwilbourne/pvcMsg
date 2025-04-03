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
     * @param DomainCatalogLoaderInterface $loader
     */
    public function __construct(protected DomainCatalogLoaderInterface $loader)
    {
    }

    /**
     * @param non-empty-string $domain
     * @param non-empty-string $locale
     * @return void
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

    /**
     * @param non-empty-string $domain
     * @param non-empty-string $locale
     * @return bool
     */
    protected function isLoaded(string $domain, string $locale): bool
    {
        /**
         * recall that domain and locale are set simultaneously via the load method, so either both properties are
         * empty or they are both set.
         */
        if (empty($this->getDomain())) return false;

        /**
         * if domain and locale are set, then check to see if the catalog is loaded with the arguments specified.
         */
        return ($domain == $this->getDomain() && $locale == $this->getLocale());
    }
}
