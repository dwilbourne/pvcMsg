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
     * @var array<string, array<string, string>>
     */
    protected static array $domainConfigs = [

        /**
         * directory names should be relative to the project root of the app, found in the pvcConfig\AppConfig
         */

        'validator' => [
            'loaderType' => 'php',
            'dirName' => 'vendor/pvc/validator/messages',
        ],

        'parser' => [
            'loaderType' => 'php',
            'dirName' => 'vendor/pvc/parser/messages',
        ]
    ];

    /**
     * getDomainConfig
     * @param string $domain
     * @return array<string, string>
     * @throws InvalidDomainException
     */
    public static function getDomainCatalogConfig(string $domain): array
    {
        if (!self::domainExists($domain)) {
            throw new InvalidDomainException($domain);
        }
        return self::$domainConfigs[$domain];
    }

    /**
     * addDomainCatalogConfig
     * @param string $domain
     * @param array<string, string> $parameters
     * @param bool $overwrite
     * @return bool
     */
    public static function addDomainCatalogConfig(string $domain, array $parameters, bool $overwrite = false): bool
    {
        if (self::domainExists($domain) && !$overwrite) {
            return false;
        }
        self::$domainConfigs[$domain] = $parameters;
        return true;
    }

    /**
     * domainExists
     * @param string $domain
     * @return bool
     */
    public static function domainExists(string $domain): bool
    {
        return isset(self::$domainConfigs[$domain]);
    }
}
