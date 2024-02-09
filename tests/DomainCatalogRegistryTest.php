<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\msg;

use PHPUnit\Framework\TestCase;
use pvc\msg\err\InvalidDomainException;
use pvc\msg\DomainCatalogRegistry;

class DomainCatalogRegistryTest extends TestCase
{
    /**
     * testGetDomainCatalogConfigThrowsExceptionForNonExistentDomain
     * @throws InvalidDomainException
     * @covers \pvc\msg\DomainCatalogRegistry::getDomainCatalogConfig
     */
    public function testGetDomainCatalogConfigThrowsExceptionForNonExistentDomain(): void
    {
        self::expectException(InvalidDomainException::class);
        DomainCatalogRegistry::getDomainCatalogConfig('foo');
    }

    /**
     * testGetDomainCatalogConfigReturnsArray
     * @throws InvalidDomainException
     * @covers \pvc\msg\DomainCatalogRegistry::getDomainCatalogConfig
     */
    public function testGetDomainCatalogConfigReturnsArray(): void
    {
        $testDomain = 'validator';
        self::assertIsArray(DomainCatalogRegistry::getDomainCatalogConfig($testDomain));
    }

    /**
     * testAddGetConfigWithNewDomain
     * @throws InvalidDomainException
     * @covers \pvc\msg\DomainCatalogRegistry::addDomainCatalogConfig
     * @covers \pvc\msg\DomainCatalogRegistry::getDomainCatalogConfig
     */
    public function testAddGetConfigWithNewDomain(): void
    {
        $testDomain = 'foo';
        $testParameters = ['bar' => 'baz', 'quux' => 'quap'];
        self::assertTrue(DomainCatalogRegistry::addDomainCatalogConfig($testDomain, $testParameters));
        self::assertEquals($testParameters, DomainCatalogRegistry::getDomainCatalogConfig($testDomain));
    }

    /**
     * testAddGetConfigOverwriteIsFalse
     * @throws InvalidDomainException
     * @covers \pvc\msg\DomainCatalogRegistry::addDomainCatalogConfig
     */
    public function testAddGetConfigOverwriteIsFalse(): void
    {
        $testDomain = 'validator';
        $overwrite = false;
        $oldParams = DomainCatalogRegistry::getDomainCatalogConfig($testDomain);
        $newParams = ['bar' => 'baz', 'quux' => 'quap'];
        self::assertFalse(DomainCatalogRegistry::addDomainCatalogConfig($testDomain, $newParams, $overwrite));
        self::assertEquals($oldParams, DomainCatalogRegistry::getDomainCatalogConfig($testDomain));
    }

    /**
     * testAddGetConfigOverwriteIsTrue
     * @throws InvalidDomainException
     * @covers \pvc\msg\DomainCatalogRegistry::addDomainCatalogConfig
     */
    public function testAddGetConfigOverwriteIsTrue(): void
    {
        $testDomain = 'validator';
        $overwrite = true;
        $newParams = ['bar' => 'baz', 'quux' => 'quap'];
        self::assertTrue(DomainCatalogRegistry::addDomainCatalogConfig($testDomain, $newParams, $overwrite));
        self::assertEquals($newParams, DomainCatalogRegistry::getDomainCatalogConfig($testDomain));
    }

    /**
     * testAddGetConfigOverwriteDefaultsToFalse
     * @throws InvalidDomainException
     * @covers \pvc\msg\DomainCatalogRegistry::addDomainCatalogConfig
     */
    public function testAddGetConfigOverwriteDefaultsToFalse(): void
    {
        $testDomain = 'validator';
        $oldParams = DomainCatalogRegistry::getDomainCatalogConfig($testDomain);
        $newParams = ['bar' => 'five', 'quux' => 'seven'];
        self::assertFalse(DomainCatalogRegistry::addDomainCatalogConfig($testDomain, $newParams));
        self::assertEquals($oldParams, DomainCatalogRegistry::getDomainCatalogConfig($testDomain));
    }

    /**
     * testDomainExists
     * @covers \pvc\msg\DomainCatalogRegistry::domainExists
     */
    public function testDomainExists(): void
    {
        $testDomain = 'validator';
        self::assertTrue(DomainCatalogRegistry::domainExists($testDomain));
        /**
         * note that because the domainConfigs array is static, we cannot add 'foo' a second time, even though this
         * is a new test ('foo' was added in line 49 in this test suite).  The static array persists between tests.
         */
        $testDomain = 'bar';
        self::assertFalse(DomainCatalogRegistry::domainExists($testDomain));
    }
}
