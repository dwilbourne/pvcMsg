<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\msg;

use Countable;
use Iterator;
use IteratorIterator;

/**
 * MsgCollection honors MsgRetrievalInterface while providing a way to package a group of messages into a single object.
 *
 * Certain libraries will return several errors all at once.  In order to be able to process those errors as a
 * block, this class provides the structure to store multiple messages.
 *
 * Class MsgCollection
 *
 * @implements Iterator<int, MsgRetrievalInterface>
 */
class MsgCollection implements Iterator, Countable, MsgRetrievalInterface
{
    use MsgVarsOutputTrait;
    use MsgInterchangeabilityTrait;

    /**
     * @var MsgRetrievalInterface[]
     */
    protected array $messages = [];

    /**
     * @var int
     */
    private int $pos;

    /**
     * @function addMsg
     * @param MsgRetrievalInterface $msg
     */
    public function addMsg(MsgRetrievalInterface $msg): void
    {
        $this->messages[] = $msg;
    }

    /**
     * @function rewind
     */
    public function rewind() : void
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
        return substr($msgText, 0, -1);
    }

    /**
     * getMsgVars
     * @return mixed[]
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
