<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace tests\msg;

use pvc\msg\MsgFormatterDefault;
use PHPUnit\Framework\TestCase;
use pvc\msg\Msg;
use pvc\msg\MsgFormatterInterface;

class MsgFormatterDefaultTest extends TestCase
{
    protected MsgFormatterInterface $formatter;
    protected Msg $msg;

    public function setUp() : void
    {
        $msgVars = ['foo', 'bar', 'baz'];
        $msgText = "(%s) one variable (%s) is not the same as another (%s).";
        $this->msg = new Msg($msgVars, $msgText);

        $this->formatter = new MsgFormatterDefault();
    }

    public function testSetGetOutputMsgVarsValue() : void
    {
        self::assertFalse($this->formatter->getOutputMsgVarsValue());
        $this->formatter->outputMsgVars(true);
        self::assertTrue($this->formatter->getOutputMsgVarsValue());
    }

    public function testFormat() : void
    {
        $expectedValue = "one variable is not the same as another.";
        self::assertEquals($expectedValue, (string) $this->formatter->format($this->msg));
    }

}
