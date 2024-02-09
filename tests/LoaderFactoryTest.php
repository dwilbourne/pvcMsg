<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\msg;

use pvc\msg\DomainCatalogFileLoaderPHP;
use pvc\msg\err\MissingLoaderConfigParameterException;
use pvc\msg\err\UnknownLoaderTypeException;
use pvc\msg\LoaderFactory;
use PHPUnit\Framework\TestCase;

class LoaderFactoryTest extends TestCase
{
    protected LoaderFactory $loaderFactory;

    protected string $dirNameFixture = __DIR__ . '/fixtures';

    protected array $parameters;

    public function setUp(): void
    {
        $this->loaderFactory = new LoaderFactory();
        $this->parameters = ['dirName' => $this->dirNameFixture];
    }

    /**
     * testMakeBadLoaderType
     * @throws UnknownLoaderTypeException
     * @throws \pvc\msg\err\MissingLoaderConfigParameterException
     * @throws \pvc\msg\err\NonExistentDomainCatalogDirectoryException
     * @covers \pvc\msg\LoaderFactory::makeLoader
     */
    public function testMakeBadLoaderType(): void
    {
        self::expectException(UnknownLoaderTypeException::class);
        $this->loaderFactory->makeLoader('badLoaderType', []);
    }

    /**
     * testMakePhpLoaderTypeThrowsExceptionWithBadConfigParameters
     * @throws MissingLoaderConfigParameterException
     * @throws UnknownLoaderTypeException
     * @throws \pvc\msg\err\NonExistentDomainCatalogDirectoryException
     * @covers \pvc\msg\LoaderFactory::makeLoader
     */
    public function testMakePhpLoaderTypeThrowsExceptionWithBadConfigParameters(): void
    {
        $parameters = ['foo' => 'bar'];
        self::expectException(MissingLoaderConfigParameterException::class);
        $this->loaderFactory->makeLoader('php', $parameters);
    }

    /**
     * testMakePhpLoader
     * @throws MissingLoaderConfigParameterException
     * @throws UnknownLoaderTypeException
     * @throws \pvc\msg\err\NonExistentDomainCatalogDirectoryException
     * @covers \pvc\msg\LoaderFactory::makeLoader
     */
    public function testMakePhpLoader(): void
    {
        $loader = $this->loaderFactory->makeLoader('php', $this->parameters);
        self::assertInstanceOf(DomainCatalogFileLoaderPHP::class, $loader);
    }
}
