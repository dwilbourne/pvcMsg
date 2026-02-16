<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\msg;

use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\interfaces\msg\DomainCatalogLoaderInterface;
use pvc\msg\DomainCatalog;

#[CoversClass(DomainCatalog::class)]
#[AllowMockObjectsWithoutExpectations]
class DomainCatalogTest extends TestCase
{
    protected DomainCatalog $catalog;

    protected DomainCatalogLoaderInterface&MockObject $loader;

    protected string $mockDomainCatalogFileName;

    /**
     * @var non-empty-string
     */
    protected string $testDomain;

    /**
     * @var non-empty-string
     */
    protected string $testLocale;

    protected string $msgOne;

    protected string $msgOneIndex;

    protected string $msgTwo;

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

    public function testConstruct(): void
    {
        self::assertInstanceOf(DomainCatalog::class, $this->catalog);
    }

    /**
     * testDomainCatalogDomainLocaleAndMessagesEmptyAtInitialization
     */
    public function testDomainCatalogDomainLocaleAndMessagesEmptyAtInitialization(): void
    {
        self::assertEquals('', $this->catalog->getDomain());
        self::assertEquals('', $this->catalog->getLocale());
        self::assertEquals([], $this->catalog->getMessages());
    }

    /**
     * loadCatalogWithConfiguredMocks
     */
    protected function loadCatalogWithConfiguredMocks(): void
    {
        $this->loader
            ->method('loadCatalog')
            ->with($this->testDomain, $this->testLocale)
            ->willReturn($this->testMessages);

        $this->catalog->load($this->testDomain, $this->testLocale);
    }

    /**
     * testLoaderLoadMethodSetsDomainLocaleAndMessagesUponSuccess
     */
    public function testLoaderLoadMethodSetsDomainLocaleAndMessagesUponSuccess(): void
    {
        $this->loadCatalogWithConfiguredMocks();
        self::assertEquals($this->testDomain, $this->catalog->getDomain());
        self::assertEquals($this->testLocale, $this->catalog->getLocale());
        self::assertEquals($this->testMessages, $this->catalog->getMessages());
    }

    /**
     * testLoaderDoesNotReloadMessagesThatAreAlreadyLoaded
     */
    public function testLoaderDoesNotReloadMessagesThatAreAlreadyLoaded(): void
    {
        $this->loadCatalogWithConfiguredMocks();
        $this->loader->expects($this->never())->method('loadCatalog');
        $this->catalog->load($this->testDomain, $this->testLocale);
    }

    /**
     * testGetMessageReturnsIdIfDoesNotExistInCatalog
     */
    public function testGetMessageReturnsNullIfItDoesNotExistInCatalog(): void
    {
        $this->loadCatalogWithConfiguredMocks();
        $msgId = 'foobar';
        self::assertNull($this->catalog->getMessage($msgId));
    }

    /**
     * testGetMessage
     */
    public function testGetMessage(): void
    {
        $this->loadCatalogWithConfiguredMocks();
        self::assertEquals($this->msgOne, $this->catalog->getMessage($this->msgOneIndex));
    }
}
