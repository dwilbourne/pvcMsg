<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace tests\msg;

use Mockery;
use PHPUnit\Framework\TestCase;
use pvc\msg\HasMsgTrait;
use pvc\msg\MsgInterface;

/**
 * Class ErrmsgTraitTest
 * @covers \pvc\msg\HasMsgTrait
 */
class HasMsgTraitTest extends TestCase
{
    /**
     * testSetGetUnsetErrmsg
     */
    public function testSetGetUnsetErrmsg(): void
    {
        $msg = Mockery::mock(MsgInterface::class);

        $trait = new class () {
            use HasMsgTrait {
                setMsg as public;
                unsetMsg as public;
            }
        };

        /** @phpstan-ignore-next-line */
        $trait->setMsg($msg);
        self::assertEquals($msg, $trait->getMsg());
        /** @phpstan-ignore-next-line */
        $trait->unsetMsg();
        self::assertNull($trait->getMsg());
    }
}
