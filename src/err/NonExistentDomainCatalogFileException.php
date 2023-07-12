<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\msg\err;

use pvc\err\stock\LogicException;
use Throwable;

/**
 * Class NonExistentDomainCatalogFileException
 */
class NonExistentDomainCatalogFileException extends LogicException
{
    public function __construct(string $filename, Throwable $prev = null)
    {
        parent::__construct($filename, $prev);
    }
}
