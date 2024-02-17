<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\msg;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\interfaces\intl\LocaleInterface;
use pvc\interfaces\msg\DomainCatalogInterface;
use pvc\interfaces\msg\MsgInterface;
use pvc\msg\err\MsgContentNotSetException;
use pvc\msg\err\NonExistentMessageException;
use pvc\msg\MsgFrmtr;

class MsgFrmtrTest extends TestCase
{
    /**
     * @var LocaleInterface
     */
    protected LocaleInterface $locale;

    /**
     * @var DomainCatalogInterface|MockObject
     */
    protected DomainCatalogInterface|MockObject $catalog;

    /**
     * @var MsgFrmtr
     */
    protected MsgFrmtr $frmtr;

    public function setUp(): void
    {
        $this->locale = $this->createMock(LocaleInterface::class);
        $this->catalog = $this->createMock(DomainCatalogInterface::class);
        $this->frmtr = new MsgFrmtr($this->catalog, $this->locale);
    }

    /**
     * testConstruct
     * @covers \pvc\msg\MsgFrmtr::__construct
     */
    public function testConstruct(): void
    {
        self::assertInstanceOf(MsgFrmtr::class, $this->frmtr);
    }

    /**
     * testSetGetDomainCatalog
     * @covers \pvc\msg\MsgFrmtr::setDomainCatalog
     * @covers \pvc\msg\MsgFrmtr::getDomainCatalog
     */
    public function testSetGetDomainCatalog(): void
    {
        $newCatalog = $this->createMock(DomainCatalogInterface::class);
        $this->frmtr->setDomainCatalog($newCatalog);
        self::assertEquals($newCatalog, $this->frmtr->getDomainCatalog());
    }

    /**
     * testSetGetLocale
     * @covers \pvc\msg\MsgFrmtr::setLocale
     * @covers \pvc\msg\MsgFrmtr::getLocale
     */
    public function testSetGetLocale(): void
    {
        $newLocale = $this->createMock(LocaleInterface::class);
        $this->frmtr->setLocale($newLocale);
        self::assertEquals($newLocale, $this->frmtr->getLocale());
    }

    /**
     * testFormat
     * @covers \pvc\msg\MsgFrmtr::format
     */
    public function testFormat(): void
    {
        $this->locale->method('__toString')->willReturn('fr_FR');
        $domain = 'domain';
        $msgId = 'msgId';
        $msgText = 'some string';
        $parameters = [1 => 'fiver'];

        $msg = $this->createMock(MsgInterface::class);
        $msg->method('contentIsSet')->willReturn(true);
        $msg->method('getMsgId')->willReturn($msgId);
        $msg->method('getDomain')->willReturn($domain);

        $this->catalog->method('getMessage')->with($msgId)->willReturn($msgText);
        $this->catalog->method('getLocale')->willReturn((string)$this->locale);

        $expectedResult = $msgText;

        $msg->method('getParameters')->willReturn($parameters);
        $actualResult = $this->frmtr->format($msg);

        self::assertEquals($expectedResult, $actualResult);
    }

    /**
     * testMsgThrowsExceptionIfMsgIdNotSet
     * @throws MsgContentNotSetException
     * @throws \pvc\msg\err\NonExistentMessageException
     * @covers \pvc\msg\MsgFrmtr::format
     */
    public function testMsgThrowsExceptionIfMsgIdNotSet(): void
    {
        $msg = $this->createMock(MsgInterface::class);
        $msg->method('getMsgId')->willReturn(null);
        self::expectException(MsgContentNotSetException::class);
        $this->frmtr->format($msg);
    }

    /**
     * testMsgTthrowsExceptionIfMessageIsNotInCatalog
     * @throws MsgContentNotSetException
     * @throws NonExistentMessageException
     * @covers \pvc\msg\MsgFrmtr::format
     */
    public function testMsgThrowsExceptionIfMessageIsNotInCatalog(): void
    {
        $msgId = 'msgId';
        $domain = 'domain';
        $msg = $this->createMock(MsgInterface::class);
        $msg->method('contentIsSet')->willReturn(true);
        $msg->method('getMsgId')->willReturn($msgId);
        $msg->method('getDomain')->willReturn($domain);

        $this->catalog->method('getMessage')->with($msgId)->willReturn(null);
        self::expectException(NonExistentMessageException::class);
        $this->frmtr->format($msg);
    }
}
