<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvc\msg;

use Countable;
use Iterator;
use pvc\msg\err\exceptions\InvalidMsgTextException;
use pvc\msg\err\messages\InvalidMsgTextMsg;

/**
 * MsgCollection honors MsgInterface while providing a way to package a group of messages into a single object.
 *
 * Certain libraries will return several errors all at once.  In order to be able to process those errors as a
 * block, this class provides the structure to store multiple messages.
 *
 * Class MsgCollection
 */
class MsgCollection implements Iterator, Countable, MsgInterface
{
    /**
     * @var MsgInterface[]
     */
    protected array $messages = [];

    /**
     * @var int
     */
    private int $pos;

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
     * @return mixed
     */
    public function current()
    {
        return $this->messages[$this->pos];
    }

    /**
     * @function next
     * @return int|void
     */
    public function next()
    {
        return ++$this->pos;
    }

    /**
     * @function key
     * @return bool|float|int|string|null
     */
    public function key()
    {
        return $this->pos;
    }

    /**
     * @function valid
     * @return bool
     */
    public function valid()
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
     * getMsgText
     * @return string
     */
    public function getMsgText(): string
    {
        $msgText = '';
        foreach ($this->messages as $msg) {
            $msgText .= $msg->getMsgText() . ' ';
        }
        $msgText = substr($msgText, 0, -1);

        if (empty($msgText)) {
            $msg = new InvalidMsgTextMsg();
            throw new InvalidMsgTextException($msg);
        } else {
            return $msgText;
        }
    }

    /**
     * getMsgVars
     * @return string[]
     */
    public function getMsgVars(): array
    {
        $msgVars = [];
        foreach ($this->messages as $msg) {
            $msgVars[] = $msg->getMsgVars();
        }
        return call_user_func_array('array_merge', $msgVars);
    }
}
