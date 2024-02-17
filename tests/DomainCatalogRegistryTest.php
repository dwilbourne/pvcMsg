<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\msg;

use PHPUnit\Framework\TestCase;
use pvc\msg\DomainCatalogRegistry;
use pvc\msg\err\InvalidDomainException;

class DomainCatalogRegistryTest extends TestCase
{
    protected DomainCatalogRegistry $registry;

    public function setUp(): void
    {
        $this->registry = new DomainCatalogRegistry();
    }

    /**
     * testGetDomainCatalogConfigThrowsExceptionForNonExistentDomain
     * @throws InvalidDomainException
     * @covers \pvc\msg\DomainCatalogRegistry::getDomainCatalogConfig
     */
    public function testGetDomainCatalogConfigThrowsExceptionForNonExistentDomain(): void
    {
        self::expectException(InvalidDomainException::class);
        $this->registry->getDomainCatalogConfig('foo');
    }

    /**
     * testGetDomainCatalogConfigReturnsArray
     * @throws InvalidDomainException
     * @covers \pvc\msg\DomainCatalogRegistry::getDomainCatalogConfig
     */
    public function testGetDomainCatalogConfigReturnsArray(): void
    {
        $testDomain = 'validator';
        self::assertIsArray($this->registry->getDomainCatalogConfig($testDomain));
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
        self::assertTrue($this->registry->addDomainCatalogConfig($testDomain, $testParameters));
        self::assertEquals($testParameters, $this->registry->getDomainCatalogConfig($testDomain));
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
        $oldParams = $this->registry->getDomainCatalogConfig($testDomain);
        $newParams = ['bar' => 'baz', 'quux' => 'quap'];
        self::assertFalse($this->registry->addDomainCatalogConfig($testDomain, $newParams, $overwrite));
        self::assertEquals($oldParams, $this->registry->getDomainCatalogConfig($testDomain));
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
        self::assertTrue($this->registry->addDomainCatalogConfig($testDomain, $newParams, $overwrite));
        self::assertEquals($newParams, $this->registry->getDomainCatalogConfig($testDomain));
    }

    /**
     * testAddGetConfigOverwriteDefaultsToFalse
     * @throws InvalidDomainException
     * @covers \pvc\msg\DomainCatalogRegistry::addDomainCatalogConfig
     */
    public function testAddGetConfigOverwriteDefaultsToFalse(): void
    {
        $testDomain = 'validator';
        $oldParams = $this->registry->getDomainCatalogConfig($testDomain);
        $newParams = ['bar' => 'five', 'quux' => 'seven'];
        self::assertFalse($this->registry->addDomainCatalogConfig($testDomain, $newParams));
        self::assertEquals($oldParams, $this->registry->getDomainCatalogConfig($testDomain));
    }

    /**
     * testDomainExists
     * @covers \pvc\msg\DomainCatalogRegistry::domainExists
     */
    public function testDomainExists(): void
    {
        $testDomain = 'validator';
        self::assertTrue($this->registry->domainExists($testDomain));
        /**
         * note that because the domainConfigs array is static, we cannot add 'foo' a second time, even though this
         * is a new test ('foo' was added in line 49 in this test suite).  The static array persists between tests.
         */
        $testDomain = 'bar';
        self::assertFalse($this->registry->domainExists($testDomain));
    }
}
