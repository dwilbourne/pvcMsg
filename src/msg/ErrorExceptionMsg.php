<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\msg;

/**
 * Class ErrorExceptionMsg
 */
class ErrorExceptionMsg extends Msg implements ErrorExceptionMsgInterface
{
    public function format() : string
    {
        // always output msgVars for ErrorException messages
        $this->getMsgFormatter()->outputMsgVars(true);
        return parent::format();
    }
}
