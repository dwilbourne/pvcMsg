<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\msg;

use PHPUnit\Framework\TestCase;
use pvc\msg\DomainCatalogFileLoaderPhp;
use pvc\msg\err\InvalidDomainCatalogFileException;

class DomainCatalogFileLoaderPhpTest extends TestCase
{
    /**
     * @var DomainCatalogFileLoaderPhp
     */
    protected DomainCatalogFileLoaderPhp $loader;

    /**
     * @var string
     */
    protected string $fixtureDir;

    /**
     * @var string
     */
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

    /**
     * testGetFileType
     * @covers \pvc\msg\DomainCatalogFileLoaderPHP::getFileType
     */
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

    /**
     * testBadFiles
     * @param string $domain
     * @throws InvalidDomainCatalogFileException
     * @dataProvider getBadMessageTestFixtures
     * @covers \pvc\msg\DomainCatalogFileLoaderPHP::parseDomainCatalogFile
     */
    public function testBadFiles(string $domain): void
    {
        self::expectException(InvalidDomainCatalogFileException::class);
        $filePath = $this->loader->getCatalogFilePathFromDomainLocale($domain, $this->locale);
        $this->loader->parseDomainCatalogFile($filePath);
    }

    /**
     * testGoodMessages
     * @throws InvalidDomainCatalogFileException
     * @covers \pvc\msg\DomainCatalogFileLoaderPHP::parseDomainCatalogFile
     */
    public function testGoodMessages(): void
    {
        $fixture = $this->fixtureDir . 'messages.en.php';
        $messages = $this->loader->parseDomainCatalogFile($fixture);
        self::assertNotEmpty($messages);
    }
}
