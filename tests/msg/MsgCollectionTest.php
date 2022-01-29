<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace tests\msg;

use Iterator;
use Mockery;
use PHPUnit\Framework\TestCase;
use pvc\msg\Msg;
use pvc\msg\MsgCollection;
use pvc\msg\MsgInterface;

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
     * setUp
     */
    public function setUp(): void
    {
        $this->msgCollection = new MsgCollection();
    }

    /**
     * testIteratorInterface
     */
    public function testIteratorInterface(): void
    {
        self::assertTrue($this->msgCollection instanceof Iterator);
        self::assertEquals(0, count($this->msgCollection));
    }

    /**
     * testAdd
     */
    public function testAdd(): MsgCollection
    {
        $msg_1 = Mockery::mock(Msg::class);
        $msg_2 = Mockery::mock(Msg::class);

        /** @phpstan-ignore-next-line */
        $this->msgCollection->addMsg($msg_1);
        self::assertEquals(1, count($this->msgCollection));

        /** @phpstan-ignore-next-line */
        $this->msgCollection->addMsg($msg_2);
        self::assertEquals(2, count($this->msgCollection));
        return $this->msgCollection;
    }

    /**
     * testIteration
     */
    public function testIteration(): void
    {
        $msg1 = Mockery::mock(MsgInterface::class);
        $msg2 = Mockery::mock(MsgInterface::class);
        $messages = [$msg1, $msg2];
        $this->msgCollection->addMsg($msg1);
        $this->msgCollection->addMsg($msg2);

        $i = 0;
        foreach ($this->msgCollection as $msg) {
            self::assertEquals($i, $this->msgCollection->key());
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
        self::assertEquals(2, count($msgArray));
    }
}
