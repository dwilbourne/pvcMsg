<?php

declare(strict_types=1);

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace tests\msg;

use Mockery;
use PHPUnit\Framework\TestCase;
use pvc\interfaces\frmtr\msg\FrmtrMsgInterface;
use pvc\interfaces\msg\DomainCatalogInterface;
use pvc\interfaces\msg\MsgInterface;
use pvc\msg\MsgTranslator;

class MsgTranslatorTest extends TestCase
{
    protected DomainCatalogInterface $catalog;
    protected FrmtrMsgInterface $frmtr;
    protected MsgTranslator $translator;

    public function setUp(): void
    {
        /** @phpstan-ignore-next-line */
        $this->catalog = Mockery::mock(DomainCatalogInterface::class);
        /** @phpstan-ignore-next-line */
        $this->frmtr = Mockery::mock(FrmtrMsgInterface::class);

        $this->translator = new MsgTranslator($this->catalog, $this->frmtr);
    }

    /**
     * testSetGetDomainCatalog
     * @covers \pvc\msg\MsgTranslator::setCatalog
     * @covers \pvc\msg\MsgTranslator::getCatalog
     */
    public function testSetGetDomainCatalog(): void
    {
        $catalog = Mockery::mock(DomainCatalogInterface::class);
        $this->translator->setCatalog($catalog);
        self::assertEquals($catalog, $this->translator->getCatalog());
    }

    /**
     * testSetGetFrmtrMsg
     * @covers \pvc\msg\MsgTranslator::setFrmtr
     * @covers \pvc\msg\MsgTranslator::getFrmtr
     */
    public function testSetGetFrmtrMsg(): void
    {
        $frmtr = Mockery::mock(FrmtrMsgInterface::class);
        self::assertEquals($frmtr, $this->translator->getFrmtr());
    }

    /**
     * testConstruction
     * @covers \pvc\msg\MsgTranslator::__construct
     */
    public function testConstruction(): void
    {
        self::assertEquals($this->catalog, $this->translator->getCatalog());
        self::assertEquals($this->frmtr, $this->translator->getFrmtr());
    }

    /**
     * testTrans
     * @covers \pvc\msg\MsgTranslator::trans
     */
    public function testTrans(): void
    {
        $locale = 'fr_FR';
        $msgId = 'msgId';
        $msgText = 'some string';
        $parameters = [1 => "fiver"];

        /** @phpstan-ignore-next-line */
        $this->catalog->expects('getLocale')->withNoArgs()->andReturns($locale);
        /** @phpstan-ignore-next-line */
        $this->frmtr->expects('setLocale')->with($locale);

        $msg = Mockery::mock(MsgInterface::class);
        /** @phpstan-ignore-next-line */
        $msg->expects('getMsgId')->withNoArgs()->andReturns($msgId);
        /** @phpstan-ignore-next-line */
        $this->catalog->expects('getMessage')->with($msgId)->andReturns($msgText);
        /** @phpstan-ignore-next-line */
        $this->frmtr->expects('setFormat')->with($msgText);
        /** @phpstan-ignore-next-line */
        $msg->expects('getParameters')->withNoArgs()->andReturns($parameters);

        /** @phpstan-ignore-next-line */
        $expectedResult = "translated message";
        $this->frmtr->expects('format')->with($parameters)->andReturns($expectedResult);

        self::assertEquals($expectedResult, $this->translator->trans($msg));
    }
}
