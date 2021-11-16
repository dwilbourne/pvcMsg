<?php

declare (strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace tests\msg\err\messages;

use PHPUnit\Framework\TestCase;
use pvc\msg\err\messages\InvalidMsgTextMsg;

/**
 * Class InvalidMsgTextMsgTest
 * @covers \pvc\msg\err\messages\InvalidMsgTextMsg
 */
class InvalidMsgTextMsgTest extends TestCase
{
    public function testInvalidMsgTextMsg(): void
    {
        $msg = new InvalidMsgTextMsg();
        self::assertInstanceOf(InvalidMsgTextMsg::class, $msg);
    }
}
