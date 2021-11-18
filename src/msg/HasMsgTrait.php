<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvc\msg;

trait HasMsgTrait
{
    protected MsgInterface $msg;

    protected function setMsg(MsgInterface $msg): void
    {
        $this->msg = $msg;
    }

    protected function unsetMsg(): void
    {
        unset($this->msg);
    }

    public function getMsg(): ?MsgInterface
    {
        return $this->msg ?? null;
    }
}
