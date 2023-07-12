<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\msg\err;

use PHPUnit\Framework\TestCase;
use pvc\msg\err\NonExistentDomainCatalogDirectoryException;

class NonExistentDomainCatalogDirectoryExceptionTest extends TestCase
{
    /**
     * testConstruct
     * @covers \pvc\msg\err\NonExistentDomainCatalogDirectoryException::__construct
     */
    public function testConstruct(): void
    {
        $badDirname = '/someBadDirectory';
        $exception = new NonExistentDomainCatalogDirectoryException($badDirname);
        self::assertInstanceOf(NonExistentDomainCatalogDirectoryException::class, $exception);
    }
}
