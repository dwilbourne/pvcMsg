<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\msg;

use PHPUnit\Framework\TestCase;
use pvc\interfaces\msg\MsgInterface;
use pvc\msg\HasMsgTrait;

/**
 * Class ErrmsgTraitTest
 * @covers \pvc\msg\HasMsgTrait
 */
class HasMsgTraitTest extends TestCase
{
    /**
     * testSetGetUnsetErrmsg
     * @covers \pvc\msg\HasMsgTrait::setMsg
     * @covers \pvc\msg\HasMsgTrait::getMsg
     */
    public function testHasMsgTrait(): void
    {
        $mockTrait = $this->getMockForTrait(HasMsgTrait::class);
        $mockMsg = $this->createMock(MsgInterface::class);

        $mockTrait->setMsg($mockMsg);
        self::assertEquals($mockMsg, $mockTrait->getMsg());
    }
}
