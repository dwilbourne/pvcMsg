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
    protected string $domain;

    protected string $locale;

    /**
     * @var array<string>
     */
    protected array $messages;

    public function __construct(protected DomainCatalogLoaderInterface $loader)
    {
    }

    /**
     * @param non-empty-string $domain
     * @param non-empty-string $locale
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

    public function getDomain(): string
    {
        return $this->domain ?? '';
    }

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
     */
    protected function isLoaded(string $domain, string $locale): bool
    {
        /**
         * recall that domain and locale are set simultaneously via the load method, so either both properties are
         * empty or they are both set.
         */
        if (in_array($this->getDomain(), ['', '0'], true)) {
            return false;
        }

        /**
         * if domain and locale are set, then check to see if the catalog is loaded with the arguments specified.
         */
        return ($domain === $this->getDomain()
            && $locale === $this->getLocale());
    }
}
