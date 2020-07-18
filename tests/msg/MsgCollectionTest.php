<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\msg;

use Iterator;
use Mockery;
use PHPUnit\Framework\TestCase;
use pvc\msg\Msg;
use pvc\msg\MsgCollection;
use pvc\msg\MsgFormatterInterface;
use pvc\msg\MsgRetrievalInterface;

class MsgCollectionTest extends TestCase
{

    protected MsgCollection $msgCollection;

    public function setUp(): void
    {
        $this->msgCollection = new MsgCollection();
    }

    public function testIteratorInterface() : void
    {
        self::assertTrue($this->msgCollection instanceof Iterator);
        self::assertEquals(0, count($this->msgCollection));
    }

    public function testAdd() : void
    {

        $msg_1 = Mockery::mock(Msg::class);
        $var_1 = 'foo';
        $text_1 = 'some message text = %s';
        $msg_1->shouldReceive('getMsgVars')->withNoArgs()->andReturn([$var_1]);
        $msg_1->shouldReceive('getMsgText')->withNoArgs()->andReturn($text_1);

        $msg_2 = Mockery::mock(Msg::class);
        $var_2 = 'bar';
        $text_2 = 'some new message text = %s';
        $msg_2->shouldReceive('getMsgVars')->withNoArgs()->andReturn([$var_2]);
        $msg_2->shouldReceive('getMsgText')->withNoArgs()->andReturn($text_2);

        /** @phpstan-ignore-next-line */
        $this->msgCollection->addMsg($msg_1);
        self::assertEquals(1, count($this->msgCollection));

        /** @phpstan-ignore-next-line */
        $this->msgCollection->addMsg($msg_2);
        self::assertEquals(2, count($this->msgCollection));

        $expectedResult = [$var_1, $var_2];
        self::assertEquals($expectedResult, $this->msgCollection->getMsgVars());

        $expectedResult = $text_1 . ' ' . $text_2;
        self::assertEquals($expectedResult, $this->msgCollection->getMsgText());
    }

    public function testIteration() : void
    {
        $msg1 = Mockery::mock(MsgRetrievalInterface::class);
        $msg2 = Mockery::mock(MsgRetrievalInterface::class);
        $messages = [$msg1, $msg2];
        $this->msgCollection->addMsg($msg1);
        $this->msgCollection->addMsg($msg2);

        $i = 0;
        foreach ($this->msgCollection as $msg) {
            self::assertEquals($i, $this->msgCollection->key());
            self::assertEquals($messages[$i++], $msg);
        }
    }

    public function testSetGetMsgFormatter() : void
    {
        self::assertInstanceOf(MsgFormatterInterface::class, $this->msgCollection->getMsgFormatter());
        $frmtr = Mockery::mock(MsgFormatterInterface::class);
        $this->msgCollection->setMsgFormatter($frmtr);
        self::assertEquals($frmtr, $this->msgCollection->getMsgFormatter());

    }

    public function testGetEmptyMsgText() : void
    {
        self::expectException(\Exception::class);
        $string = $this->msgCollection->getMsgText();
    }

    public function testToString() : void
    {
        $msg_1 = Mockery::mock(Msg::class);
        $var_1 = 'foo';
        $text_1 = 'some message text = %s';
        $msg_1->shouldReceive('getMsgVars')->withNoArgs()->andReturn([$var_1]);
        $msg_1->shouldReceive('getMsgText')->withNoArgs()->andReturn($text_1);
        $this->msgCollection->addMsg($msg_1);
        
        $frmtrOutput = $this->msgCollection->getMsgFormatter()->format($this->msgCollection);
        self::assertEquals($frmtrOutput, (string) $this->msgCollection);
    }

}
