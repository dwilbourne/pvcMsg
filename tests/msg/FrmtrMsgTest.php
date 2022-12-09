<?php

declare(strict_types=1);

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace tests\msg;

use MessageFormatter;
use Mockery;
use PHPUnit\Framework\TestCase;
use pvc\interfaces\frmtr\msg\FrmtrMsgInterface;
use pvc\interfaces\msg\DomainCatalogInterface;
use pvc\interfaces\msg\MsgInterface;
use pvc\msg\FrmtrMsg;

class FrmtrMsgTest extends TestCase
{
    protected DomainCatalogInterface $catalog;
    protected MessageFormatter $messageFormatter;
    protected FrmtrMsgInterface $frmtr;

    public function setUp(): void
    {
        $this->catalog = Mockery::mock(DomainCatalogInterface::class);
        $this->messageFormatter = Mockery::mock(MessageFormatter::class);
        $this->frmtr = new FrmtrMsg($this->catalog, $this->messageFormatter);
    }

    /**
     * testSetGetDomainCatalog
     * @covers FrmtrMsg::setDomainCatalog
     * @covers FrmtrMsg::getDomainCatalog
     */
    public function testSetGetDomainCatalog(): void
    {
        $catalog = Mockery::mock(DomainCatalogInterface::class);
        $this->frmtr->setDomainCatalog($catalog);
        self::assertEquals($catalog, $this->frmtr->getDomainCatalog());
    }

	/**
	 * testSetGetMessageFormatter
	 * @covers FrmtrMsg::getMessageFormatter
	 * @covers FrmtrMsg::setMessageFormatter
	 */
    public function testSetGetMessageFormatter(): void
    {
        $messageFormatter = Mockery::mock(MessageFormatter::class);
        $this->frmtr->setMessageFormatter($messageFormatter);
        self::assertEquals($messageFormatter, $this->frmtr->getMessageFormatter());
    }

    /**
     * testConstruction
     * @covers \pvc\msg\MsgTranslator::__construct
     */
    public function testConstruction(): void
    {
        self::assertEquals($this->catalog, $this->frmtr->getDomainCatalog());
        self::assertEquals($this->messageFormatter, $this->frmtr->getMessageFormatter());
    }

    /**
     * testFormat
     * @covers FrmtrMsg::format
     */
    public function testFormat(): void
    {
        $locale = 'fr_FR';
        $msgId = 'msgId';
        $msgText = 'some string';
        $parameters = [1 => "fiver"];

        $msg = Mockery::mock(MsgInterface::class);
        $msg->expects('getMsgId')->withNoArgs()->andReturns($msgId);

        $this->catalog->expects('getMessage')->with($msgId)->andReturns($msgText);
        $this->catalog->expects('getLocale')->withNoArgs()->andReturns($locale);

        $otherMockMessageFormatter = Mockery::mock(MessageFormatter::class);

        $this->messageFormatter->expects('create')
                               ->with([$locale, $msgText])
                                ->andReturns($otherMockMessageFormatter);

        $expectedResult = $msgText;

        $msg->expects('getParameters')->withNoArgs()->andReturns($parameters);
        $otherMockMessageFormatter->expects('format')
                                  ->with($parameters)
                                  ->andReturns($expectedResult);
		$actualResult = $this->frmtr->format($msg);

        self::assertEquals($expectedResult, $actualResult);
    }
}
