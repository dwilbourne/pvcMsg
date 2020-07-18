<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace pvc\msg\err;

use pvc\msg\ErrorExceptionMsg;

/**
 * Class InvalidMsgTextMsg
 */
class InvalidMsgTextMsg extends ErrorExceptionMsg
{
    public function __construct()
    {
        $msgText = 'message text cannot be exmpty.';
        $msgVars = [];
        parent::__construct($msgVars, $msgText);
    }
}