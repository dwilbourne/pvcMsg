<?php

declare(strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvc\msg\err\exceptions;

use pvc\err\Exception;
use pvc\msg\err\ExceptionConstants;
use pvc\msg\MsgInterface;
use Throwable;

/**
 * Class InvalidMsgTextException
 */
class InvalidMsgTextException extends Exception
{
    /**
     * @param MsgInterface $msg
     * @param Throwable|null $previous
     */
    public function __construct(MsgInterface $msg, Throwable $previous = null)
    {
        parent::__construct($msg, $previous);
        $this->code = ExceptionConstants::INVALID_MSGTEXT_EXCEPTION;
    }
}
