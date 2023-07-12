<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use pvc\interfaces\msg\MsgInterface;

/**
 * Class MsgCollection
 * @implements IteratorAggregate<int, MsgInterface>
 */
class MsgCollection implements IteratorAggregate, Countable
{
    /**
     * @var array<int, MsgInterface>
     */
    protected array $messages = [];

    /**
     * @function addMsg
     * @param MsgInterface $msg
     */
    public function addMsg(MsgInterface $msg): void
    {
        $this->messages[] = $msg;
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
     * getMessages
     * @return MsgInterface[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * getIterator
     * @return ArrayIterator<int, MsgInterface>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->messages);
    }
}
