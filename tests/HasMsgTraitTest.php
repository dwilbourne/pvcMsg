<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\msg;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\interfaces\msg\MsgInterface;
use pvc\msg\HasMsgTrait;

/**
 * Class ErrmsgTraitTest
 * @covers \pvc\msg\HasMsgTrait
 */
class HasMsgTraitTest extends TestCase
{
    protected MockObject $mockTrait;

    public function setUp(): void
    {
        $this->mockTrait = $this->getMockForTrait(HasMsgTrait::class);
    }
    /**
     * testSetGetUnsetErrmsg
     * @covers \pvc\msg\HasMsgTrait::setMsg
     * @covers \pvc\msg\HasMsgTrait::getMsg
     */
    public function testHasMsgTrait(): void
    {
        $mockMsg = $this->createMock(MsgInterface::class);
        $this->mockTrait->setMsg($mockMsg);
        self::assertEquals($mockMsg, $this->mockTrait->getMsg());
    }
}
