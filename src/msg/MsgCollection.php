<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvc\msg;

use Countable;
use Iterator;

/**
 * Certain libraries will return several errors all at once.  In order to be able to process those errors as a
 * block, this class provides the structure to store multiple messages.
 *
 * Class MsgCollection
 * @implements Iterator<MsgInterface>
 */
class MsgCollection implements Iterator, Countable
{
    /**
     * @var array<MsgInterface>
     */
    protected array $messages = [];

    /**
     * @var int|null
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
     * @return int
     */
    public function next(): int
    {
        return ++$this->pos;
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
     * @return int|void
     */
    public function count()
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
