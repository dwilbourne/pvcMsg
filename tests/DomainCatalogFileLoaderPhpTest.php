<?php

declare(strict_types=1);

namespace pvcTests\msg;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use pvc\msg\DomainCatalogFileLoader;
use pvc\msg\DomainCatalogFileLoaderPhp;
use pvc\msg\err\InvalidDomainCatalogFileException;
use pvc\msg\err\NonExistentDomainCatalogDirectoryException;
use pvc\msg\err\NonExistentDomainCatalogFileException;

#[CoversClass(DomainCatalogFileLoaderPhp::class)]
#[CoversClass(DomainCatalogFileLoader::class)]
class DomainCatalogFileLoaderPhpTest extends TestCase
{
    protected DomainCatalogFileLoaderPhp $loader;
    protected string $fixtureDir;

    protected string $locale;

    /**
     * setUp
     */
    public function setUp(): void
    {
        $this->fixtureDir = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR;
        $this->loader = new DomainCatalogFileLoaderPHP();
        $this->loader->setDomainCatalogDirectory($this->fixtureDir);
        $this->locale = 'en';
    }


    public function testGetFileType(): void
    {
        self::assertEquals('php', $this->loader->getFileType());
    }

    /**
     * getBadMessageTestFixtures
     * @return array<int, array<int, string>>
     */
    public static function getBadMessageTestFixtures(): array
    {
        return [
            ['badMessages_1'],
            ['badMessages_2'],
            ['badMessages_3'],
            ['badMessages_4'],
        ];
    }

    public function testSetDomainCatalogDirectoryThrowsExceptionOnNonExistentDirectory(
    ): void
    {
        $badPath = '/noSuchDirectory';
        self::expectException(
            NonExistentDomainCatalogDirectoryException::class
        );
        $this->loader->setDomainCatalogDirectory($badPath);
    }

    #[DataProvider('getBadMessageTestFixtures')]
    public function testBadFiles(string $domain): void
    {
        self::expectException(InvalidDomainCatalogFileException::class);
        $filePath = $this->loader->getCatalogFilePathFromDomainLocale($domain, $this->locale);
        $this->loader->parseDomainCatalogFile($filePath);
    }


    public function testLoadCatalogFailsIfFilenameDoesNotExist(): void
    {
        /**
         * 'phrases' domain does not exist, i.e. there is no phrases.en.php file in the directory
         */
        $badDomain = 'phrases';
        self::expectException(NonExistentDomainCatalogFileException::class);
        $this->loader->loadCatalog($badDomain, $this->locale);
    }


    public function testLoadCatalogDegradesToEnglishIfThereIsNoCatalogForTheSpecifiedLocale(
    ): void
    {
        $domain = 'messages';
        $locale = 'fr';
        $messages = $this->loader->loadCatalog($domain, $locale);
        $msgId = 'symfony_great';
        /**
         * english
         */
        $expectedMessage = 'Symfony is GREAT!';
        self::assertEquals($expectedMessage, $messages[$msgId]);
    }


    public function testGoodMessages(): void
    {
        $domain = 'messages';
        $locale = 'en';
        $messages = $this->loader->loadCatalog($domain, $locale);
        self::assertNotEmpty($messages);
    }
}
