<?php

declare (strict_types=1);
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvcTests\msg\err;

use PHPUnit\Framework\TestCase;
use pvc\msg\err\NonExistentDomainCatalogFileException;

class NonExistentDomainCatalogFileExceptionTest extends TestCase
{
    /**
     * testConstruct
     * @covers \pvc\msg\err\NonExistentDomainCatalogFileException::__construct
     */
    public function testConstruct(): void
    {
        $filename = 'somefile.php';
        $exception = new NonExistentDomainCatalogFileException($filename);
        self::assertInstanceOf(NonExistentDomainCatalogFileException::class, $exception);
    }

}
