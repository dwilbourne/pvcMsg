<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg\err;

use pvc\err\stock\LogicException;
use Throwable;

/**
 * Class UnknownLoaderTypeException
 */
class UnknownLoaderTypeException extends LogicException
{
    public function __construct(string $badLoaderType, Throwable $prev = null)
    {
        parent::__construct($badLoaderType, $prev);
    }
}
