<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\msg;

use IteratorAggregate;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\interfaces\msg\MsgInterface;
use pvc\msg\MsgCollection;

/**
 * Class MsgCollectionTest
 * @covers \pvc\msg\MsgCollection
 */
class MsgCollectionTest extends TestCase
{
    /**
     * @var MsgCollection
     */
    protected MsgCollection $msgCollection;

    /**
     * @var MsgInterface|MockObject|(MsgInterface&MockObject)
     */
    protected MsgInterface|MockObject $msg1;

    /**
     * @var MsgInterface|MockObject|(MsgInterface&MockObject)
     */
    protected MsgInterface|MockObject $msg2;

    /**
     * setUp
     */
    public function setUp(): void
    {
        $this->msgCollection = new MsgCollection();
        $this->msg1 = $this->createMock(MsgInterface::class);
        $this->msg2 = $this->createMock(MsgInterface::class);
    }

    /**
     * testIteratorInterface
     */
    public function testIteratorInterface(): void
    {
        self::assertTrue($this->msgCollection instanceof IteratorAggregate);
        self::assertEquals(0, count($this->msgCollection));
    }

    /**
     * testAdd
     * @covers \pvc\msg\MsgCollection::addMsg
     * @covers \pvc\msg\MsgCollection::count
     */
    public function testAdd(): MsgCollection
    {
        $this->msgCollection->addMsg($this->msg1);
        self::assertEquals(1, count($this->msgCollection));

        $this->msgCollection->addMsg($this->msg2);
        self::assertEquals(2, count($this->msgCollection));
        return $this->msgCollection;
    }

    /**
     * testIteration
     * @depends testAdd
     */
    public function testIteration(MsgCollection $msgCollection): void
    {
        $messages = [$this->msg1, $this->msg2];

        $i = 0;
        foreach ($msgCollection as $msg) {
            self::assertEquals($messages[$i++], $msg);
        }
    }

    /**
     * testGetMessages
     * @param MsgCollection $msgCollection
     * @depends testAdd
     */
    public function testGetMessages(MsgCollection $msgCollection): void
    {
        $msgArray = $msgCollection->getMessages();
        self::assertIsArray($msgArray);
        self::assertEquals(2, count($msgArray));
    }
}
