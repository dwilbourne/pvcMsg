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
#[\PHPUnit\Framework\Attributes\CoversMethod(\pvc\msg\Msg::class, 'setContent')]
#[\PHPUnit\Framework\Attributes\CoversMethod(\pvc\msg\Msg::class, 'getMsgId')]
#[\PHPUnit\Framework\Attributes\CoversMethod(\pvc\msg\Msg::class, 'getParameters')]
#[\PHPUnit\Framework\Attributes\CoversMethod(\pvc\msg\Msg::class, 'getDomain')]
#[\PHPUnit\Framework\Attributes\CoversMethod(\pvc\msg\Msg::class, 'clearContent')]
#[\PHPUnit\Framework\Attributes\CoversMethod(\pvc\msg\Msg::class, 'contentIsSet')]
class MsgTest extends TestCase
{
    protected Msg $msg;

    /**
     * @var non-empty-string
     */
    protected string $msgId;

    /**
     * @var array<mixed>
     */
    protected array $parameters;

    /**
     * @var non-empty-string
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
     */
    public function testSetGetMsgId(): void
    {
        $this->msg->setContent($this->domain, $this->msgId, $this->parameters);
        self::assertEquals($this->msgId, $this->msg->getMsgId());
    }

    /**
     * testSetGetParameters
     */
    public function testSetGetParameters(): void
    {
        $this->msg->setContent($this->domain, $this->msgId, $this->parameters);
        self::assertEquals($this->parameters, $this->msg->getParameters());
    }

    /**
     * testSetGetDomain
     */
    public function testSetGetDomain(): void
    {
        $this->msg->setContent($this->domain, $this->msgId, $this->parameters);
        self::assertEquals($this->domain, $this->msg->getDomain());
    }

    /**
     * testSetMsgContent
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
