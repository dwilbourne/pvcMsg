<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvc\msg;

trait HasMsgTrait
{
    protected MsgInterface $msg;

    public function setMsg(MsgInterface $msg): void
    {
        $this->msg = $msg;
    }

    public function unsetMsg(): void
    {
        unset($this->msg);
    }

    public function getMsg(): ?MsgInterface
    {
        return $this->msg ?? null;
    }
}
