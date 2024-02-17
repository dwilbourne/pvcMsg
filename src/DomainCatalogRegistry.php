<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg;

use pvc\interfaces\msg\DomainCatalogRegistryInterface;
use pvc\msg\err\InvalidDomainException;

/**
 * Class MsgConfig
 */
class DomainCatalogRegistry implements DomainCatalogRegistryInterface
{
    /**
     * @var array<string, array<string, array<string, string>|string>>
     */
    protected array $domainConfigs = [

        /**
         * directory names should be relative to the project root of the app
         */

        'validator' => [
            'loaderType' => 'php',
            'parameters' => [
                'dirName' => 'vendor/pvc/validator/messages',
            ],
        ],

        'parser' => [
            'loaderType' => 'php',
            'parameters' => [
                'dirName' => 'vendor/pvc/parser/messages',
            ],
        ],

        'frmtr' => [
            'loaderType' => 'php',
            'parameters' => [
                'dirName' => 'vendor/pvc/frmtr/messages',
            ],
        ],
    ];

    /**
     * getDomainConfig
     * @param string $domain
     * @return array<string, array<string, string>|string>
     * @throws InvalidDomainException
     */
    public function getDomainCatalogConfig(string $domain): array
    {
        if (!self::domainExists($domain)) {
            throw new InvalidDomainException($domain);
        }
        return $this->domainConfigs[$domain];
    }

    /**
     * addDomainCatalogConfig
     * @param string $domain
     * @param array<string, array<string>> $parameters
     * @param bool $overwrite
     * @return bool
     */
    public function addDomainCatalogConfig(string $domain, array $parameters, bool $overwrite = false): bool
    {
        if (self::domainExists($domain) && !$overwrite) {
            return false;
        }
        $this->domainConfigs[$domain] = $parameters;
        return true;
    }

    /**
     * domainExists
     * @param string $domain
     * @return bool
     */
    public function domainExists(string $domain): bool
    {
        return isset($this->domainConfigs[$domain]);
    }
}
