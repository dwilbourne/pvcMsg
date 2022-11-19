<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace tests\msg;

use Mockery;
use PHPUnit\Framework\TestCase;
use pvc\interfaces\msg\DomainCatalogInterface;
use pvc\msg\MsgTranslator;

class MsgTranslatorTest extends TestCase
{
    protected DomainCatalogInterface $catalog;
    protected MsgTranslator $translator;

    public function setUp() : void
    {
        /** @phpstan-ignore-next-line */
        $this->catalog = Mockery::mock(DomainCatalogInterface::class);
        $this->translator = new MsgTranslator($this->catalog);
    }

    /**
     * testSetGetTranslator
     * @covers \pvc\msg\MsgTranslator::setCatalog
     * @covers \pvc\msg\MsgTranslator::getCatalog
     */
    public function testSetGetTranslator() : void
    {
        $catalog = Mockery::mock(DomainCatalogInterface::class);
        $this->translator->setCatalog($catalog);
        self::assertEquals($catalog, $this->translator->getCatalog());
    }

    /**
     * testConstruction
     * @covers \pvc\msg\MsgTranslator::__construct
     */
    public function testConstruction() : void
    {
        $translator = new MsgTranslator($this->catalog);
        self::assertEquals($this->catalog, $translator->getCatalog());
    }

    /**
     * testTrans
     * @covers \pvc\msg\MsgTranslator::trans
     */
    public function testTrans() : void
    {
        $locale = 'fr';
        /** @phpstan-ignore-next-line */
        $this->catalog->expects('getLocale')->withNoArgs()->andReturns($locale);

        $msgId = 'msgId';
        $msg = 'some string';
        /** @phpstan-ignore-next-line */
        $this->catalog->expects('getMessage')->with($msgId)->andReturns($msg);

        // just to make the terminology clean: a message from the catalog is used as a pattern in
        // the international message formatter
        $pattern = $msg;

        // there are no placeholders in the message so the parameters will be ignored in the
        // MessageFormatter::format call under the covers
        $parameters = ['foo' => 'bar'];

        self::assertEquals($msg, $this->translator->trans($msgId, $parameters));
    }
}
