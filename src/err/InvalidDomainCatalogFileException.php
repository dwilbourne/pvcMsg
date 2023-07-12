<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg\err;

use pvc\err\stock\LogicException;
use Throwable;

/**
 * Class InvalidDomainCatalogFileException
 */
class InvalidDomainCatalogFileException extends LogicException
{
    public function __construct(Throwable $prev = null)
    {
        parent::__construct($prev);
    }
}
