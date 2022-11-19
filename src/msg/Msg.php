<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvc\msg;

use pvc\interfaces\msg\MsgInterface;

/**
 * Class Msg
 */
class Msg implements MsgInterface
{
    /**
     * @var string
     */
    protected string $msgId;

	/**
	 * @var array<mixed>
	 */
    protected array $parameters;

    /**
     * @return string
     */
    public function getMsgId(): string
    {
        return $this->msgId;
    }

    /**
     * @param string $msgId
     */
    public function setMsgId(string $msgId): void
    {
        $this->msgId = $msgId;
    }

	/**
	 * @return array<mixed>
	 */
    public function getParameters(): array
    {
        return $this->parameters;
    }

	/**
	 * @param array<mixed> $parameters
	 */
    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * @param string $msgId
     * @param mixed[] $parameters
     */
	public function __construct(string $msgId, array $parameters = [])
	{
		$this->setMsgId($msgId);
		$this->setParameters($parameters);
	}
}
