<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace tests\msg\catalog;

use Exception;
use PHPUnit\Framework\TestCase;
use pvc\msg\catalog\DomainCatalogFileLoaderPHP;

class DomainCatalogFileLoaderPHPTest extends TestCase
{

    /**
     * @var DomainCatalogFileLoaderPHP
     */
    protected DomainCatalogFileLoaderPHP $loader;

    /**
     * @var string
     */
    protected string $fixtureDir;

    /**
     * setUp
     */
    public function setUp() : void
    {
        $this->loader = new DomainCatalogFileLoaderPHP();
        $this->fixtureDir = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR;
    }

    /**
     * getBadMessageTestFixtures
     * @return array<int, array<int, string>>
     */
    public function getBadMessageTestFixtures() : array
    {
        return [
            ['badMessages.en.js'],
            ['badMessages_1.en.php'],
            ['badMessages_2.en.php'],
            ['badMessages_3.en.php'],
            ['badMessages_4.en.php'],
        ];
    }

    /**
     * testBadFiles
     * @param string $filename
     * @throws Exception
     * @dataProvider getBadMessageTestFixtures
     * @covers \pvc\msg\catalog\DomainCatalogFileLoaderPHP::parseDomainCatalogFile
     */
    public function testBadFiles(string $filename) : void
    {
        self::expectException(Exception::class);
        $fixture = $this->fixtureDir . $filename;
        $this->loader->setDomainCatalogFilename($fixture);
        $foo = $this->loader->parseDomainCatalogFile();
        unset($foo);
    }

    /**
     * testGoodMessages
     * @throws Exception
     * @covers \pvc\msg\catalog\DomainCatalogFileLoaderPHP::parseDomainCatalogFile
     */
    public function testGoodMessages() : void
    {
        $fixture = $this->fixtureDir . 'messages.en.php';
        $this->loader->setDomainCatalogFilename($fixture);
        self::assertIsArray($this->loader->parseDomainCatalogFile());
    }
}
