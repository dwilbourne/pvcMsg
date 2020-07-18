<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace tests\msg;

use PHPUnit\Framework\TestCase;
use pvc\msg\ErrorExceptionMsg;
use pvc\msg\Msg;
use pvc\msg\UserMsg;

class MsgInterchangeabilityTraitTest extends TestCase
{
    protected Msg $msg;

    public function setUp() : void
    {
        $msgVars = ['foo', 'bar'];
        $msgText = "%s is not %s.";
        $this->msg = new Msg($msgVars, $msgText);
    }

    public function testMakeErrorExceptionMsg() : void
    {
        self::assertInstanceof(ErrorExceptionMsg::class, $this->msg->makeErrorExceptionMsg());
    }

    public function testMakeUserMsg() : void
    {
        self::assertInstanceof(UserMsg::class, $this->msg->makeUserMsg());
    }
}
