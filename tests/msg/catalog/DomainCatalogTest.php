<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace tests\msg\catalog;

use Mockery;
use PHPUnit\Framework\TestCase;
use pvc\interfaces\msg\DomainCatalogLoaderInterface;
use pvc\msg\catalog\DomainCatalog;

class DomainCatalogTest extends TestCase
{
    /**
     * @var DomainCatalog
     */
    protected DomainCatalog $catalog;

    /**
     * @var DomainCatalogLoaderInterface|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    protected DomainCatalogLoaderInterface|Mockery\LegacyMockInterface|Mockery\MockInterface $loader;

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
    public function setUp() : void
    {
        $this->loader = Mockery::mock(DomainCatalogLoaderInterface::class);
        $this->setLoaderExpectations();
        /** @phpstan-ignore-next-line */
        $this->catalog = new DomainCatalog($this->loader);
    }

    /**
     * setLoaderExpectations
     */
    private function setLoaderExpectations() : void
    {
        $this->mockDomainCatalogFileName = 'messages.en.php';
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
        $this->loader->expects('loadCatalog');
        $this->loader->expects('getDomain')->withNoArgs()->andReturn($this->testDomain);
        $this->loader->expects('getLocale')->withNoArgs()->andReturn($this->testLocale);
        $this->loader->expects('getMessages')->withNoArgs()->andReturn($this->testMessages);
    }

    /**
     * testSetGetLoader
     * @covers DomainCatalog::setLoader
     * * @covers DomainCatalog::getLoader
     */
    public function testSetGetLoader() : void
    {
        self::assertEquals($this->loader, $this->catalog->getLoader());
    }

    /**
     * testGetDomain
     * @covers \pvc\msg\catalog\DomainCatalog::getDomain
     */
    public function testGetDomain() : void
    {
        self::assertEquals($this->testDomain, $this->catalog->getDomain());
    }

    /**
     * testGetLocale
     * @covers \pvc\msg\catalog\DomainCatalog::getLocale
     */
    public function testGetLocale() : void
    {
        self::assertEquals($this->testLocale, $this->catalog->getLocale());
    }

    /**
     * testGetMessages
     * @covers \pvc\msg\catalog\DomainCatalog::getMessages
     */
    public function testGetMessages() : void
    {
        self::assertEquals($this->testMessages, $this->catalog->getMessages());
    }

    /**
     * testGetMessage
     * @covers \pvc\msg\catalog\DomainCatalog::getMessage
     */
    public function testGetMessage() : void
    {
        self::assertEquals($this->msgOne, $this->catalog->getMessage($this->msgOneIndex));
        $msgId = 'foobar';
        self::assertEquals($msgId, $this->catalog->getMessage($msgId));
    }
}
