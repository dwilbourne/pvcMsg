<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg\err;

use pvc\err\stock\LogicException;
use Throwable;

/**
 * Class MissingLoaderConfigParameterException
 */
class MissingLoaderConfigParameterException extends LogicException
{
    public function __construct(string $missingParamName, Throwable $prev = null)
    {
        parent::__construct($missingParamName, $prev);
    }
}
