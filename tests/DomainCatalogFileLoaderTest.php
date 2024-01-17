<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\msg;

use PHPUnit\Framework\TestCase;
use pvc\msg\DomainCatalogFileLoader;
use pvc\msg\err\NonExistentDomainCatalogDirectoryException;
use pvc\msg\err\NonExistentDomainCatalogFileException;

class DomainCatalogFileLoaderTest extends TestCase
{
    /**
     * @var DomainCatalogFileLoader
     */
    protected DomainCatalogFileLoader $fileLoader;

    /**
     * @var string
     */
    protected string $fixturePath;

    /**
     * @var string
     */
    protected string $fixtureFile;

    /**
     * @var string
     */
    protected string $domain;

    /**
     * @var string
     */
    protected string $locale;

    /**
     * @var array|string[]
     */
    protected array $messages;

    public function setUp(): void
    {
        $this->fixturePath = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures';
        $this->fixtureFile = $this->fixturePath . 'messages.en.php';
        $this->domain = 'messages';
        $this->locale = 'en';
        $this->messages = $this->makeMessagesArray();
        $this->fileLoader = $this->getMockForAbstractClass(DomainCatalogFileLoader::class, [$this->fixturePath]);
        $this->fileLoader->method('getFileType')->willReturn('php');
    }

    /**
     * makeMessagesArray
     * @return array<string, string>
     */
    private function makeMessagesArray(): array
    {
        $msgOne = 'this is test message one';
        $msgOneIndex = 'message_one';
        $msgTwo = 'this is test message two';
        $msgTwoIndex = 'message_two';
        return [
            $msgOneIndex => $msgOne,
            $msgTwoIndex => $msgTwo,
        ];
    }

    /**
     * testConstruct
     * @covers \pvc\msg\DomainCatalogFileLoader::__construct
     */
    public function testConstruct(): void
    {
        self::assertInstanceOf(DomainCatalogFileLoader::class, $this->fileLoader);
    }

    /**
     * testSetDomainCatalogFilenameFilename
     * @covers \pvc\msg\DomainCatalogFileLoader::setDomainCatalogDirectory
     * @covers \pvc\msg\DomainCatalogFileLoader::getDomainCatalogDirectory
     */
    public function testConstructSetGetDomainCatalogDirectory(): void
    {
        $this->fileLoader->setDomainCatalogDirectory($this->fixturePath);
        self::assertEquals($this->fixturePath, $this->fileLoader->getDomainCatalogDirectory());
    }

    /**
     * testSetDomainCatalogDirectoryThrowsExceptionOnNonExistentDirectory
     * @covers \pvc\msg\DomainCatalogFileLoader::setDomainCatalogDirectory
     */
    public function testSetDomainCatalogDirectoryThrowsExceptionOnNonExistentDirectory(): void
    {
        $badPath = '/noSuchDirectory';
        self::expectException(NonExistentDomainCatalogDirectoryException::class);
        $this->fileLoader->setDomainCatalogDirectory($badPath);
    }

    /**
     * testGetCatalogFilenameFromDomainLocale
     * @dataProvider domainLocaleDataProvider
     * @covers       \pvc\msg\DomainCatalogFileLoader::getCatalogFilePathFromDomainLocale()
     * @covers       \pvc\msg\DomainCatalogFileLoader::getPossibleFilenamePartsFromLocale()
     */
    public function testGetCatalogFilenameFromDomainLocale(
        string $domain,
        string $locale,
        string $expectedResult,
        string $comment
    ): void {
        $expectedResult = $this->fileLoader->getDomainCatalogDirectory() . DIRECTORY_SEPARATOR . $expectedResult;
        self::assertEquals(
            $expectedResult,
            $this->fileLoader->getCatalogFilePathFromDomainLocale($domain, $locale),
            $comment
        );
    }

    public function domainLocaleDataProvider(): array
    {
        return [
            ['messages', 'en_US', 'messages.en_US.php', 'failed to process en_US correctly'],
            ['messages', 'en_CA', 'messages.en.php', 'failed to process en_CA correctly'],
            ['messages', 'fr_FR', 'messages.en.php', 'failed to process fr_FR correctly'],
        ];
    }

    /**
     * testLoadCatalogFailsIfFilenameDoesNotExist
     * @throws NonExistentDomainCatalogFileException
     * @covers \pvc\msg\DomainCatalogFileLoader::getCatalogFilePathFromDomainLocale
     */
    public function testLoadCatalogFailsIfFilenameDoesNotExist(): void
    {
        /**
         * 'phrases' domain does not exist, i.e. there is no phrases.en.php file in the directory
         */
        $badDomain = 'phrases';
        self::expectException(NonExistentDomainCatalogFileException::class);
        $this->fileLoader->loadCatalog($badDomain, $this->locale);
    }

    /**
     * testLoadCatalogSucceeds
     * @covers \pvc\msg\DomainCatalogFileLoader::loadCatalog
     */
    public function testLoadCatalogSucceeds(): void
    {
        $this->fileLoader->method('parseDomainCatalogFile')->willReturn($this->messages);
        self::assertEquals($this->messages, $this->fileLoader->loadCatalog($this->domain, $this->locale));
    }
}
