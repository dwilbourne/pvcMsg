<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace pvc\msg;

/**
 * Trait MsgInterchangeabilityTrait.  Allows interchangeability between UserMsgs and ErrorExceptionMsgs
 * @package pvc\msg
 */
trait MsgInterchangeabilityTrait
{
    /**
     * @function makeErrorExceptionMsg
     * @return ErrorExceptionMsg
     */
    public function makeErrorExceptionMsg(): ErrorExceptionMsg
    {
        return new ErrorExceptionMsg($this->getMsgVars(), $this->getMsgText());
    }

    /**
     * makeUserMsg
     * @return UserMsg
     */
    public function makeUserMsg() : UserMsg
    {
        return new UserMsg($this->getMsgVars(), $this->getMsgText());
    }
}
