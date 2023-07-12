<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\msg\err;

use PHPUnit\Framework\TestCase;
use pvc\msg\err\InvalidDomainCatalogFileException;

/**
 * Class InvalidDomainCatalogFileExceptionTest
 */
class InvalidDomainCatalogFileExceptionTest extends TestCase
{
    /**
     * testConstruct
     * @covers \pvc\msg\err\InvalidDomainCatalogFileException::__construct
     */
    public function testConstruct(): void
    {
        $exception = new InvalidDomainCatalogFileException();
        self::assertInstanceOf(InvalidDomainCatalogFileException::class, $exception);
    }
}
