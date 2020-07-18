<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace tests\msg;

use pvc\msg\MsgVarsOutputTrait;
use PHPUnit\Framework\TestCase;
use pvc\msg\Msg;

class MsgVarsOutputTraitTest extends TestCase
{
    protected Msg $msg;

    public function setUp() : void
    {
        $msgVars = ['foo', 'bar', 'baz'];
        $msgText = "(%s) one variable (%s) is not the same as another (%s).";
        $this->msg = new Msg($msgVars, $msgText);
    }

    public function testOutputMsgVars() : void
    {
        self::assertFalse($this->msg->getOutputMsgVarsValue());
        $this->msg->outputMsgVars(true);
        self::assertTrue($this->msg->getOutputMsgVarsValue());
    }

    public function testToString() : void
    {
        $expectedValue = "one variable is not the same as another.";
        self::assertEquals($expectedValue, (string) $this->msg);
    }

}
