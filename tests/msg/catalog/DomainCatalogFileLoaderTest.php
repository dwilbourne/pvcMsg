<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace tests\msg\catalog;

use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;
use pvc\msg\catalog\DomainCatalogFileLoader;

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
    protected string $expectedDomain;

    /**
     * @var string
     */
    protected string $expectedLocale;

    /**
     * @var array|string[]
     */
    protected array $expectedMessages;

    public function setUp() : void
    {
        /** @phpstan-ignore-next-line */
        $this->fileLoader = Mockery::mock(DomainCatalogFileLoader::class)->makePartial();
        $this->fixturePath = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'messages.en.php';
        $this->expectedDomain = 'messages';
        $this->expectedLocale = 'en';
        $this->expectedMessages = $this->makeMessagesArray();
    }

    /**
     * makeMessagesArray
     * @return array<string, string>
     */
    private function makeMessagesArray() : array
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
     * testSetDomainCatalogFilename
     * @covers \pvc\msg\catalog\DomainCatalogFileLoader::setDomainCatalogFilename
     */
    public function testSetDomainCatalogFilenameOnePart() : void
    {
        $testName = 'messageDomainOnly';
        self::expectException(Exception::class);
        $this->fileLoader->setDomainCatalogFilename($testName);
    }

    /**
     * testSetDomainCatalogFilenameTwoParts
     * @covers \pvc\msg\catalog\DomainCatalogFileLoader::setDomainCatalogFilename
     * @throws Exception
     */
    public function testSetDomainCatalogFilenameTwoParts() : void
    {
        $testName = 'messageDomain.plusLocale';
        self::expectException(Exception::class);
        $this->fileLoader->setDomainCatalogFilename($testName);
    }

    /**
     * testSetDomainCatalogFilenameFourParts
     * @throws Exception
     * @covers \pvc\msg\catalog\DomainCatalogFileLoader::setDomainCatalogFilename
     */
    public function testSetDomainCatalogFilenameFourParts() : void
    {
        $testName = 'messageDomain.plusLocale.plusExtension.plusSomthingElse';
        self::expectException(Exception::class);
        $this->fileLoader->setDomainCatalogFilename($testName);
    }

    /**
     * testSetDomainCatalogFilenameFileNotExist
     * @throws Exception
     * @covers \pvc\msg\catalog\DomainCatalogFileLoader::setDomainCatalogFilename
     */
    public function testSetDomainCatalogFilenameFileNotExist() : void
    {
        $testName = 'messageDomain.plusLocale.plusExtension';
        self::expectException(Exception::class);
        $this->fileLoader->setDomainCatalogFilename($testName);
    }

    /**
     * testSetDomainCatalogFilenameFilename
     * @throws Exception
     * @covers \pvc\msg\catalog\DomainCatalogFileLoader::setDomainCatalogFilename
     * @covers \pvc\msg\catalog\DomainCatalogFileLoader::getDomainCatalogFilename
     */
    public function testSetDomainCatalogFilenameFilename() : void
    {
        $this->fileLoader->setDomainCatalogFilename($this->fixturePath);
        self::assertEquals($this->fixturePath, $this->fileLoader->getDomainCatalogFilename());
    }

    /**
     * testGetDomainCatalogFilenameUnset
     * @covers \pvc\msg\catalog\DomainCatalogFileLoader::getDomainCatalogFilename
     */
    public function testGetDomainCatalogFilenameUnset() : void
    {
        self::assertNull($this->fileLoader->getDomainCatalogFilename());
    }

    /**
     * testLoadCatalog
     * @throws Exception
     * @covers \pvc\msg\catalog\DomainCatalogFileLoader::loadCatalog
     * @covers \pvc\msg\catalog\DomainCatalogFileLoader::getDomain
     * @covers \pvc\msg\catalog\DomainCatalogFileLoader::getLocale
     * @covers \pvc\msg\catalog\DomainCatalogFileLoader::getMessages
     */
    public function testLoadCatalog() : void
    {
        /** @phpstan-ignore-next-line */
        $this->fileLoader->shouldReceive('parseDomainCatalogFile')->andReturn($this->expectedMessages);

        $this->fileLoader->setDomainCatalogFilename($this->fixturePath);
        $this->fileLoader->loadCatalog();
        self::assertEquals($this->expectedDomain, $this->fileLoader->getDomain());
        self::assertEquals($this->expectedLocale, $this->fileLoader->getLocale());
        self::assertEqualsCanonicalizing($this->expectedMessages, $this->fileLoader->getMessages());
    }

    /**
     * testLoadCatalogWhenFilenameNotSet
     * @throws Exception
     * @covers \pvc\msg\catalog\DomainCatalogFileLoader::loadCatalog
     */
    public function testLoadCatalogWhenFilenameNotSet() : void
    {
        self::expectException(Exception::class);
        $this->fileLoader->loadCatalog();
    }

    /**
     * testGettersFailWhenCatalogNotLoaded
     * @throws Exception
     * @covers \pvc\msg\catalog\DomainCatalogFileLoader::getDomain
     * @covers \pvc\msg\catalog\DomainCatalogFileLoader::getLocale
     * @covers \pvc\msg\catalog\DomainCatalogFileLoader::getMessages
     */
    public function testGettersFailWhenCatalogNotLoaded() : void
    {
        $this->fileLoader->setDomainCatalogFilename($this->fixturePath);

        self::expectException('Error');
        $foo = $this->fileLoader->getDomain();

        self::expectException('Error');
        $bar = $this->fileLoader->getLocale();

        self::expectException('Error');
        $baz = $this->fileLoader->getMessages();

        unset($foo, $bar, $baz);
    }
}
