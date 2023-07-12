<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\msg;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\interfaces\msg\DomainCatalogLoaderInterface;
use pvc\msg\DomainCatalog;

class DomainCatalogTest extends TestCase
{
    /**
     * @var DomainCatalog
     */
    protected DomainCatalog $catalog;

    protected DomainCatalogLoaderInterface|MockObject $loader;

    /**
     * @var string
     */
    protected string $mockDomainCatalogFileName;

    /**
     * @var string
     */
    protected string $testDomain;

    /**
     * @var string
     */
    protected string $testLocale;

    /**
     * @var string
     */
    protected string $msgOne;

    /**
     * @var string
     */
    protected string $msgOneIndex;

    /**
     * @var string
     */
    protected string $msgTwo;

    /**
     * @var string
     */
    protected string $msgTwoIndex;

    /**
     * @var array<string, string>
     */
    protected array $testMessages;

    /**
     * setUp
     */
    public function setUp(): void
    {
        $this->loader = $this->createMock(DomainCatalogLoaderInterface::class);
        $this->catalog = new DomainCatalog($this->loader);

        $this->testDomain = 'testDomain';
        $this->testLocale = 'testLocale';
        $this->msgOne = 'this is test message one';
        $this->msgOneIndex = 'message_one';
        $this->msgTwo = 'this is test message two';
        $this->msgTwoIndex = 'message_two';
        $this->testMessages = [
            $this->msgOneIndex => $this->msgOne,
            $this->msgTwoIndex => $this->msgTwo,
        ];
    }

    /**
     * testSetGetLoader
     * @covers \pvc\msg\DomainCatalog::setLoader
     * @covers \pvc\msg\DomainCatalog::getLoader
     * @covers \pvc\msg\DomainCatalog::__construct
     */
    public function testSetGetLoader(): void
    {
        self::assertEquals($this->loader, $this->catalog->getLoader());
    }

    /**
     * testDomainCatalogDomainLocaleAndMessagesEmptyAtInitialization
     * @covers \pvc\msg\DomainCatalog::getDomain
     * @covers \pvc\msg\DomainCatalog::getLocale
     * @covers \pvc\msg\DomainCatalog::getMessages
     */
    public function testDomainCatalogDomainLocaleAndMessagesEmptyAtInitialization(): void
    {
        self::assertEquals('', $this->catalog->getDomain());
        self::assertEquals('', $this->catalog->getLocale());
        self::assertEquals([], $this->catalog->getMessages());
    }

    /**
     * testLoaderLoadMethodSetsDomainLocaleAndMessagesUponSuccess
     * @covers \pvc\msg\DomainCatalog::load
     * @covers \pvc\msg\DomainCatalog::getDomain
     * @covers \pvc\msg\DomainCatalog::getLocale
     * @covers \pvc\msg\DomainCatalog::getMessages
     */
    public function testLoaderLoadMethodSetsDomainLocaleAndMessagesUponSuccess(): void
    {
        $this->loader
            ->method('loadCatalog')
            ->with($this->testDomain, $this->testLocale)
            ->willReturn($this->testMessages);
        $this->catalog->load($this->testDomain, $this->testLocale);

        self::assertEquals($this->testDomain, $this->catalog->getDomain());
        self::assertEquals($this->testLocale, $this->catalog->getLocale());
        self::assertEquals($this->testMessages, $this->catalog->getMessages());
    }

    /**
     * testLoaderDoesNotReloadMessagesThatAreAlreadyLoaded
     * @covers \pvc\msg\DomainCatalog::load
     */
    public function testLoaderDoesNotReloadMessagesThatAreAlreadyLoaded(): void
    {
        $this->loader
            ->method('loadCatalog')
            ->with($this->testDomain, $this->testLocale)
            ->willReturn($this->testMessages);
        $this->catalog->load($this->testDomain, $this->testLocale);
        $this->loader->expects($this->never())->method('loadCatalog');
        $this->catalog->load($this->testDomain, $this->testLocale);
    }

    /**
     * testGetMessageReturnsIdIfDoesNotExistInCatalog
     * @covers \pvc\msg\DomainCatalog::getMessage
     */
    public function testGetMessageReturnsIdIfItDoesNotExistInCatalog(): void
    {
        $msgId = 'foobar';
        self::assertEquals($msgId, $this->catalog->getMessage($msgId));
    }

    /**
     * testGetMessage
     * @covers \pvc\msg\DomainCatalog::getMessage
     */
    public function testGetMessage(): void
    {
        $this->loader
            ->method('loadCatalog')
            ->with($this->testDomain, $this->testLocale)
            ->willReturn($this->testMessages);
        $this->catalog->load($this->testDomain, $this->testLocale);

        self::assertEquals($this->msgOne, $this->catalog->getMessage($this->msgOneIndex));
    }

    /**
     * testIsLoadedWithEmptyArgs
     * @covers \pvc\msg\DomainCatalog::isLoaded
     */
    public function testIsLoadedWithEmptyArgs(): void
    {
        self::assertFalse($this->catalog->isLoaded());
        $this->loader
            ->method('loadCatalog')
            ->with($this->testDomain, $this->testLocale)
            ->willReturn($this->testMessages);
        $this->catalog->load($this->testDomain, $this->testLocale);
        self::assertTrue($this->catalog->isLoaded());
    }

    /**
     * testIsLoadedWithPopulatedArgs
     * @covers \pvc\msg\DomainCatalog::isLoaded
     */
    public function testIsLoadedWithPopulatedArgs(): void
    {
        $this->loader
            ->method('loadCatalog')
            ->with($this->testDomain, $this->testLocale)
            ->willReturn($this->testMessages);
        $this->catalog->load($this->testDomain, $this->testLocale);
        self::assertFalse($this->catalog->isLoaded('foo', 'bar'));
        self::assertTrue($this->catalog->isLoaded($this->testDomain, $this->testLocale));
    }
}
