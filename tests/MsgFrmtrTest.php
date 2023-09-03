<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\msg;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\interfaces\msg\DomainCatalogInterface;
use pvc\interfaces\msg\MsgInterface;
use pvc\msg\err\MsgIdNotSetException;
use pvc\msg\err\NonExistentMessageException;
use pvc\msg\MsgFrmtr;

class MsgFrmtrTest extends TestCase
{
    /**
     * @var DomainCatalogInterface|MockObject|(DomainCatalogInterface&MockObject)
     */
    protected DomainCatalogInterface $catalog;

    /**
     * @var MsgFrmtr
     */
    protected MsgFrmtr $frmtr;

    public function setUp(): void
    {
        $this->catalog = $this->createMock(DomainCatalogInterface::class);
        $this->frmtr = new MsgFrmtr($this->catalog);
    }

    /**
     * testConstructSetGetDomainCatalog
     * @covers \pvc\msg\MsgFrmtr::__construct
     * @covers \pvc\msg\MsgFrmtr::setDomainCatalog
     * @covers \pvc\msg\MsgFrmtr::getDomainCatalog
     */
    public function testConstructSetGetDomainCatalog(): void
    {
        self::assertEquals($this->catalog, $this->frmtr->getDomainCatalog());
    }

    /**
     * testFormat
     * @covers \pvc\msg\MsgFrmtr::format
     */
    public function testFormat(): void
    {
        $locale = 'fr_FR';
        $msgId = 'msgId';
        $msgText = 'some string';
        $parameters = [1 => 'fiver'];

        $msg = $this->createMock(MsgInterface::class);
        $msg->method('getMsgId')->willReturn($msgId);

        $this->catalog->method('getMessage')->with($msgId)->willReturn($msgText);
        $this->catalog->method('getLocale')->willReturn($locale);

        $expectedResult = $msgText;

        $msg->method('getParameters')->willReturn($parameters);
        $actualResult = $this->frmtr->format($msg);

        self::assertEquals($expectedResult, $actualResult);
    }

    /**
     * testMsgThrowsExceptionIfMsgIdNotSet
     * @throws MsgIdNotSetException
     * @throws \pvc\msg\err\NonExistentMessageException
     * @covers \pvc\msg\MsgFrmtr::format
     */
    public function testMsgThrowsExceptionIfMsgIdNotSet(): void
    {
        $msg = $this->createMock(MsgInterface::class);
        $msg->method('getMsgId')->willReturn(null);
        self::expectException(MsgIdNotSetException::class);
        $this->frmtr->format($msg);
    }

    /**
     * testMsgTthrowsExceptionIfMessageIsNotInCatalog
     * @throws MsgIdNotSetException
     * @throws NonExistentMessageException
     * @covers \pvc\msg\MsgFrmtr::format
     */
    public function testMsgTthrowsExceptionIfMessageIsNotInCatalog(): void
    {
        $msgId = 'msgId';
        $msg = $this->createMock(MsgInterface::class);
        $msg->method('getMsgId')->willReturn($msgId);

        $this->catalog->method('getMessage')->with($msgId)->willReturn(null);
        self::expectException(NonExistentMessageException::class);
        $this->frmtr->format($msg);
    }
}
