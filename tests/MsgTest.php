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
        $this->msg = new Msg($this->msgId, $this->parameters, $this->domain);
    }

    /**
     * testSetGetMsgId
     * @covers \pvc\msg\Msg::__construct
     * @covers \pvc\msg\Msg::setMsgId
     * @covers \pvc\msg\Msg::getMsgId
     */
    public function testSetGetMsgId(): void
    {
        self::assertEquals($this->msgId, $this->msg->getMsgId());
    }

    /**
     * testSetGetParameters
     * @covers \pvc\msg\Msg::__construct
     * @covers \pvc\msg\Msg::setParameters
     * @covers \pvc\msg\Msg::getParameters
     */
    public function testSetGetParameters(): void
    {
        self::assertEquals($this->parameters, $this->msg->getParameters());
    }

    /**
     * testSetGetDomain
     * @covers \pvc\msg\Msg::__construct
     * @covers \pvc\msg\Msg::setDomain
     * @covers \pvc\msg\Msg::getDomain
     */
    public function testSetGetDomain(): void
    {
        self::assertEquals($this->domain, $this->msg->getDomain());
    }
}
