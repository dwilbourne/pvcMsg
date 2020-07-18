<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace pvc\msg\err;

use pvc\err\throwable\ErrorExceptionConstants as ec;
use pvc\err\throwable\exception\stock_rebrands\Exception;

/**
 * Class InvalidMsgTextException
 */

class InvalidMsgTextException extends Exception
{
    public function __construct()
    {
        $code = ec::INVALID_MSGTEXT_EXCEPTION;
        $previous = null;
        parent::__construct(new InvalidMsgTextMsg(), $code, $previous);
    }
}