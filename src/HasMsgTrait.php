<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg;

use pvc\interfaces\msg\MsgInterface;

/**
 * Trait HasMsgTrait
 */
trait HasMsgTrait
{
    /**
     * @var MsgInterface
     */
    protected MsgInterface $msg;

    /**
     * setMsg
     * @param MsgInterface $msg
     */
    public function setMsg(MsgInterface $msg): void
    {
        $this->msg = $msg;
    }

    /**
     * unsetMsg
     */
    public function unsetMsg(): void
    {
        unset($this->msg);
    }

    /**
     * getMsg
     * @return MsgInterface|null
     */
    public function getMsg(): ?MsgInterface
    {
        return $this->msg ?? null;
    }
}
