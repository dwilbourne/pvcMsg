<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\msg\err;

use pvc\err\XDataTestMaster;
use pvc\msg\err\_MsgXData;

/**
 * Class _MsgXDataTest
 */
#[\PHPUnit\Framework\Attributes\CoversMethod(\pvc\msg\err\_MsgXData::class, 'getLocalXCodes')]
#[\PHPUnit\Framework\Attributes\CoversMethod(\pvc\msg\err\_MsgXData::class, 'getXMessageTemplates')]
#[\PHPUnit\Framework\Attributes\CoversMethod(\pvc\msg\err\InvalidDomainCatalogFileException::class, '__construct')]
#[\PHPUnit\Framework\Attributes\CoversMethod(\pvc\msg\err\NonExistentDomainCatalogDirectoryException::class, '__construct')]
#[\PHPUnit\Framework\Attributes\CoversMethod(\pvc\msg\err\NonExistentDomainCatalogFileException::class, '__construct')]
class _MsgXDataTest extends XDataTestMaster
{
    /**
     * testLibrary
     */
    public function testLibrary(): void
    {
        $xData = new _MsgXData();
        self::assertTrue($this->verifyLibrary($xData));
    }
}
