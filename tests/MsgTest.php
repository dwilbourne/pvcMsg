<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\msg;

use DateTime;
use PHPUnit\Framework\TestCase;
use pvc\msg\Msg;

/**
 * Class MsgTest
 */
class MsgTest extends TestCase
{
    /**
     * @var Msg
     */
    protected Msg $msg;

    /**
     * @var string
     */
    protected string $msgId;

    /**
     * @var mixed[]
     */
    protected array $parameters;

    /**
     * @var string
     */
    protected string $domain;

    public function setUp(): void
    {
        $this->msgId = 'foo';
        $param1 = 'pvc is a great set of libraries.';
        $param2 = new DateTime('2002/12/13');
        $this->parameters = ['pvc_great' => $param1, 'date' => $param2];
        $this->domain = 'userMessages';
        $this->msg = new Msg();
    }

    /**
     * testSetGetMsgId
     * @covers \pvc\msg\Msg::setContent
     * @covers \pvc\msg\Msg::getMsgId
     */
    public function testSetGetMsgId(): void
    {
        $this->msg->setContent($this->domain, $this->msgId, $this->parameters);
        self::assertEquals($this->msgId, $this->msg->getMsgId());
    }

    /**
     * testSetGetParameters
     * @covers \pvc\msg\Msg::setContent
     * @covers \pvc\msg\Msg::getParameters
     */
    public function testSetGetParameters(): void
    {
        $this->msg->setContent($this->domain, $this->msgId, $this->parameters);
        self::assertEquals($this->parameters, $this->msg->getParameters());
    }

    /**
     * testSetGetDomain
     * @covers \pvc\msg\Msg::setContent
     * @covers \pvc\msg\Msg::getDomain
     */
    public function testSetGetDomain(): void
    {
        $this->msg->setContent($this->domain, $this->msgId, $this->parameters);
        self::assertEquals($this->domain, $this->msg->getDomain());
    }

    /**
     * testSetMsgContent
     * @covers \pvc\msg\Msg::setContent
     */
    public function testSetMsgContent(): void
    {
        $this->msg->setContent($this->domain, $this->msgId, $this->parameters);
        self::assertEquals($this->msgId, $this->msg->getMsgId());
        self::assertEquals($this->parameters, $this->msg->getParameters());
        self::assertEquals($this->domain, $this->msg->getDomain());
        self::assertTrue($this->msg->contentIsSet());
    }

    /**
     * testClear
     * @covers \pvc\msg\Msg::clearContent
     * @covers \pvc\msg\Msg::contentIsSet
     */
    public function testClearContent(): void
    {
        self::assertFalse($this->msg->contentIsSet());

        $this->msg->setContent($this->domain, $this->msgId, $this->parameters);
        self::assertTrue($this->msg->contentIsSet());

        $this->msg->clearContent();
        /**
         * trying to get either msgId or domain would produce an error
         */
        self::assertEmpty($this->msg->getParameters());

        self::assertFalse($this->msg->contentIsSet());
    }
}
