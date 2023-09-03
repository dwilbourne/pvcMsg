<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare(strict_types=1);

namespace pvc\msg\err;

use pvc\err\stock\LogicException;
use Throwable;

/**
 * Class NonExistentMessageException
 */
class NonExistentMessageException extends LogicException
{
    public function __construct(string $msgId, Throwable $prev = null)
    {
        parent::__construct($msgId);
    }
}
