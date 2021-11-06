<?php

declare (strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvc\msg;

trait ErrmsgTrait
{
    protected MsgInterface $errmsg;

    public function setErrmsg(MsgInterface $errmsg): void
    {
        $this->errmsg = $errmsg;
    }

    public function unsetErrmsg() : void
    {
        unset($this->errmsg);
    }

    public function getErrmsg(): ?MsgInterface
    {
        return $this->errmsg ?? null;
    }

}