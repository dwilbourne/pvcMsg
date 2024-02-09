<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg\err;

use pvc\err\stock\LogicException;

/**
 * Class InvalidDomainException
 */
class InvalidDomainException extends LogicException
{
    public function __construct(string $invalidDomain, \Throwable $prev = null) {
        parent::__construct($invalidDomain, $prev);
    }
}
