<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvc\msg;

use ArrayIterator;
use Countable;
use pvc\interfaces\msg\MsgInterface;

/**
 * Class MsgCollection
 * @extends ArrayIterator<int, MsgInterface>
 */
class MsgCollection extends ArrayIterator implements Countable
{
	/**
	 * @var MsgInterface[]
	 */
	protected array $messages = [];

	/**
	 * @var int
	 */
	private int $pos = 0;

	/**
	 * @function addMsg
	 * @param MsgInterface $msg
	 */
	public function addMsg(MsgInterface $msg): void
	{
		$this->messages[] = $msg;
	}

	/**
	 * @function rewind
	 */
	public function rewind(): void
	{
		$this->pos = 0;
	}

	/**
	 * @function current
	 * @return MsgInterface
	 */
	public function current(): MsgInterface
	{
		return $this->messages[$this->pos];
	}

	/**
	 * @function next
	 */
	public function next(): void
	{
		++$this->pos;
	}

	/**
	 * @function key
	 * @return int
	 */
	public function key(): int
	{
		return $this->pos;
	}

	/**
	 * @function valid
	 * @return bool
	 */
	public function valid(): bool
	{
		return isset($this->messages[$this->pos]);
	}

	/**
	 * @function count
	 * @return int
	 */
	public function count(): int
	{
		return count($this->messages);
	}

	/**
	 * getMsgId
	 * @return MsgInterface[]
	 */
	public function getMessages(): array
	{
		return $this->messages;
	}
}
