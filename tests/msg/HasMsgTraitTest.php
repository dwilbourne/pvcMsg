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
    public function testSetGetUnsetErrmsg(): void
    {
        $msg = Mockery::mock(MsgInterface::class);
        $trait = $this->getMockForTrait(HasMsgTrait::class);

        /** @noinspection PhpUndefinedMethodInspection */
        $trait->setMsg($msg);
        /** @noinspection PhpUndefinedMethodInspection */
        self::assertEquals($msg, $trait->getMsg());
        /** @noinspection PhpUndefinedMethodInspection */
        $trait->unsetMsg();
        /** @noinspection PhpUndefinedMethodInspection */
        self::assertNull($trait->getMsg());
    }
}
