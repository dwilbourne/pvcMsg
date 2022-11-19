<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace tests\msg;

use DateTime;
use PHPUnit\Framework\TestCase;
use pvc\msg\Msg;

/**
 * Class MsgTest
 * @covers \pvc\msg\Msg
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

	public function setUp(): void
	{
		$this->msgId = 'foo';
		$param1 = 'pvc is a great set of libraries.';
		$param2 = new DateTime('2002/12/13');
		$this->parameters = ['pvc_great' => $param1, 'date' => $param2];
		$this->msg = new Msg($this->msgId, $this->parameters);
	}

	/**
	 * testSetGetMsgId
	 * @covers Msg::setMsgId
	 * @covers Msg::getMsgId
	 */
	public function testSetGetMsgId(): void
	{
		self::assertEquals($this->msgId, $this->msg->getMsgId());
	}

	/**
	 * testSetGetParameters
	 * @covers Msg::setParameters
	 * @covers Msg::getParameters
	 */
	public function testSetGetParameters(): void
	{
		self::assertEquals($this->parameters, $this->msg->getParameters());
	}
}
